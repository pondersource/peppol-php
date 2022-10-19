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

use OCA\PeppolNext\PonderSource\AS4\handleAS4;

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
		return new DataDisplayResponse(
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
		$contentType = $this->request->getHeader('Content-Type');
		$body = file_get_contents('php://input');
		$serializedCanonicalizedResponse = handleAS4($contentType, $body);
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
		$as4 = new AS4();
		$as4->as4SendWithIdentifier($this->generateSampleInvoice(), '9915:phase4-test-sender');
		return new DataResponse(["message"=> "done"], Http::STATUS_OK);
	}


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

}
