<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\PayloadReader;
use OCA\PeppolNext\PonderSource\EBMS\MessageInfo;
use OCA\PeppolNext\Service\MessageService;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\MessageBuilder;
use OCA\PeppolNext\Service\UploadService;
use OCA\PeppolNext\PonderSource\Envelope\Envelope;
use OCA\PeppolNext\PonderSource\Envelope\Body;
use OCA\PeppolNext\PonderSource\Envelope\Header;
use OCA\PeppolNext\PonderSource\EBMS\CollaborationInfo;
use OCA\PeppolNext\PonderSource\EBMS\Messaging;
use OCA\PeppolNext\PonderSource\EBMS\PartInfo;
use OCA\PeppolNext\PonderSource\EBMS\Party;
use OCA\PeppolNext\PonderSource\EBMS\PartyId;
use OCA\PeppolNext\PonderSource\EBMS\PartyInfo;
use OCA\PeppolNext\PonderSource\EBMS\PayloadInfo;
use OCA\PeppolNext\PonderSource\EBMS\Property;
use OCA\PeppolNext\PonderSource\EBMS\Receipt;
use OCA\PeppolNext\PonderSource\EBMS\SignalMessage;
use OCA\PeppolNext\PonderSource\EBMS\UserMessage;
use OCA\PeppolNext\PonderSource\WSSec\Security;
use OCA\PeppolNext\PonderSource\EBMS\Service;
use OCA\PeppolNext\PonderSource\WSSec\CanonicalizationMethod\C14NExclusive;
use OCA\PeppolNext\PonderSource\WSSec\DigestMethod\SHA256;
use OCA\PeppolNext\PonderSource\WSSec\DSigReference;
use OCA\PeppolNext\PonderSource\WSSec\SignatureMethod\RsaSha256;
use OCA\PeppolNext\PonderSource\WSSec\Transform;
use OCA\PeppolNext\PonderSource\EBBP\MessagePartNRInformation;
use OCA\PeppolNext\PonderSource\SMP\SMP;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataDisplayResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\Files\IRootFolder;
use OCP\IRequest;
use OCP\Contacts\IManager;

use phpseclib3\Crypt\{RSA, Random};
use phpseclib3\File\X509;
use JMS\Serializer\SerializerBuilder;
use OCA\PeppolNext\PonderSource\SBD\DocumentIdentification;
use OCA\PeppolNext\PonderSource\SBD\Identifier;
use OCA\PeppolNext\PonderSource\SBD\Receiver;
use OCA\PeppolNext\PonderSource\SBD\Scope;
use OCA\PeppolNext\PonderSource\SBD\Sender;
use OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocument;
use OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocumentHeader;
use OCA\PeppolNext\PonderSource\UBL\Invoice\AccountingCustomerParty;
use OCA\PeppolNext\PonderSource\UBL\Invoice\AccountingSupplierParty;
use OCA\PeppolNext\PonderSource\UBL\Invoice\AllowanceCharge;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Amount;
use OCA\PeppolNext\PonderSource\UBL\Invoice\ClassifiedTaxCategory;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Contact;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Country;
use OCA\PeppolNext\PonderSource\UBL\Invoice\CountryCode;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Delivery;
use OCA\PeppolNext\PonderSource\UBL\Invoice\DeliveryLocation;
use OCA\PeppolNext\PonderSource\UBL\Invoice\EndpointID;
use OCA\PeppolNext\PonderSource\UBL\Invoice\FinancialInstitutionBranch;
use OCA\PeppolNext\PonderSource\UBL\Invoice\ID;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Invoice;
use OCA\PeppolNext\PonderSource\UBL\Invoice\InvoiceLine;
use OCA\PeppolNext\PonderSource\UBL\Invoice\InvoicePeriod;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Item;
use OCA\PeppolNext\PonderSource\UBL\Invoice\LegalMonetaryTotal;
use OCA\PeppolNext\PonderSource\UBL\Invoice\OrderReference;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Party as InvoiceParty;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PartyIdentification;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PartyLegalEntity;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PartyName;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PartyTaxScheme;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PayeeFinancialAccount;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentMeans;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentMeansCode;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentTerms;
use OCA\PeppolNext\PonderSource\UBL\Invoice\PostalAddress;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Price;
use OCA\PeppolNext\PonderSource\UBL\Invoice\Quantity;
use OCA\PeppolNext\PonderSource\UBL\Invoice\TaxCategory;
use OCA\PeppolNext\PonderSource\UBL\Invoice\TaxScheme;
use OCA\PeppolNext\PonderSource\UBL\Invoice\TaxSubtotal;
use OCA\PeppolNext\PonderSource\UBL\Invoice\TaxTotal;

class MessageApiController extends ApiController {

	/** @var string */
	private $userId;
	/** @var IRootFolder */
	private $rootFolder;
	/** @var IManager */
	private $contactManager;

	/** @var MessageService */
	private $messageService;

	private UploadService $uploadService;
	use Errors;

