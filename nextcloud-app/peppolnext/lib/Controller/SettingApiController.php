<?php

namespace OCA\PeppolNext\Controller;

use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Db\NextUser;
use OCA\PeppolNext\Db\PeppolIdentity;
use OCA\PeppolNext\Service\NextUserService;
use OCA\PeppolNext\Service\Peppol\LetsPeppolService;
use OCA\PeppolNext\Service\Peppol\AS4DirectService;

use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCP\IURLGenerator;
use OCP\IUserSession;

use OC\AppFramework\Http;

class SettingApiController extends ApiController
{

	/** @var IURLGenerator */
    private $urlGenerator;

	/** @var IUserSession */
    private $userSession;

	/** @var NextUserService  */
	private $nextUserService;


	/** @var LetsPeppolService  */
	private $letsPeppolService;
	/** @var AS4DirectService  */
	private $as4DirectService;

	public function __construct(IRequest $request
		, IURLGenerator $urlGenerator
		, IUserSession $userSession
		, NextUserService $nextUserService
		, LetsPeppolService $letsPeppolService
		, AS4DirectService $as4DirectService)
	{
		parent::__construct(Application::APP_ID, $request);
		$this->urlGenerator = $urlGenerator;
		$this->userSession = $userSession;
		$this->nextUserService = $nextUserService;
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
			'letspeppol' => $this->identityToArray($letsPeppolIdentity),
			'as4direct' => $this->identityToArray($as4DirectIdentity),
			'address' => $this->getAddress()
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
		return new DataResponse($this->identityToArray($letsPeppolIdentity), Http::STATUS_OK);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function createas4direct() : DataResponse {
		$as4DirectIdentity = $this->as4DirectService->generateIdentity();
		return new DataResponse($this->identityToArray($as4DirectIdentity), Http::STATUS_OK);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function updateAddress() : DataResponse {
		$next_user = $this->nextUserService->getNextUser();

		if ($next_user == null) {
			$next_user = new NextUser();

			$user = $this->userSession->getUser();
			$next_user->setUserId($user->getUID());
		}

		$address = $this->request->getParams("body");

		$next_user->setAddress(json_encode($address));

		$next_user = $this->nextUserService->updateNextUser($next_user);

		return new DataResponse($address, Http::STATUS_OK);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function asSupplier() : DataResponse {
		$user = $this->userSession->getUser();

		$supplier = [
			'name' => $user->getDisplayName(),
			'email' => $user->getEMailAddress(),
			'address' => $this->getAddress()
		];

		return new DataResponse($supplier, Http::STATUS_OK);
	}

	private function getAddress(): array {
		$next_user = $this->nextUserService->getNextUser();

		if ($next_user != null) {
			return json_decode($next_user->getAddress(), true);
		}
		else {
			return [
				'line1' => '',
				'line2' => '',
				'city' => '',
				'post_code' => '',
				'state' => '',
				'country' => []
			];
		}
	}

	private function identityToArray(?PeppolIdentity $identity): array {
		if ($identity != null) {
			return [
				'scheme' => $identity->getScheme(),
				'id' => $identity->getPeppolId(),
				'endpoint' => $this->urlGenerator->linkToRouteAbsolute(Application::APP_ID.'.message_api.as4Endpoint'),
				'certificate' => $identity->getCertificate()
			];
		}
		else {
			return [
				'scheme' => '',
				'id' => '',
				'endpoint' => '',
				'certificate' => ''
			];
		}
	}

}
