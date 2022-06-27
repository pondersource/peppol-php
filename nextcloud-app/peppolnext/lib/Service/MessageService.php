<?php

namespace OCA\PeppolNext\Service;

use Exception;
use JMS\Serializer\SerializerBuilder;
use OC\Files\Node\File;
use OC\Files\Node\Folder;
use OCA\DAV\Connector\Sabre\Node;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCA\PeppolNext\Service\Helper\VCardInterpreter;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\InvoiceSummary;
use OCA\PeppolNext\Service\Model\MessageBuilder;
use OCA\PeppolNext\Settings\AppSettingManager;
use OCP\Contacts\IManager;
use OCP\Files\IRootFolder;
use OCP\Files\NotPermittedException;
use OCP\IDBConnection;
use OCP\Lock\ILockingProvider;
use PhpParser\Error;
use Pondersource\Invoice\Account\Contact;
use Pondersource\Invoice\Account\Country;
use Pondersource\Invoice\Account\Delivery;
use Pondersource\Invoice\Account\PostalAddress;
use Pondersource\Invoice\DeserializeInvoice;
use Pondersource\Invoice\Invoice\GenerateInvoice;
use Pondersource\Invoice\Invoice\Invoice;
use Pondersource\Invoice\Invoice\InvoiceLine;
use Pondersource\Invoice\Invoice\InvoicePeriod;
use Pondersource\Invoice\Item;
use Pondersource\Invoice\Legal\LegalEntity;
use Pondersource\Invoice\Legal\LegalMonetaryTotal;
use Pondersource\Invoice\Party\Party;
use Pondersource\Invoice\Party\PartyTaxScheme;
use Pondersource\Invoice\Party\TaxScheme;
use Pondersource\Invoice\Payment\OrderReference;
use Pondersource\Invoice\Payment\PaymentTerms;
use Pondersource\Invoice\Payment\Price;
use Pondersource\Invoice\Tax\TaxCategory;
use Pondersource\Invoice\Tax\TaxSubTotal;
use Pondersource\Invoice\Tax\TaxTotal;
use Safe\DateTime;

class MessageService {

	/** @var IRootFolder*/
	private IRootFolder $rootFolder;

	/** @var FolderManager*/
	private FolderManager $folderManager;

	/** @var AppSettingManager */
	private $appSettingManager;

	private IDBConnection $dbConnection;
	private IManager $contactManager;
	private UploadService $uploadService;
	private $userId;


	public function __construct(IRootFolder $rootFolder
		, AppSettingManager $settingManager
		, FolderManager $foldermanager
		, IManager $contacManager
		, IDBConnection $dbConnection
		, UploadService $uploadService
		, $userId)
	{
		$this->rootFolder = $rootFolder;
		$this->userId = $userId;
		$this->folderManager = $foldermanager;
		if (isset($userId))
			$this->folderManager->createAllFolders($rootFolder->getUserFolder($userId));
		$this->appSettingManager = $settingManager;
		$this->contactManager = $contacManager;
		$this->dbConnection = $dbConnection;
		$this->uploadService = $uploadService;
	}

	/**
	 * @param string $content
	 * @param string $fileName
	 * @param int $messageType Use FileManager MessageType constants
	 * @return void
	 * @throws NotPermittedException
	 * @throws \OC\User\NoUserException
	 */
	public function save(string $content,
						 string $fileName,
						 int $direction = Constants::SEND_DIRECTION): void{

		$userfolder = $this->rootFolder->getUserFolder($this->userId);
		$targetFolder = $this->folderManager->getFolderPath($direction);

		if( $userfolder->isCreatable()
			&& $userfolder->nodeExists($targetFolder)) {
			$filePath = $this->folderManager->generateFilePath($fileName, $direction);
			$file = $userfolder->newFile($filePath);
			$file->putContent($content);
			$file->unlock(ILockingProvider::LOCK_SHARED);
		}
	}