	public function __construct(IRequest $request,
								IRootFolder $rootFolder,
								MessageService $messageService,
								UploadService $uploadService,
								$userId) {
		parent::__construct("peppolnext", $request);
		$this->userId = $userId;
		$this->rootFolder = $rootFolder;
		$this->messageService = $messageService;
		$this->uploadService = $uploadService;
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataDisplayResponse {
		$type = $this->request->getParam("type");
		$direction = ($type === "Inbox") ? Constants::RECEIVE_DIRECTION : Constants::SEND_DIRECTION;
		$response = $this->messageService->getAllInvoices($direction);
		return new DataResponse(
			[
				"items" => $response,
				"totalCount" => count($response)
			]);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function create() {
		$body = $this->request->getParam("body");
		$messageBuilder = new MessageBuilder($body);
		if ($messageBuilder->hasError()){
			return new DataResponse(["success"=> false, "errors" => $messageBuilder->getErrors()]);
		}
		$fileName = $this->getFileName($messageBuilder->getOrderReference());
		$content = $this->messageService->serializeXML($messageBuilder);
		$this->messageService->save($content, $fileName);
		$this->messageService->send($messageBuilder->getReceiver()->uid, $fileName, $messageBuilder->getMediaType());
		return new DataResponse(["success"=> true, "errors"=>[]]);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function getNewReceivedMessages(){
		$page = $this->request->getParam("page") ;
		$response  = $this->messageService->getNewInvoices($page);
		return new DataResponse($response, Http::STATUS_OK);

	}

	/**
	 * @return DataResponse
	 */
	public function markAsRead() : DataResponse{
		try {
			$fileName = $this->request->getParam("filename");
			$this->messageService->markAsRead($fileName);
			return new DataResponse(["message"=> "done"], Http::STATUS_OK);
		}catch (\Throwable $ex){
			return new DataResponse(["message"=> $ex->getMessage()], Http::STATUS_CONFLICT);
		}
	}

	/**
	* @return DataResponse
	*/
	public function delete() : DataResponse {
		try {
			$fileName = $this->request->getParam("filename");
			$this->messageService->delete($fileName);
			return new DataResponse(["message"=> "done"], Http::STATUS_OK);
		} catch (\Throwable $ex) {
			return new DataResponse(["message"=> $ex->getMessage()], Http::STATUS_CONFLICT);
		}
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function getNotification(){
		return new DataResponse($this->messageService->getNotifications(), Http::STATUS_OK);
	}

	private function getFileName($orderName) :string{
		return $orderName."-". (new \DateTime())->format("Y-m-d").".xml";
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 * @CORS
	 */
	public function as4Endpoint() {
		$peppolNext_identifier = '0106:80235875'; // TODO

		//$output = var_export($this->request->post, true);
		$contentType = $this->request->getHeader('Content-Type');
		$boundryStart = strpos($contentType, 'boundary="');
		$boundryEnd = strpos($contentType, '"', $boundryStart + 10);
		$boundry = substr($contentType, $boundryStart + 10, $boundryEnd - $boundryStart - 10);
		$boundryLength = strlen($boundry);

		$body = file_get_contents('php://input');


		$pointer = strpos($body, $boundry);
		$pointer = strpos($body, "\r\n\r\n", $pointer);
		$envelopeStart = $pointer + 4;

		$pointer = strpos($body, $boundry, $envelopeStart);
		$envelopeEnd = $pointer - 4;

		$envelope = substr($body, $envelopeStart, $envelopeEnd - $envelopeStart);

		$pointer = strpos($body, "\r\n\r\n", $pointer);
		$payloadStart = $pointer + 4;

		$pointer = strpos($body, $boundry, $payloadStart);
		$payloadEnd = $pointer - 4;

		$payload = substr($body, $payloadStart, $payloadEnd - $payloadStart);

		// $keystore_file = '/p12transport/test.p12';
		$keystore_file = '/home/yasharpm/pondersource/keys/test.p12';
		$passphrase = 'peppol';

		if (!$cert_store = file_get_contents($keystore_file)) {
			echo "Error: Unable to read the cert file\n";
			exit;
		}
		
		if (openssl_pkcs12_read($cert_store, $cert_info, $passphrase)) {
		} else {
			echo "Error: Unable to read the cert store.\n";
			exit;
		}
		
		$private_key = RSA::loadPrivateKey($cert_info['pkey']);

		$cert = new X509;
		$cert->loadX509($cert_info['cert']);
		
		list($envelope, $invoice, $decrypted_payload) = PayloadReader::readPayload($envelope, $payload, $cert, $private_key);

		$messageProperties = $envelope->getHeader()->getMessaging()->getUserMessage()->getMessageProperties();

		$sender_id = false;
		$recipient_id = false;

		foreach ($messageProperties as $property) {
			if ($property->getName() === 'originalSender') {
				$sender_id = $property->getValue();
			}
			else if ($property->getName() === 'finalRecipient') {
				$recipient_id = $property->getValue();
			}
		}

		$useSMP = false;

		if ($useSMP) {
			$isProduction = false;
			list($sender_endpoint, $sender_certificate) = SMP::lookup($sender_id, $isProduction);
		}
		else {
			$sender_certificate = new X509;
			// $sender_certificate->loadX509(file_get_contents('/opt/temp/yashar_pc/sender.cer'));
			$sender_certificate->loadX509(file_get_contents('/home/yasharpm/pondersource/keys/sender.cer'));
		}

		$sender_public_key = $sender_certificate->getPublicKey();

		$verifyResult = $envelope->getHeader()->getSecurity()->getSignature()->verify($envelope, $decrypted_payload, $sender_public_key);
		error_log('YAAAAAAAAAYYYYYYY signature checked: '.var_export($verifyResult, true));
		if (!$verifyResult) return false;

		$output = var_export($invoice, true);
		error_log($output);


		/////////////// MESSAGE FORWARDING ///////////////
		$should_forward = true;

		if ($should_forward) {
			error_log("forwarding to $recipient_id");
			$success = $this->as4SendWithIdentifier($invoice, $recipient_id);
			error_log("forward result is: $success");
		}
		//////////////////////////////////////////////////


		$messagingId = uniqid('peppolnext-msg-');
		$bodyId = uniqid('id-');

		$nonRepudiationInformation = [];

		foreach ($envelope->getHeader()->getSecurity()->getSignature()->getSignedInfo()->getReferences() as $reference) {
			$nonRepudiationInformation[] = (new MessagePartNRInformation())->addReference($reference);
		}

		$response = new Envelope(
			new Header(
				new Security(

				),
				new Messaging(null, new SignalMessage(
					new MessageInfo(
						new \DateTime(),
						uniqid().'@peppolnext',
						$envelope->getHeader()->getMessaging()->getUserMessage()->getMessageInfo()->getMessageId()),
					new Receipt($nonRepudiationInformation),
					null
				), $messagingId)
			),
			new Body($bodyId)
		);

		$sha256 = new SHA256();
		$c14ne = new Transform("http://www.w3.org/2001/10/xml-exc-c14n#");  //C14NExcTransform();

		$serializer = SerializerBuilder::create()->build();
		$serializedMessaging = $serializer->serialize($response->getHeader()->getMessaging(), 'xml');
		$serializedMessaging = str_replace("  ", '', str_replace("\n", '', $serializedMessaging));
		$serializedBody = $serializer->serialize($response->getBody(), 'xml');
		$serializedBody = str_replace("  ", '', str_replace("\n", '', $serializedBody));

		$references = [
			new DSigReference("#$messagingId", $serializedMessaging, [$c14ne], $sha256),
			new DSigReference("#$bodyId", $serializedBody, [$c14ne], $sha256)
		];

		$response->getHeader()->getSecurity()->generateSignature($private_key, $cert, $references, new C14NExclusive(), new RsaSha256(), $response);

		$serializedCanonicalizedResponse = $c14ne->transform($serializer->serialize($response, 'xml'));
		error_log($serializedCanonicalizedResponse);
		$serializedCanonicalizedResponse = str_replace("\n", '', $serializedCanonicalizedResponse);
		$serializedCanonicalizedResponse = str_replace("  ", '', $serializedCanonicalizedResponse);

		$response = new DataDisplayResponse($serializedCanonicalizedResponse, Http::STATUS_OK, [
			'Referrer-Policy' => 'strict-origin-when-cross-origin',
			'X-Frame-Options' => 'SAMEORIGIN',
			'X-Content-Type-Options' => 'nosniff',
			'X-XSS-Protection' => '1; mode=block',
			'Strict-Transport-Security' => 'max-age=3600;includeSubDomains',
			'Cache-Control' => 'no-cache, no-store, must-revalidate, proxy-revalidate',
			'Content-Type' => 'application/soap+xml;charset=utf-8'
		]);
		$response->addHeader('Content-Disposition', null);
		return $response;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 * @CORS
	 */
	public function as4Send() {
		$this->as4SendWithIdentifier($this->generateSampleInvoice(), '9915:phase4-test-sender');
		return new DataResponse(["message"=> "done"], Http::STATUS_OK);
	}

	public function as4SendWithIdentifier($invoice, $receiver_identifier) {
		$peppolNext_identifier = '0106:80235875';

		// as4 lookup
		$useSMP = false;

		if ($useSMP) {
			$isProduction = false;
			list($as4_endpoint, $receiver_cert) = SMP::lookup($receiver_identifier, $isProduction);
		}
		else {
			// $as4_endpoint = 'http://188.208.143.130:8080/as4';
			$as4_endpoint = 'http://DESKTOP-H39H1N6.local:8080/as4';
			// $cert_file = '/opt/temp/docker_server/receiver.cer';
			$cert_file = '/home/yasharpm/pondersource/keys/phase4_receiver.cer';
			$receiver_cert = new X509;
			$receiver_cert->loadX509(file_get_contents($cert_file));
		}
		/////////////////////////////////////////////


		// Loading my private key and cert
		// $keystore_file = '/opt/temp/yashar_pc/test.p12';
		$keystore_file = '/home/yasharpm/pondersource/keys/test.p12';
		$passphrase = 'peppol';

		if (!$cert_store = file_get_contents($keystore_file)) {
			echo "Error: Unable to read the cert file\n";
			exit;
		}
		
		if (openssl_pkcs12_read($cert_store, $cert_info, $passphrase)) {
		} else {
			echo "Error: Unable to read the cert store.\n";
			exit;
		}
		
		$private_key = RSA::loadPrivateKey($cert_info['pkey']);

		$cert = new X509;
		$cert->loadX509($cert_info['cert']);
		/////////////////////////////////////////////


		// Prepare the request
		$messagingId = uniqid('peppolnext-msg-');
		$messageId = uniqid().'@peppolnext';
		$bodyId = uniqid('id-');
		$payloadId = uniqid('peppolnext-att-').'@cid';

		$envelope = new Envelope(
			new Header(
				new Security(

				),
				new Messaging(new UserMessage(
					new MessageInfo(new \DateTime(), $messageId),
					new PartyInfo(
						new Party(new PartyId('POP000306', 'urn:fdc:peppol.eu:2017:identifiers:ap'), 'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/initiator'),
						new Party(new PartyId('POP000306', 'urn:fdc:peppol.eu:2017:identifiers:ap'), 'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/responder')
						),
					new CollaborationInfo(
						'urn:fdc:peppol.eu:2017:agreements:tia:ap_provider',
						new Service($value='urn:fdc:peppol.eu:2017:poacc:billing:01:1.0', $serviceType='cenbii-procid-ubl'),
						'busdox-docid-qns::urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1',
						'phase4@Conv-3221508681736967991'
					),
					[
						new Property($peppolNext_identifier, 'originalSender', 'iso6523-actorid-upis'),
						new Property('9915:helger', 'finalRecipient', 'iso6523-actorid-upis')
					],
					new PayloadInfo(new PartInfo(
						'cid:'.$payloadId,
						[
							new Property('application/xml','MimeType'),
							new Property('application/gzip','CompressionType')
						]
					))
				), null, $messagingId)
			),
			new Body($bodyId)
		);

		$payloadKey = Random::string(32);

		$sha256 = new SHA256();
		$c14ne = new Transform("http://www.w3.org/2001/10/xml-exc-c14n#");  //C14NExcTransform();

		$serializer = SerializerBuilder::create()->build();
		$serializedMessaging = $serializer->serialize($envelope->getHeader()->getMessaging(), 'xml');
		$serializedBody = $serializer->serialize($envelope->getBody(), 'xml');

		$instanceIdentifier = uniqid(); // TODO ?
		$standardBusinessDocument = new StandardBusinessDocument(new StandardBusinessDocumentHeader(
			'1.0',
			new Sender(new Identifier('iso6523-actorid-upis', $peppolNext_identifier)),
			new Receiver(new Identifier('iso6523-actorid-upis', '9915:phase4-test-sender')),
			new DocumentIdentification(
				'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2',
				'2.1',
				$instanceIdentifier,
				'Invoice',
				new \DateTime()
			),
			[
				new Scope('DOCUMENTID', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1', 'busdox-docid-qns'),
				new Scope('PROCESSID', 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0', 'cenbii-procid-ubl')
			]
		),	$invoice);
		$payload = $serializer->serialize($standardBusinessDocument, 'xml');
		$payload = $c14ne->transform($payload);
		$payload = str_replace("\n", '', $payload);
		$payload = str_replace("  ", '', $payload);

		$payload = gzencode($payload);

		$references = [
			new DSigReference("#$messagingId", $serializedMessaging, [$c14ne], $sha256),
			new DSigReference("#$bodyId", $serializedBody, [$c14ne], $sha256),
			new DSigReference("cid:$payloadId", $payload, [new Transform('http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Signature-Transform')], $sha256)
		];

		$envelope->getHeader()->getSecurity()->generateSignature($private_key, $receiver_cert, $references, new C14NExclusive(), new RsaSha256(), $envelope);
		$payload = $envelope->getHeader()->getSecurity()->encryptData($payloadKey, $receiver_cert, "cid:$payloadId", $payload);

		$serializedEnvelope = $c14ne->transform($serializer->serialize($envelope, 'xml'));
		error_log($serializedEnvelope);
		$serializedEnvelope = str_replace("\n", '', $serializedEnvelope);
		$serializedEnvelope = str_replace("  ", '', $serializedEnvelope);
		/////////////////////////////////////////////


		// Send request
		$boundry = '----=_Part_'.uniqid();
		$body = "\r\n--$boundry\r\nContent-Type: application/soap+xml;charset=UTF-8\r\nContent-Transfer-Encoding: binary\r\n\r\n$serializedEnvelope\r\n--$boundry\r\nContent-Type: application/octet-stream\r\nContent-Transfer-Encoding: binary\r\nContent-Description: Attachment\r\nContent-ID: <$payloadId>\r\n\r\n$payload\r\n--$boundry--\r\n";

		$client = new \GuzzleHttp\Client();
		$response = $client->request('POST', $as4_endpoint, [
			'headers' => [
				'Message-Id' => '<'.uniqid().'>',
				'MIME-Version' => '1.0',
				'Content-Type' => "multipart/related;    boundary=\"$boundry\";    type=\"application/soap+xml\"; charset=UTF-8"
			],
			'body' => $body
		]);

		$statusCode = $response->getStatusCode();
		//echo $res->getHeader('content-type')[0];
		$responseBody = $response->getBody();

		$response = $serializer->deserialize($responseBody,'OCA\PeppolNext\PonderSource\Envelope\Envelope::class', 'xml');
		error_log("$statusCode: ".var_export($response, true));

		$receiver_public_key = $receiver_cert->getPublicKey();
		$verifyResult = $response->getHeader()->getSecurity()->getSignature()->verify($response, null, $receiver_public_key);
		error_log('YAAAAAAAAAYYYYYYY signature checked: '.var_export($verifyResult, true));
		/////////////////////////////////////////////

		return $verifyResult;
	}

	// private function invoiceFromDict($dict) {
	// 	$dictSP = $dict['AccountingSupplierParty']['Party'];
	// 	$dictCP = $dict['AccountingCustomerParty']['Party'];

	// 	// Tax scheme
	// 	$taxScheme = (new \Pondersource\Invoice\Party\TaxScheme())
	// 		->setId($dictSP['PartyTaxScheme']['TaxScheme']['ID']);

	// 	// Client contact node
	// 	$clientContact = (new \Pondersource\Invoice\Account\Contact()) // TODO
	// 		->setName('Client name')
	// 		->setTelephone('908-99-74-74');


	// 	$country = (new \Pondersource\Invoice\Account\Country())
	// 		->setIdentificationCode($dictSP['PostalAddress']['Country']['IdentificationCode']);


	// 	// Full address
	// 	$address = (new \Pondersource\Invoice\Account\PostalAddress())
	// 		->setStreetName($dictSP['PostalAddress']['StreetName'])
	// 		->setAddionalStreetName($dictSP['PostalAddress']['AdditionalStreetName'])
	// 		->setCityName($dictSP['CityName'])
	// 		->setPostalZone($dictSP['PostalZone'])
	// 		->setCountry($country);


	// 	$financialInstitutionBranch = (new \Pondersource\Invoice\Financial\FinancialInstitutionBranch())
	// 		->setId('RABONL2U'); // TODO


	// 	$payeeFinancialAccount = (new \Pondersource\Invoice\Financial\PayeeFinancialAccount()) // TODO
	// 		->setFinancialInstitutionBranch($financialInstitutionBranch)
	// 		->setName('Customer Account Holder')
	// 		->setId('NL00RABO0000000000');


	// 	$paymentMeans = (new  \Pondersource\Invoice\Payment\PaymentMeans()) // TODO
	// 		->setPayeeFinancialAccount($payeeFinancialAccount)
	// 		->setPaymentMeansCode(31, [])
	// 		->setPaymentId('our invoice 1234');

	// 	// Supplier company node
	// 	$supplierLegalEntity = (new \Pondersource\Invoice\Legal\LegalEntity())
	// 		->setRegistrationNumber($dictSP['PartyLegalEntity']['RegistrationName'])
	// 		->setCompanyId($dictSP['PartyLegalEntity']['CompanyID']);


	// 	$supplierPartyTaxScheme = (new \Pondersource\Invoice\Party\PartyTaxScheme())
	// 		->setTaxScheme($taxScheme)
	// 		->setCompanyId($dictSP['PartyTaxScheme']['CompanyID']);

	// 	$supplierCompany = (new \Pondersource\Invoice\Party\Party())
	// 		->setEndPointId($dictSP['EndpointID'])
	// 		->setPartyIdentificationId($dictSP['PartyIdentification']['ID'])
	// 		->setName($dictSP['PartyName']['Name'])
	// 		->setLegalEntity($supplierLegalEntity)
	// 		->setPartyTaxScheme($supplierPartyTaxScheme)
	// 		->setPostalAddress($address);



	// 	// Client company node
	// 	$clientLegalEntity = (new \Pondersource\Invoice\Legal\LegalEntity()) // TODO
	// 		->setRegistrationNumber('Client Company Name')
	// 		->setCompanyId('Client Company Registration');



	// 	$clientPartyTaxScheme = (new \Pondersource\Invoice\Party\PartyTaxScheme()) // TODO
	// 		->setTaxScheme($taxScheme)
	// 		->setCompanyId('BE123456789');


	// 	$clientCompany = (new \Pondersource\Invoice\Party\Party()) // TODO
	// 		->setEndPointId('7300010000002', '0002')
	// 		->setPartyIdentificationId('9988217')
	// 		->setName('Client Company Name')
	// 		->setLegalEntity($clientLegalEntity)
	// 		->setPartyTaxScheme($clientPartyTaxScheme)
	// 		->setPostalAddress($address)
	// 		->setContact($clientContact);

	// 	$legalMonetaryTotal = (new \Pondersource\Invoice\Legal\LegalMonetaryTotal()) // TODO
	// 		->setPayableAmount(10 + 2.1)
	// 		->setAllowanceTotalAmount(0)
	// 		->setTaxInclusiveAmount(10 + 2.1)
	// 		->setLineExtensionAmount(10)
	// 		->setTaxExclusiveAmount(10);


	// 	$classifiedTaxCategory = (new \Pondersource\Invoice\Tax\ClassifiedTaxCategory()) // TODO
	// 		->setId('S')
	// 		->setPercent(21.00)
	// 		->setTaxScheme($taxScheme);

	// 	// Product
	// 	$productItem = (new \Pondersource\Invoice\Item()) // TODO
	// 		->setName('Product Name')
	// 		->setClassifiedTaxCategory($classifiedTaxCategory)
	// 		->setDescription('Product Description');

	// 	// Price
	// 	$price = (new \Pondersource\Invoice\Payment\Price()) // TODO
	// 		->setBaseQuantity(1)
	// 		->setUnitCode(\Pondersource\Invoice\Payment\UnitCode::UNIT)
	// 		->setPriceAmount(10);

	// 	// Invoice Line tax totals
	// 	$lineTaxTotal = (new \Pondersource\Invoice\Tax\TaxTotal()) // TODO
	// 		->setTaxAmount(2.1);


	// 	// InvoicePeriod
	// 	$invoicePeriod = (new \Pondersource\Invoice\Invoice\InvoicePeriod()) // TODO
	// 		->setStartDate(new \DateTime());

	// 	// Invoice Line(s)
	// 	$invoiceLine = (new \Pondersource\Invoice\Invoice\InvoiceLine()) // TODO
	// 		->setId(0)
	// 		->setItem($productItem)
	// 		->setPrice($price)
	// 		->setInvoicePeriod($invoicePeriod)
	// 		->setLineExtensionAmount(10)
	// 		->setInvoicedQuantity(1);



	// 	$invoiceLines = [$invoiceLine]; // TODO

	// 	$taxCategory = (new \Pondersource\Invoice\Tax\TaxCategory()) // TODO
	// 		->setId('S', [])
	// 		->setPercent(21.00)
	// 		->setTaxScheme($taxScheme);

	// 	$allowanceCharge = (new \Pondersource\Invoice\AllowanceCharge()) // TODO
	// 		->setChargeIndicator(true)
	// 		->setAllowanceReason('Insurance')
	// 		->setAmount(10)
	// 		->setTaxCategory($taxCategory);

	// 	$taxSubTotal = (new \Pondersource\Invoice\Tax\TaxSubTotal()) // TODO
	// 		->setTaxableAmount(10)
	// 		->setTaxAmount(2.1)
	// 		->setTaxCategory($taxCategory);

	// 	$taxTotal = (new \Pondersource\Invoice\Tax\TaxTotal()) // TODO
	// 		->setTaxSubtotal($taxSubTotal)
	// 		->setTaxAmount(2.1);


	// 	// Payment Terms
	// 	$paymentTerms = (new \Pondersource\Invoice\Payment\PaymentTerms()) // TODO
	// 		->setNote('30 days net');

	// 	// Delivery
	// 	$deliveryLocation = (new \Pondersource\Invoice\Account\PostalAddress()) // TODO
	// 		->setStreetName('Delivery street 2')
	// 		->setAddionalStreetName('Building 56')
	// 		->setCityName('Utreht')
	// 		->setPostalZone('3521')
	// 		->setCountry($country);


	// 	$delivery = (new \Pondersource\Invoice\Account\Delivery()) // TODO
	// 		->setActualDeliveryDate(new \DateTime())
	// 		->setDeliveryLocation($deliveryLocation);


	// 	$orderReference = (new \Pondersource\Invoice\Payment\OrderReference()) // TODO
	// 		->setId('5009567')
	// 		->setSalesOrderId('tRST-tKhM');

	// 	// Invoice object
	// 	$invoice = (new  \Pondersource\Invoice\Invoice\Invoice())
	// 		->setProfileID($dict['ProfileID'])
	// 		->setCustomazationID($dict['CustomizationID'])
	// 		->setId($dict['ID'])
	// 		->setIssueDate(strtotime($dict['IssueDate']))
	// 		->setDueDate(strtotime($dict['DueDate']))
	// 		->setInvoiceTypeCode($dict['InvoiceTypeCode'])
	// 		->setDocumentCurrencyCode($dict['DocumentCurrencyCode'])
	// 		->setNote('invoice note') // TODO
	// 		->setAccountingCostCode($dict['AccountingCost'])
	// 		->setDelivery($delivery) // TODO
	// 		->setAccountingSupplierParty($supplierCompany)
	// 		->setAccountingCustomerParty($clientCompany) // TODO
	// 		->setInvoiceLines($invoiceLines) // TODO
	// 		->setLegalMonetaryTotal($legalMonetaryTotal) // TODO
	// 		->setPaymentTerms($paymentTerms) // TODO
	// 		//->setAllowanceCharges($allowanceCharge)
	// 		->setInvoicePeriod($invoicePeriod) // TODO
	// 		->setPaymentMeans($paymentMeans) // TODO
	// 		->setByerReference($dict['BuyerReference'])
	// 		->setOrderReference($orderReference) // TODO
	// 		->setTaxTotal($taxTotal); // TODO

	// 	return $invoice;
	// }

	private function generateSampleInvoice() {
		// Tax scheme
		$taxScheme = new TaxScheme();

		// Client contact node
		$clientContact = new Contact('Client name', '908-99-74-74');

		$country = new Country(CountryCode::NL);

		// Full address
		$address = new PostalAddress('Lisk Center Utreht', 'De Burren', 'Utreht', '3521', null, null, $country);


		$financialInstitutionBranch = new FinancialInstitutionBranch('RABONL2U');
		$payeeFinancialAccount = new PayeeFinancialAccount('NL00RABO0000000000', 'Customer Account Holder', $financialInstitutionBranch);
		$paymentMeans = new PaymentMeans(
			new PaymentMeansCode(null, 31),
			'our invoice 1234',
			null, $payeeFinancialAccount, null
		);

		// Supplier company node
		$supplierLegalEntity = new PartyLegalEntity('PonderSource', new ID(null, 'NL123456789'));
		$supplierTaxScheme = new PartyTaxScheme('NL123456789', $taxScheme);
		$supplierParty = new \OCA\PeppolNext\PonderSource\UBL\Invoice\Party(
			new EndpointID('7300010000001', '0007'),
			[ new PartyIdentification(new ID(null, '99887766')) ],
			new PartyName('PonderSource'),
			$address,
			[ $supplierTaxScheme ],
			$supplierLegalEntity,
			null
		);

		// Client company node
		$clientLegalEntity = new PartyLegalEntity('Client Company Name', new ID(null, 'Client Company Registration'));
		$clientPartyTaxScheme = new PartyTaxScheme('BE123456789', $taxScheme);
		$clientParty = new \OCA\PeppolNext\PonderSource\UBL\Invoice\Party(
			new EndpointID('7300010000002', '0002'),
			[ new PartyIdentification(new ID(null, '9988217')) ],
			new PartyName('Client Company Name'),
			$address,
			[ $clientPartyTaxScheme ],
			$clientLegalEntity,
			$clientContact
		);

		$legalMonetaryTotal = new LegalMonetaryTotal(
			new Amount('EUR', 10),
			new Amount('EUR', 10),
			new Amount('EUR', 10 + 2.1),
			new Amount('EUR', 0),
			null, null, null,
			new Amount('EUR', 10 + 2.1)
		);

		$classifiedTaxCategory = new ClassifiedTaxCategory('S', 21.00, $taxScheme);
		$productItem = new Item('Product Description', 'Product Name', null, null, null, null, null, $classifiedTaxCategory, []);

		// Price
		$price = new Price(
			new Amount('EUR', 10),
			new Quantity('Unit', 1),
			null
		);

		// InvoicePeriod
		$invoicePeriod = new InvoicePeriod(new \DateTime(), null, null);

		// Invoice Line(s)
		$invoiceLine = new InvoiceLine(
			0,
			null,
			new Quantity('Unit', 1),
			new Amount('EUR', 10),
			null,
			$invoicePeriod,
			null,
			null,
			[],
			$productItem,
			$price
		);

		$taxCategory = new TaxCategory('S', 21.00, null, null, $taxScheme);
		$allowanceCharge = new AllowanceCharge(true, null, 'Insurance', null, new Amount('EUR', 10), null, $taxCategory);

		$taxSubTotal = new TaxSubtotal(new Amount('EUR', 10), new Amount('EUR', 2.1), $taxCategory);
		$taxTotal = new TaxTotal(new Amount('EUR', 2.1), $taxSubTotal);

		// Payment Terms
		$paymentTerms = new PaymentTerms('30 days net');

		// Delivery
		$deliveryLocation = new DeliveryLocation(null, new PostalAddress(
			'Delivery street 2',
			'Building 56',
			'Utreht',
			'3521',
			null, null,
			$country
		));
		$delivery = new Delivery(new \DateTime(), $deliveryLocation, null);

		$orderReference = new OrderReference('5009567', 'tRST-tKhM');

		// Invoice object
		$invoice = new Invoice(
			1234,
			new \DateTime(),
			null,
			null,
			'invoice note',
			null,
			null,
			null,
			'4217:2323:2323',
			'BUYER_REF',
			$invoicePeriod,
			$orderReference,
			null,
			null,
			null,
			null,
			null,
			[],
			null,
			new AccountingSupplierParty($supplierParty),
			new AccountingCustomerParty($clientParty),
			null,
			null,
			$delivery,
			[$paymentMeans],
			$paymentTerms,
			[$allowanceCharge],
			$taxTotal,
			$legalMonetaryTotal,
			[$invoiceLine]
		);

		return $invoice;
	}

	private function generateSampleInvoice2() {
		// Tax scheme
		$taxScheme = (new \Pondersource\Invoice\Party\TaxScheme())
			->setId('VAT');
		// Client contact node
		$clientContact = (new \Pondersource\Invoice\Account\Contact())
			->setName('Client name')
			->setTelephone('908-99-74-74');


		$country = (new \Pondersource\Invoice\Account\Country())
			->setIdentificationCode('NL');


		// Full address
		$address = (new \Pondersource\Invoice\Account\PostalAddress())
			->setStreetName('Lisk Center Utreht')
			->setAddionalStreetName('De Burren')
			->setCityName('Utreht')
			->setPostalZone('3521')
			->setCountry($country);


		$financialInstitutionBranch = (new \Pondersource\Invoice\Financial\FinancialInstitutionBranch())
			->setId('RABONL2U');


		$payeeFinancialAccount = (new \Pondersource\Invoice\Financial\PayeeFinancialAccount())
			->setFinancialInstitutionBranch($financialInstitutionBranch)
			->setName('Customer Account Holder')
			->setId('NL00RABO0000000000');


		$paymentMeans = (new  \Pondersource\Invoice\Payment\PaymentMeans())
			->setPayeeFinancialAccount($payeeFinancialAccount)
			->setPaymentMeansCode(31, [])
			->setPaymentId('our invoice 1234');

		// Supplier company node
		$supplierLegalEntity = (new \Pondersource\Invoice\Legal\LegalEntity())     // $doc = new DOMDocument();
		// $doc->load($path);
			->setRegistrationNumber('PonderSource')
			->setCompanyId('NL123456789');


		$supplierPartyTaxScheme = (new \Pondersource\Invoice\Party\PartyTaxScheme())
			->setTaxScheme($taxScheme)
			->setCompanyId('NL123456789');

		$supplierCompany = (new \Pondersource\Invoice\Party\Party())
			->setEndPointId('7300010000001', '0007')
			->setPartyIdentificationId('99887766')
			->setName('PonderSource')
			->setLegalEntity($supplierLegalEntity)
			->setPartyTaxScheme($supplierPartyTaxScheme)
			->setPostalAddress($address);



		// Client company node
		$clientLegalEntity = (new \Pondersource\Invoice\Legal\LegalEntity())
			->setRegistrationNumber('Client Company Name')
			->setCompanyId('Client Company Registration');



		$clientPartyTaxScheme = (new \Pondersource\Invoice\Party\PartyTaxScheme())
			->setTaxScheme($taxScheme)
			->setCompanyId('BE123456789');



		$clientCompany = (new \Pondersource\Invoice\Party\Party())
			->setPartyIdentificationId('9988217')
			->setEndPointId('7300010000002', '0002')
			->setName('Client Company Name')
			->setLegalEntity($clientLegalEntity)
			->setPartyTaxScheme($clientPartyTaxScheme)
			->setPostalAddress($address)
			->setContact($clientContact);

		$legalMonetaryTotal = (new \Pondersource\Invoice\Legal\LegalMonetaryTotal())
			->setPayableAmount(10 + 2.1)
			->setAllowanceTotalAmount(0)
			->setTaxInclusiveAmount(10 + 2.1)
			->setLineExtensionAmount(10)
			->setTaxExclusiveAmount(10);


		$classifiedTaxCategory = (new \Pondersource\Invoice\Tax\ClassifiedTaxCategory())
			->setId('S')
			->setPercent(21.00)
			->setTaxScheme($taxScheme);

		// Product
		$productItem = (new \Pondersource\Invoice\Item())
			->setName('Product Name')
			->setClassifiedTaxCategory($classifiedTaxCategory)
			->setDescription('Product Description');

		// Price
		$price = (new \Pondersource\Invoice\Payment\Price())
			->setBaseQuantity(1)
			->setUnitCode(\Pondersource\Invoice\Payment\UnitCode::UNIT)
			->setPriceAmount(10);

		// Invoice Line tax totals
		$lineTaxTotal = (new \Pondersource\Invoice\Tax\TaxTotal())
			->setTaxAmount(2.1);


		// InvoicePeriod
		$invoicePeriod = (new \Pondersource\Invoice\Invoice\InvoicePeriod())
			->setStartDate(new \DateTime());

		// Invoice Line(s)
		$invoiceLine = (new \Pondersource\Invoice\Invoice\InvoiceLine())
			->setId(0)
			->setItem($productItem)
			->setPrice($price)
			->setInvoicePeriod($invoicePeriod)
			->setLineExtensionAmount(10)
			->setInvoicedQuantity(1);



		$invoiceLines = [$invoiceLine];

		$taxCategory = (new \Pondersource\Invoice\Tax\TaxCategory())
			->setId('S', [])
			->setPercent(21.00)
			->setTaxScheme($taxScheme);

		$allowanceCharge = (new \Pondersource\Invoice\AllowanceCharge())
			->setChargeIndicator(true)
			->setAllowanceReason('Insurance')
			->setAmount(10)
			->setTaxCategory($taxCategory);

		$taxSubTotal = (new \Pondersource\Invoice\Tax\TaxSubTotal())
			->setTaxableAmount(10)
			->setTaxAmount(2.1)
			->setTaxCategory($taxCategory);

		$taxTotal = (new \Pondersource\Invoice\Tax\TaxTotal())
			->setTaxSubtotal($taxSubTotal)
			->setTaxAmount(2.1);


		// Payment Terms
		$paymentTerms = (new \Pondersource\Invoice\Payment\PaymentTerms())
			->setNote('30 days net');

		// Delivery
		$deliveryLocation = (new \Pondersource\Invoice\Account\PostalAddress())
			->setStreetName('Delivery street 2')
			->setAddionalStreetName('Building 56')
			->setCityName('Utreht')
			->setPostalZone('3521')
			->setCountry($country);


		$delivery = (new \Pondersource\Invoice\Account\Delivery())
			->setActualDeliveryDate(new \DateTime())
			->setDeliveryLocation($deliveryLocation);


		$orderReference = (new \Pondersource\Invoice\Payment\OrderReference())
			->setId('5009567')
			->setSalesOrderId('tRST-tKhM');

		// Invoice object
		$invoice = (new  \Pondersource\Invoice\Invoice\Invoice())
			->setProfileID('urn:fdc:peppol.eu:2017')
			->setCustomazationID('urn:cen.eu:en16931:2017')
			->setId(1234)
			->setIssueDate(new \DateTime())
			->setNote('invoice note')
			->setAccountingCostCode('4217:2323:2323')
			->setDelivery($delivery)
			->setAccountingSupplierParty($supplierCompany)
			->setAccountingCustomerParty($clientCompany)
			->setInvoiceLines($invoiceLines)
			->setLegalMonetaryTotal($legalMonetaryTotal)
			->setPaymentTerms($paymentTerms)
			//->setAllowanceCharges($allowanceCharge)
			->setInvoicePeriod($invoicePeriod)
			->setPaymentMeans($paymentMeans)
			->setByerReference('BUYER_REF')
			->setOrderReference($orderReference)
			->setTaxTotal($taxTotal);

		return $invoice;
	}

}
