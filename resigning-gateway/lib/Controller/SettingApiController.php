<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Settings\AppSettingManager;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class SettingApiController extends ApiController
{
	/** @var AppSettingManager  */
	private $settingManager;
	public function __construct(
		IRequest $request,
		AppSettingManager $settingManager,
		IRootFolder $rootFolder,
		$userId
	){
		parent::__construct(Application::APP_ID, $request);
		$this->settingManager = $settingManager;
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
}
