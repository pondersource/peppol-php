<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCA\PeppolNext\Service\MessageService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\Files\IRootFolder;
use OCP\IDBConnection;
use OCP\IRequest;

class UploadApiController extends ApiController
{
	private IRootFolder $rootFolder;
	private IDBConnection $dbConnection;
	private MessageService $messageService;

	public function __construct(IRequest $request
								,IRootFolder $rootFolder
								,IDBConnection $dbConnection
								,MessageService $messageService
	) {
		parent::__construct("peppolnext", $request);
		$this->rootFolder = $rootFolder;
		$this->dbConnection = $dbConnection;
		$this->messageService = $messageService;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 */
	public function receiveNew(){

		$stream = $this->request->getUploadedFile("file");
		$file = fopen($stream['tmp_name'], 'r');
		$contents = "";
		if ($file) {
			$contents = fread($file, $stream['size']);
			fclose($file);
		}
		$sharedFolderAddress = FolderManager::getSharedFolderAddress($this->dbConnection);

		$sharedFolder = $this->rootFolder->get($sharedFolderAddress);

		try {
			$invoice = $this->messageService->deserializeXML($contents);
			$sharedFolder->newFile($stream["name"], $contents);
			return new DataResponse(["msg" => "done"]);
		}
		catch (\Throwable $ex){
			return new DataResponse(["msg" => $ex->getMessage()], Http::STATUS_BAD_REQUEST);
		}
	}


}
