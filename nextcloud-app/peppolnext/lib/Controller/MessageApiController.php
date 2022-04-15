<?php

namespace OCA\PeppolNext\Controller;

use OC\AppFramework\Http;
use OCA\PeppolNext\Service\MessageService;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\MessageBuilder;
use OCA\PeppolNext\Service\UploadService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\Files\IRootFolder;
use OCP\IRequest;
use OCP\Contacts\IManager;

class MessageApiController extends ApiController {

	/** @var string */
	private $userId;
	/** @var IRootFolder */
	private $rootFolder;
	/** @var IManager */
	private $contactManager;

	/** @var MessageService */
	private $messageService;

	private UploadService $uploadService;
	use Errors;

	public function __construct(IRequest $request,
								IRootFolder $rootFolder,
								MessageService $messageService,
								UploadService $uploadService,
								$userId) {
		parent::__construct("peppolnext", $request);
		$this->userId = $userId;
		$this->rootFolder = $rootFolder;
		$this->messageService = $messageService;
		$this->uploadService = $uploadService;
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		$type = $this->request->getParam("type");
		$direction = ($type === "Inbox") ? Constants::RECEIVE_DIRECTION : Constants::SEND_DIRECTION;
		$response = $this->messageService->getAllInvoices($direction);
		return new DataResponse(
			[
				"items" => $response,
				"totalCount" => count($response)
			]);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function create() {
		$body = $this->request->getParam("body");
		$messageBuilder = new MessageBuilder($body);
		if ($messageBuilder->hasError()){
			return new DataResponse(["success"=> false, "errors" => $messageBuilder->getErrors()]);
		}
		$fileName = $this->getFileName($messageBuilder->getOrderReference());
		$content = $this->messageService->serializeXML($messageBuilder);
		$this->messageService->save($content, $fileName);
		$this->messageService->send($messageBuilder->getReceiver()->uid, $fileName, $messageBuilder->getMediaType());
		return new DataResponse(["success"=> true, "errors"=>[]]);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function getNewReceivedMessages(){
		$page = $this->request->getParam("page") ;
		$response  = $this->messageService->getNewInvoices($page);
		return new DataResponse($response, Http::STATUS_OK);

	}

	/**
	 * @return DataResponse
	 */
	public function markAsRead() : DataResponse{
		try {
			$fileName = $this->request->getParam("filename");
			$this->messageService->markAsRead($fileName);
			return new DataResponse(["message"=> "done"], Http::STATUS_OK);
		}catch (\Throwable $ex){
			return new DataResponse(["message"=> $ex->getMessage()], Http::STATUS_CONFLICT);
		}
	}

	/**
	* @return DataResponse
	*/
	public function delete() : DataResponse {
		try {
			$fileName = $this->request->getParam("filename");
			$this->messageService->delete($fileName);
			return new DataResponse(["message"=> "done"], Http::STATUS_OK);
		} catch (\Throwable $ex) {
			return new DataResponse(["message"=> $ex->getMessage()], Http::STATUS_CONFLICT);
		}
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function getNotification(){
		return new DataResponse($this->messageService->getNotifications(), Http::STATUS_OK);
	}

	private function getFileName($orderName) :string{
		return $orderName."-". (new \DateTime())->format("Y-m-d").".xml";
	}




}
