<?php
namespace OCA\PeppolNext\Controller;

use OCA\PeppolNext\Service\ContactService;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\PeppolContactBuilder;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ContactApiController extends ApiController {

	private ContactService $contactService;
	public function __construct(IRequest $request,
								ContactService $contactService,
								$userId) {
		parent::__construct("peppolnext", $request);
		$this->userId = $userId;
		$this->contactService = $contactService;
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * @param string $needle
	 * @return DataResponse
	 */
	public function search(): DataResponse{

		$needle = $this->request->getParam('needle');
		$local = $this->contactService->readLocalPeppolContact($needle);
		$remote = $this->contactService->readPeppolDirectory($needle);
		foreach ($remote as $contact)
		{
			$existsInLocal =
				array_search(Constants::PEPPOL_INDICATOR.$contact->peppolEndpoint,
					array_column($local, "peppolEndpoint"));

			if (!$existsInLocal){
				$local[] = $contact;
			}
		}
		return new DataResponse( $local, Http::STATUS_OK);
	}
	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * @return DataResponse
	 */
	public function create() : DataResponse
	{
		$payload = $this->request->getParams("body");
		$contact = new PeppolContactBuilder();
		$contact->setPeppolId($payload["peppolEndpoint"])
			->setFullname($payload["title"]);
		$this->contactService->addContact($contact);
		return new DataResponse([], Http::STATUS_ACCEPTED);
	}


}
