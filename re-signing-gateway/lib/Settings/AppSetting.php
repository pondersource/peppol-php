<?php

namespace OCA\PeppolNext\Settings;

use OCA\PeppolNext\AppInfo\Application;
use OCP\BackgroundJob\IJobList;
use OCP\IDateTimeFormatter;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IL10N;
use OCP\Settings\ISettings;

class AppSetting implements ISettings
{

	/** @var IConfig */
	private $config;

	/** @var IL10N */
	private $l ;

	/**@var \OCP\IDateTimeFormatter */
	private $dateTimeFormatter;

	/** @var IJobList */
	private $jobList ;
	public function __construct(
		IConfig           $config,
		IL10N             $localization,
		IDateTimeFormatter $dateTimeFormatter,
		IJobList $jobList
	){

		$this->config = $config;
		$this->l = $localization;
		$this->dateTimeFormatter = $dateTimeFormatter;
		$this->jobList = $jobList;
	}

	public function getForm()
	{
		$conf = [
			"name" => "navid",
			"family" => "shokri",
			"email" => "navid.pdp11@gmail.com",
			"peppolId" => "#peppol#"
			];
		return new TemplateResponse(Application::APP_ID,"admin",$conf);
	}

	public function getSection()
	{
		return "additional";
	}

	public function getPriority()
	{
	 	return 1;
	}
}