	public function serializeXML(MessageBuilder $messageBuilder):string{

		$vcardInterpreter = new VCardInterpreter($this->contactManager, $messageBuilder->getReceiver()->uid);

		$invoice = new Invoice();
		$invoice->setProfileID("profileId")
			->setAccountingCostCode("")
			->setId(uniqid())
			->setIssueDate(new \DateTime())
			->setNote($messageBuilder->getBody())
			->setUBLVersionID(2.1)
			->setInvoiceTypeCode(383)
			->setDocumentCurrencyCode('EUR')
			->setByerReference("SOME_BYER_REFERENCE")
			->setCustomazationID("CUSTOMIZATION_ID")
			->setPaymentTerms((new PaymentTerms())->setNote($messageBuilder->getBody()));

		$monetaryTotal = (new LegalMonetaryTotal())
			->setAllowanceTotalAmount(0)
			->setLineExtensionAmount(0)
			->setPayableAmount($messageBuilder->getTotalAmount())
			->setTaxExclusiveAmount(0)
			->setTaxInclusiveAmount(0);
		$invoice->setLegalMonetaryTotal($monetaryTotal);

		$suplierContact = (new Contact())
			->setName($this->appSettingManager->getFullname())
		    //->setElectronicMail($this->appSettingManager->getEmail())
			//->setTelefax($this->appSettingManager->getFaxNo())
			->setTelephone($this->appSettingManager->getPhoneNo());

		//Todo: read from appsetting
		$supplierEntity = (new LegalEntity())
			->setRegistrationNumber("123")
			->setCompanyId("") ;
		//Todo: read from appsetting
		$suplierTaxScheme = (new PartyTaxScheme())
			->setCompanyId("companyId")
			->setTaxScheme((new TaxScheme())->setId(":("));

		$suplierParty = (new Party())
			->setName($this->appSettingManager->getFullname())
			->setContact($suplierContact)
			->setEndpointID($this->appSettingManager->getPeppolID(),$this->appSettingManager->getPeppolScheme())
			->setLegalEntity($supplierEntity)
			->setPartyIdentificationId("SomeId")
			->setPartyTaxScheme($suplierTaxScheme)
			->setPhysicalLocation($this->createPostalAddress($this->appSettingManager->getAddress()))
			->setPostalAddress($this->createPostalAddress($this->appSettingManager->getAddress()));

		$invoice->setAccountingSupplierParty($suplierParty);

		//Todo: read from VCard
		$customerContact = (new Contact())
			->setName($messageBuilder->getReceiver()->title)
			->setTelephone($vcardInterpreter->getPhone("work"));

		$customerEntity = (new LegalEntity())
			->setRegistrationNumber("123")
			->setCompanyId("companyId") ;
		$customerTaxScheme = (new PartyTaxScheme())
			->setCompanyId("companyId")
			->setTaxScheme((new TaxScheme())->setId(":("));

		$workAddress = $vcardInterpreter->getAddress('work');
		$defaultAddress = $vcardInterpreter->getAddress();

		$customerParty = (new Party())
			->setName($messageBuilder->getReceiver()->title)
			->setContact($customerContact)
			->setEndpointID($messageBuilder->getReceiver()->getPeppolId(),$messageBuilder->getReceiver()->getPeppolScheme())
			->setLegalEntity($customerEntity)
			->setPartyIdentificationId("SomeId")
			->setPartyTaxScheme($customerTaxScheme)
			->setPhysicalLocation($this->createPostalAddress($workAddress))
			->setPostalAddress($this->createPostalAddress($defaultAddress));

		$invoice->setAccountingCustomerParty($customerParty);

		$delivery = (new Delivery())
			->setActualDeliveryDate(new DateTime())
			->setDeliveryLocation($this->createPostalAddress($defaultAddress));
		$invoice->setDelivery($delivery);

		$taxTotal = (new TaxTotal())
		->setTaxAmount(0)
		->setTaxSubtotal((new TaxSubTotal())
			->setTaxAmount(0)
			->setPercent(0)
			->setTaxAbleAmount(0)
			->setTaxCategory((new TaxCategory())
				->setPercent(0)
				->setId("11")
				->setTaxScheme((new TaxScheme())->setId("taxSchemeId"))
				->setName("notax")
			)
		);
		$invoice->setTaxTotal($taxTotal);

		$invoiceLines = [] ;
		foreach ($messageBuilder->getInvoiceLines() as $line)
		{
			$item = (new Item())
				->setName($line['title']);

			$line = (new InvoiceLine())
				->setNote($line["description"])
				->setPrice((new Price())
					->setBaseQuantity(1)
					->setPriceAmount($line['totalPrice'])
					->setUnitCode("X"))
				->setItem($item)
				->setInvoicedQuantity($line['quantity']);
			$invoiceLines[] = $line ;
		}
		$invoice->setInvoiceLines($invoiceLines);
		// this part sould fill by ui
		$invoice->setDueDate(new DateTime())
			->setInvoicePeriod((new InvoicePeriod())->setStartDate(new \DateTime()))
			->setOrderReference(
				(new OrderReference())
				->setId("orderId")
				->setSalesOrderId("sealesOrderId"));

		$generateInvoice = new GenerateInvoice();
		$outputXMLString = $generateInvoice->invoice($invoice);
		return  $outputXMLString;
	}

