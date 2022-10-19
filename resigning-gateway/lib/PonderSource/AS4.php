<?php
 
namespace OCA\PeppolNext\PonderSource;
require_once(dirname(dirname(dirname(__FILE__))) . "/vendor/autoload.php");

require_once(dirname(dirname(__FILE__)) . "/PayloadReader.php");
require_once(dirname(dirname(__FILE__)) . "/EnvelopeReader.php");

require_once(dirname(__FILE__) . "/EBBP/MessagePartNRInformation.php");
require_once(dirname(__FILE__) . "/EBMS/CollaborationInfo.php");
require_once(dirname(__FILE__) . "/EBMS/Error.php");
require_once(dirname(__FILE__) . "/EBMS/MessageInfo.php");
require_once(dirname(__FILE__) . "/EBMS/Messaging.php");
require_once(dirname(__FILE__) . "/EBMS/PartInfo.php");
require_once(dirname(__FILE__) . "/EBMS/Party.php");
require_once(dirname(__FILE__) . "/EBMS/PartyId.php");
require_once(dirname(__FILE__) . "/EBMS/PartyInfo.php");
require_once(dirname(__FILE__) . "/EBMS/PayloadInfo.php");
require_once(dirname(__FILE__) . "/EBMS/Property.php");
require_once(dirname(__FILE__) . "/EBMS/Receipt.php");
require_once(dirname(__FILE__) . "/EBMS/Service.php");
require_once(dirname(__FILE__) . "/EBMS/SignalMessage.php");
require_once(dirname(__FILE__) . "/EBMS/UserMessage.php");
require_once(dirname(__FILE__) . "/Envelope/Body.php");
require_once(dirname(__FILE__) . "/Envelope/Envelope.php");
require_once(dirname(__FILE__) . "/Envelope/Header.php");
require_once(dirname(__FILE__) . "/SBD/Any.php");
require_once(dirname(__FILE__) . "/SBD/DocumentIdentification.php");
require_once(dirname(__FILE__) . "/SBD/Identifier.php");
require_once(dirname(__FILE__) . "/SBD/Receiver.php");
require_once(dirname(__FILE__) . "/SBD/Scope.php");
require_once(dirname(__FILE__) . "/SBD/Sender.php");
require_once(dirname(__FILE__) . "/SBD/StandardBusinessDocument.php");
require_once(dirname(__FILE__) . "/SBD/StandardBusinessDocumentHeader.php");
require_once(dirname(__FILE__) . "/SMP/DocumentIdentifier.php");
require_once(dirname(__FILE__) . "/SMP/Endpoint.php");
require_once(dirname(__FILE__) . "/SMP/EndpointReference.php");
require_once(dirname(__FILE__) . "/SMP/ParticipantIdentifier.php");
require_once(dirname(__FILE__) . "/SMP/Process.php");
require_once(dirname(__FILE__) . "/SMP/ProcessIdentifier.php");
require_once(dirname(__FILE__) . "/SMP/SMP.php");
require_once(dirname(__FILE__) . "/SMP/ServiceGroup.php");
require_once(dirname(__FILE__) . "/SMP/ServiceInformation.php");
require_once(dirname(__FILE__) . "/SMP/ServiceMetadata.php");
require_once(dirname(__FILE__) . "/SMP/ServiceMetadataReference.php");
require_once(dirname(__FILE__) . "/SMP/SignedServiceMetadata.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AccountingCustomerParty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AccountingSupplierParty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AdditionalDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AdditionalItemProperty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AddressLine.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/AllowanceCharge.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Amount.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Attachment.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/BillingReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/BuyersItemIdentification.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/CardAccount.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ClassifiedTaxCategory.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/CommodityClassification.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Contact.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ContractDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Country.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/CountryCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/CurrencyCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Delivery.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/DeliveryLocation.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/DeliveryParty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/DespatchDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/DocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ElectronicAddressScheme.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/EmbeddedDocumentBinaryObject.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/EndpointID.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ExternalReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/FinancialInstitutionBranch.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ID.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Invoice.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/InvoiceDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/InvoiceLine.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/InvoicePeriod.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/InvoiceTypeCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Item.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ItemClassificationCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/LegalMonetaryTotal.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/MimeCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/OrderLineReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/OrderReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/OriginCountry.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/OriginatorDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Party.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PartyIdentification.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PartyLegalEntity.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PartyName.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PartyTaxScheme.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PayeeFinancialAccount.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PayeeParty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PayerFinancialAccount.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PaymentMandate.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PaymentMeans.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PaymentMeansCode.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PaymentTerms.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/PostalAddress.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Price.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ProjectReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/Quantity.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/ReceiptDocumentReference.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/SellersItemIdentification.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/StandardItemIdentification.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/TaxCategory.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/TaxRepresentativeParty.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/TaxScheme.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/TaxSubtotal.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/TaxTotal.php");
require_once(dirname(__FILE__) . "/UBL/Invoice/VATDateCode.php");
require_once(dirname(__FILE__) . "/WSSec/BinarySecurityToken.php");
require_once(dirname(__FILE__) . "/WSSec/CipherData.php");
require_once(dirname(__FILE__) . "/WSSec/CipherReference.php");
require_once(dirname(__FILE__) . "/WSSec/DSigReference.php");
require_once(dirname(__FILE__) . "/WSSec/DataReference.php");
require_once(dirname(__FILE__) . "/WSSec/EncryptedData.php");
require_once(dirname(__FILE__) . "/WSSec/EncryptedKey.php");
require_once(dirname(__FILE__) . "/WSSec/InclusiveNamespaces.php");
require_once(dirname(__FILE__) . "/WSSec/KeyInfo.php");
require_once(dirname(__FILE__) . "/WSSec/MGF.php");
require_once(dirname(__FILE__) . "/WSSec/Security.php");
require_once(dirname(__FILE__) . "/WSSec/SecurityTokenReference.php");
require_once(dirname(__FILE__) . "/WSSec/Signature.php");
require_once(dirname(__FILE__) . "/WSSec/SignedInfo.php");
require_once(dirname(__FILE__) . "/WSSec/Transform.php");
require_once(dirname(__FILE__) . "/WSSec/WSSecReference.php");
require_once(dirname(__FILE__) . "/WSSec/CanonicalizationMethod/ICanonicalizationMethod.php");
require_once(dirname(__FILE__) . "/WSSec/CanonicalizationMethod/C14NExclusive.php");
require_once(dirname(__FILE__) . "/WSSec/DigestMethod/IDigestMethod.php");
require_once(dirname(__FILE__) . "/WSSec/DigestMethod/SHA256.php");
require_once(dirname(__FILE__) . "/WSSec/EncryptionMethod/IEncryptionMethod.php");
require_once(dirname(__FILE__) . "/WSSec/EncryptionMethod/AES128GCM.php");
require_once(dirname(__FILE__) . "/WSSec/EncryptionMethod/RsaOeap.php");
require_once(dirname(__FILE__) . "/WSSec/SignatureMethod/ISignatureMethod.php");
require_once(dirname(__FILE__) . "/WSSec/SignatureMethod/RsaSha256.php");

