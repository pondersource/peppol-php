<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Settings\AppSettingManager;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\DataDisplayResponse;
use OCP\Files\IRootFolder;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCP\IDBConnection;
use OCP\IRequest;

class SettingApiController extends ApiController
{
	/** @var AppSettingManager  */
	private $settingManager;
	private $dbConnection;
	public function __construct(IRequest $request
		, IRootFolder $rootFolder
		, AppSettingManager $settingManager
		, FolderManager $foldermanager
		, IDBConnection $dbConnection
		, $userId)
	{
		parent::__construct(Application::APP_ID, $request);
		$this->settingManager = $settingManager;
		$this->dbConnection = $dbConnection;
		$this->folderManager = $foldermanager;
		$this->rootFolder = $rootFolder;
		$this->userId = $userId;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() : DataResponse{

		$result = $this->settingManager->getAllSettings();
		return new DataResponse($result, Http::STATUS_OK) ;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function create(){
		$body = $this->request->getParam("body");
		$this->settingManager->updateSettings($body);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 */
	public function cert() {
		$sharedFolderAddress = FolderManager::getSharedFolderAddress($this->dbConnection);
		$sharedFolder = $this->rootFolder->get($sharedFolderAddress);
		$node = $sharedFolder->get('cert.p12');
    // error_log(json_encode($node));
		return new DataDisplayResponse($node->getContent());
		// passthru('/var/www/html/cert.p12');
	}
}
