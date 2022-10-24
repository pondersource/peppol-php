<?php

namespace OCA\PeppolNext\Controller;

use OCA\PeppolNext\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller {
	/** @var IConfig */
	private $iconfig;
	public function __construct(IRequest $request, IConfig $config) {
		parent::__construct(Application::APP_ID, $request);
		$this->iconfig = $config;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * Render default template
	 */
	public function index() {
		Util::addScript(Application::APP_ID, 'peppolnext-main');

		return new TemplateResponse(Application::APP_ID, 'main');
	}
}
