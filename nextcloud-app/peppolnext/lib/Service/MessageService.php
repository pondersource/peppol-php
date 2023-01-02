<?php

namespace OCA\PeppolNext\Service;

use OCA\PeppolNext\Db\Message;
use OCA\PeppolNext\Db\MessageMapper;
use OCA\PeppolNext\Db\PeppolIdentity;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCA\PeppolNext\Service\Helper\VCardInterpreter;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\InvoiceSummary;
use OCA\PeppolNext\Service\Model\MessageBuilder;
use OCA\PeppolNext\Service\Model\PeppolContact;
use OCA\PeppolNext\Settings\AppSettingManager;

use OC\Files\Node\File;
use OC\Files\Node\Folder;
use OCA\DAV\Connector\Sabre\Node;
use OCP\IDBConnection;
use OCP\Contacts\IManager;
use OCP\Files\IRootFolder;
use OCP\Files\NotPermittedException;
use OCP\Lock\ILockingProvider;

use JMS\Serializer\SerializerBuilder;
use PhpParser\Error;
use Safe\DateTime;

use Exception;

class MessageService {

	private const MESSAGE_FOLDER = 'messages';
	private const MESSAGE_FILE = 'message.xml';
	private const PAYLOAD_FILE = 'payload.xml';

	private const PAGE_SIZE = 5;

	/** @var IRootFolder*/
	private IRootFolder $rootFolder;

	/** @var FolderManager*/
	private FolderManager $folderManager;

	/** @var AppSettingManager */
	private $appSettingManager;

	/** @var MessageMapper */
	private $messageMapper;

	private IDBConnection $dbConnection;
	private IManager $contactManager;
	private UploadService $uploadService;
	private $userId;


	public function __construct(IRootFolder $rootFolder
		, AppSettingManager $settingManager
		, FolderManager $foldermanager
		, MessageMapper $messageMapper
		, IManager $contacManager
		, IDBConnection $dbConnection
		, UploadService $uploadService
		, $userId)
	{
		$this->rootFolder = $rootFolder;
		$this->userId = $userId;
		$this->folderManager = $foldermanager;
		if (isset($userId)) {
			$this->folderManager->createAllFolders($rootFolder->getUserFolder($userId), $rootFolder, $dbConnection);
		} else {
			$this->folderManager->createAllFolders(null, $rootFolder, $dbConnection);
		}
		$this->messageMapper = $messageMapper;
		$this->appSettingManager = $settingManager;
		$this->contactManager = $contacManager;
		$this->dbConnection = $dbConnection;
		$this->uploadService = $uploadService;
	}

	/**
	 * This method is used from the GUI with logged-in user
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

	public function saveIncoming(PeppolContact $sender
			, PeppolIdentity $receiver
			, int $messageType
			, ?string $title
			, string $header
			, string $payload): bool {
		$message = new Message();
		$message->setUserId($receiver->getUserId());
		$message->setContactId($sender->uid);
		$message->setContactName($sender->title);
		$message->setTitle($title);
		$message->setMessageType($messageType);
		$message->setCategory(Message::CATEGORY_INBOX);

		return $this->saveMessage($message, $header, $payload);
	}

	public function saveConnectionRequest(string $sender_identity
			, PeppolIdentity $receiver
			, int $messageType
			, ?string $title
			, string $header
			, string $payload): bool {
		$message = new Message();
		$message->setUserId($receiver->getUserId());
		$message->setContactId(null);
		$message->setContactName($sender_identity);
		$message->setTitle($title);
		$message->setMessageType($messageType);
		$message->setCategory(Message::CATEGORY_CONNECTION_REQUEST);

		return $this->saveMessage($message, $header, $payload);
	}

	private function saveMessage(Message $message, string $header, string $payload): bool {
		$this->dbConnection->beginTransaction();
		$message = $this->messageMapper->insert($message);

		try {
			$path = self::MESSAGE_FOLDER . '/' . $message->getId() . '/';
			$this->folderManager->createFile($path . self::MESSAGE_FILE, $header);
			$this->folderManager->createFile($path . self::PAYLOAD_FILE, $payload);
		} catch (Exception $e) {
			$this->dbConnection->rollBack();
			return false;
		}

		$this->dbConnection->commit();
		return true;
	}

	public function getMessages(int $category, int $page): array {
		$start = ($page - 1) * self::PAGE_SIZE;
		return $this->messageMapper->getAll($category, $start, self::PAGE_SIZE);
	}

	public function getMessageCount(int $category) {
		return $this->messageMapper->getCount($category);
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
		$serializer = \JMS\Serializer\SerializerBuilder::create()->build();
		$sbd = $serializer->deserialize($xmlContent, 'OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocument::class', 'xml');
		$invoice = $sbd->getInvoice();
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
		error_log("deserialized invoice!");
		// error_log(var_export($invoice, true));
		$summary = new InvoiceSummary();
		$summary->orderId = ($invoice->getOrderReference() ? $invoice->getOrderReference()->getId() : 0);
		$summary->amount = $invoice->getLegalMonetaryTotal()->getPayableAmount()->getValue();
		$summary->sender = $invoice->getAccountingSupplierParty()->getParty()->getPartyName()->getName();
		$summary->receiver = $invoice->getAccountingCustomerParty()->getParty()->getPartyName()->getName();
		$summary->fileName = $file->getName();
		$summary->amount = $invoice->getLegalMonetaryTotal()->getPayableAmount()->getValue();
		$summary->note = ($invoice->getNote() ? $invoice->getNote() : '');
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
		if (empty($invoice->getAccountingSupplierParty())
			|| empty($invoice->getAccountingCustomerParty())
			|| empty($invoice->getInvoiceLines())){
			return false;
		}
		return true;
	}
}
