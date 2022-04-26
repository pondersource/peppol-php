<?php

namespace OCA\PeppolNext\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap{
	public const APP_ID = 'peppolnext';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void
	{

		require_once __DIR__.'/../../vendor/autoload.php';
	}

	public function boot(IBootContext $context): void
	{
	}
}