use phpseclib3\Crypt\{RSA, Random};
use phpseclib3\File\X509;
use JMS\Serializer\SerializerBuilder;

use OCA\PeppolNext\PayloadReader;
use OCA\PeppolNext\EnvelopeReader;
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

class AS4 {
  public function handleAs4($contentType, $body) {
		$peppolNext_identifier = '0106:80235875'; // TODO

		$boundryStart = strpos($contentType, 'boundary="');
		$boundryEnd = strpos($contentType, '"', $boundryStart + 10);
		$boundry = substr($contentType, $boundryStart + 10, $boundryEnd - $boundryStart - 10);
		$boundryLength = strlen($boundry);

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

		$keystore_file = '/p12transport/test.p12'; // Private key of the receiver/us
		// $keystore_file = '/home/yasharpm/pondersource/keys/test.p12';
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
			$sender_certificate = new X509; // Sender's certificate
			$sender_certificate->loadX509(file_get_contents('/p12transport/sender.cer'));
			// $sender_certificate->loadX509(file_get_contents('/home/yasharpm/pondersource/keys/sender.cer'));
		}

		$sender_public_key = $sender_certificate->getPublicKey();

		$verifyResult = $envelope->getHeader()->getSecurity()->getSignature()->verify($envelope, $decrypted_payload, $sender_public_key);
		error_log('signature checked in AS4 endpoint: '.var_export($verifyResult, true));
		if (!$verifyResult) return false;

		$output = var_export($invoice, true);
		// error_log($output);


		/////////////// MESSAGE SAVING ///////////////////
		$this->messageService->saveIncoming($decrypted_payload, 'invoice.xml');

    error_log("invoice saved to Nextcloud Peppolnext MessageService");
		//////////////////////////////////////////////////


		/////////////// MESSAGE FORWARDING ///////////////
		$should_forward = false;

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

		return $serializedCanonicalizedResponse;
	}
}