	/**
	 * @throws \Safe\Exceptions\PcreException
	 */
	public function send(string $contactUri, string $fileName, int $type){
		$t = $this->contactManager->search($contactUri, ['UID'], ['type' => true]);
		$websites = array_values($t)[0]['URL'];
		$peppolUpload = preg_grep('*./peppolnext/.*', $websites);
		$folder = $this->rootFolder->getUserFolder($this->userId)->get($this->folderManager->getFolderPath(Constants::SEND_DIRECTION));
		if ($type === Constants::PEPPOLNEXT_MEDIA_TYPE ){
			if (!empty($peppolUpload))
				$this->uploadService->upload($peppolUpload[0], $folder, $fileName);
		}
	}
	/**
	 * @return array
	 */
	public function getNotifications() : array{
		$sharedFolder = FolderManager::getSharedFolderAddress($this->dbConnection);
		$tempInbox = $this->rootFolder->get($sharedFolder);
		$new_messages =  count($tempInbox->getDirectoryListing());
		// check new connection request
		$new_connections = 2;
		return [
				"messages" => $new_messages,
				"connection_requests" => $new_connections
			];
	}

	/**
	 * @param string $xmlContent
	 * @return object
	 */
	public function deserializeXML(string $xmlContent) : object{
		$invoiceDesrializer = new DeserializeInvoice();
		$invoice = $invoiceDesrializer->deserializeXML($xmlContent) ;
		if (!$this->checkIncomingInvoiceValidity($invoice))
			throw new Error("invalid structured invoice submitted");
		return $invoice;
	}

	/**
	 * @return void
	 */
	public function getAllInvoices(int $type): array{

		$fol = $this->folderManager->getFolderPath($type);
		$folder = $this->rootFolder->getUserFolder($this->userId)->get($fol);
		/** @var File[] $files */
		$files = $folder->getDirectoryListing();

		$result = [] ;
		foreach ($files as $file)
		{
			$result[] = $this->getInvoiceSummary($file);
		}
		return $result;
	}

	/**
	 * @param int $page
	 * @return array
	 */
	public function getNewInvoices(int $page):array{
		$result = array();
		$inboxFolderPath = FolderManager::getSharedFolderAddress($this->dbConnection);
		/** @var Folder $newInvoices */
		$inboxFolder = $this->rootFolder->get($inboxFolderPath);

		/** @var File[] $newInvoices*/
		$newInvoices = $inboxFolder->getDirectoryListing();
		foreach ($newInvoices as $item) {
			$result[] = $this->getInvoiceSummary($item);
		}
		return $result;
	}

	public function markAsRead(string $fileName){
		$inboxAddress = FolderManager::getSharedFolderAddress($this->dbConnection);

		$userfolder = $this->rootFolder->getUserFolder($this->userId);

		/** @var File $inbox */
		$file = $this->rootFolder->get($inboxAddress."/".$fileName);

		$file->move($userfolder->getPath().'/'.$this->folderManager->getFolderPath(Constants::RECEIVE_DIRECTION)."/".$fileName);
		return true;
	}

	public function delete($filename){
		$inboxAddress = FolderManager::getSharedFolderAddress($this->dbConnection);

		/** @var File $inbox */
		$file = $this->rootFolder->get($inboxAddress."/".$filename);

		$file->delete();
		return true;
	}

	private function getInvoiceSummary(File $file) : InvoiceSummary
	{

		$invoice = $this->deserializeXML($file->getContent());
		$summary = new InvoiceSummary();
		$summary->orderId = $invoice->OrderReference->ID;
		$summary->amount = $invoice->LegalMonetaryTotal->PayableAmount;
		$summary->sender = $invoice->AccountingSupplierParty->Party->PartyName->Name;
		$summary->receiver = $invoice->AccountingCustomerParty->Party->PartyName->Name;
		$summary->fileName = $file->getName();
		$summary->amount = $invoice->LegalMonetaryTotal->PayableAmount;
		$summary->note = $invoice->Note;
		$summary->creationTime = date('Y-m-d h:m', $file->getMTime());
		return $summary;

	}
	private function getInvoiceMeta($filename) :array{
		$firstDash = strpos($filename, "-");
		return [
			\Safe\substr($filename,0,$firstDash),
			\Safe\substr($filename, $firstDash+1, (strlen($filename)-(5+$firstDash)))
		];
	}
	private function createPostalAddress(Helper\PostalAddress $address){
		$location = (new PostalAddress())
			->setCountry((new Country())->setIdentificationCode($address->country))
			->setCityName($address->city)
			->setPostalZone($address->postalZone)
			->setStreetName($address->street)
			->setAddionalStreetName($address->additionalStreet)
			->setBuildingNumber($address->buildingNo);
		return $location;
	}
	private function checkIncomingInvoiceValidity(object $invoice){
		if (empty($invoice->AccountingSupplierParty)
			|| empty($invoice->AccountingCustomerParty)
			|| empty($invoice->InvoiceLine)){
			return false;
		}
		return true;
	}

	/*
	* @noadminrequired
	* @nocsrfrequired
	* @publicpage
	* @cors
	*/
	public function as4Endpoint() {
		error_log('AS4 endpoint function was called!');
	}
}
