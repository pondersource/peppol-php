<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Service\LetsPeppolService;
use OCA\PeppolNext\Service\AS4DirectService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class SettingApiController extends ApiController
{

	/** @var LetsPeppolService  */
	private $letsPeppolService;

	/** @var AS4DirectService  */
	private $as4DirectService;

	public function __construct(IRequest $request
		, LetsPeppolService $letsPeppolService
		, AS4DirectService $as4DirectService)
	{
		parent::__construct(Application::APP_ID, $request);
		$this->letsPeppolService = $letsPeppolService;
		$this->as4DirectService = $as4DirectService;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() : DataResponse {
		$letsPeppolIdentity = $this->letsPeppolService->getIdentity();
		$as4DirectIdentity = $this->as4DirectService->getIdentity();

		$result = [
			'letspeppol' => $letsPeppolIdentity,
			'as4direct' => $as4DirectIdentity
		];

		//$result = $this->settingManager->getAllSettings();
		return new DataResponse($result, Http::STATUS_OK);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function createletspeppol() : DataResponse {
		$letsPeppolIdentity = $this->letsPeppolService->generateIdentity();
		return new DataResponse($letsPeppolIdentity, Http::STATUS_OK);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function createas4direct() : DataResponse {
		$as4DirectIdentity = $this->as4DirectService->generateIdentity();
		return new DataResponse($as4DirectIdentity, Http::STATUS_OK);
	}

}
