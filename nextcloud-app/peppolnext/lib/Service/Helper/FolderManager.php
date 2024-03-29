<?php

namespace OCA\PeppolNext\Service\Helper;

use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\IRootFolder;
use OCP\Files\Node;
use OCP\Files\NotFoundException;
use OCP\Files\Storage;
use OCP\IDBConnection;
use OCP\IUserSession;

use OCA\GroupFolders\Folder\FolderManager as GroupFolder;
use OCA\PeppolNext\Service\Model\Constants;

class FolderManager
{

	private const PEPPOL_NEXT_ROOT = "PeppolNext";
	private const PEPPOL_SENDBOX = "Sent";
	private const PEPPOL_INBOX = "Received";
	private const INVOICE_FOLDER_NAME = "Invoices" ;
	private const TEMP_INBOX_FOLDER_NAME = "PeppolTempInbox";

	/** @var IRootFolder */
	private $rootFolder;

	/** @var IUserSession */
    private $userSession;

	public function __construct(IRootFolder $rootFolder, IUserSession $userSession) {
		$this->rootFolder = $rootFolder;
		$this->userSession = $userSession;
	}

	public function getPath(): string {
		return $this->getRoot()->getPath();
	}

	public function get(string $path): ?Node {
		$root = $this->getRoot();

		try {
			return $root->get($path);
		} catch (NotFoundException $e) {
			return null;
		}
	}

	public function getForUser(string $path, string $userId): ?Node {
		$root = $this->getRootForUser($userId);

		try {
			return $root->get($path);
		} catch (NotFoundException $e) {
			return null;
		}
	}

	public function createFile($path, $content): File {
		$root = $this->getRoot();

		self::mkdirs($root, $path, false);

		return $root->newFile($path, $content);
	}

	public function createFileForUser($path, $content, $userId): File {
		$root = $this->getRootForUser($userId);

		self::mkdirs($root, $path, false);

		return $root->newFile($path, $content);
	}

	private function getRoot(): Folder {
		$user = $this->userSession->getUser();

		return $this->getRootForUser($user->getUID());
	}

	private function getRootForUser(string $userId): Folder {
		$userFolder = $this->rootFolder->getUserFolder($userId);

		if (!$userFolder->nodeExists(self::PEPPOL_NEXT_ROOT)) {
			return $userFolder->newFolder(self::PEPPOL_NEXT_ROOT);
		}

		return $userFolder->get(self::PEPPOL_NEXT_ROOT);
	}

	private static function mkdirs(Folder $root, string $path, bool $all_dirs): bool {
		$path_elements = explode('/', $path);
		$path_elements = array_filter($path_elements, "strlen");

		if (!$all_dirs) {
			if (count($path_elements) == 0) {
				return true;
			}

			$path_elements = array_slice($path_elements, 0, -1);
		}

		foreach ($path_elements as $path_element) {
			if ($root->nodeExists($path_element)) {
				if ($root->getType() === Node::TYPE_FOLDER) {
					$root = $root->get($path_element);
				}
				else {
					return false;
				}
			}
			else {
				$root = $root->newFolder($path_element);
			}
		}

		return true;
	}

	public function getTempInbox() : string{
		return self::TEMP_INBOX_FOLDER_NAME;
	}
	private function getInvoiceInbox() : string{
		return self::PEPPOL_NEXT_ROOT."/".self::PEPPOL_INBOX."/".self::INVOICE_FOLDER_NAME;
	}

	private function getInvoiceOutbox() : string{
		return self::PEPPOL_NEXT_ROOT."/".self::PEPPOL_SENDBOX."/".self::INVOICE_FOLDER_NAME;
	}

	/**
	 * @param Folder $userFolder or null
	 * @return void
	 * @throws \OCP\Files\NotPermittedException
	 * @description this try to initial PeppolNext folders
	 */
	public function createAllFolders(?Folder $userFolder, Folder $rootFolder, IDBConnection $dbConnection){
    if ($userFolder) {
			if(!$userFolder->nodeExists($this->getInvoiceInbox())){
				$userFolder->newFolder($this->getInvoiceInbox());
			}
			if(!$userFolder->nodeExists($this->getInvoiceOutbox())){
				$userFolder->newFolder($this->getInvoiceOutbox());
			}
		}
		$sharedFolder = $this->getSharedFolderAddress($dbConnection);
		if(!$rootFolder->nodeExists($sharedFolder)){
			$rootFolder->newFolder($sharedFolder);
		}
	}

	/**
	 * @param int $messageType use this class MSG_TYPE constants
	 * @param int $direction use this class DIRECTION constants
	 * @return void
	 */
	public function getFolderPath(int $direction) : string{
		if($direction === Constants::RECEIVE_DIRECTION) {
			return $this->getInvoiceInbox();
		}

		else {
			return $this->getInvoiceOutbox();
		}

	}

	/**
	 * @param string $fileName
	 * @param int $messageType use this class MSG_TYPE constants
	 * @param int $direction use this class DIRECTION constants
	 * @return string
	 */
	public function generateFilePath(string $fileName, int $direction): string{
		return $this->getFolderPath($direction)."/".$fileName;
	}

	/**
	 * @description  check existence of shared temporary inbox and if it is not there will create
	 * that and finally return the access path to the folder
	 *
	 * @param IDBConnection $dbConnection
	 * @return string path of temporary inbox
	 */
	public static function  getSharedFolderAddress(IDBConnection $dbConnection) : string{

		///check if shared folder is not created generate it automatically
		$folderManager = new GroupFolder($dbConnection);
		$allGroupFolders = $folderManager->getAllFolders();
		$tempInbox = array_filter($allGroupFolders, function ($item){
			return $item["mount_point"] == self::TEMP_INBOX_FOLDER_NAME;
		});

		$id = -1;
		if (empty($tempInbox)){
			$id = $folderManager->createFolder(self::TEMP_INBOX_FOLDER_NAME);
			$folderManager->addApplicableGroup($id, "admin");
			$folderManager->setGroupPermissions($id, "admin", 31); //read write delete
			$folderManager->setFolderQuota($id, -3);
		}else{
			$id = reset($tempInbox)["id"];
		}
		return "__groupfolders/".$id;
	}

}
