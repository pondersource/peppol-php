<?php
namespace OCA\PeppolNext\Settings;


use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Service\Helper\PostalAddress;
use OCP\IConfig;

class AppSettingManager
{

	/** @var IConfig */
	private $config;

	private const FULLNAME = "fullname";
	private const EMAIL = "email";
	private const PEPPOL_SCHEME = "peppolScheme";
	private const PEPPOL_ID = "peppolId";
	private const BUILDING_NO="buildingNo";
	private const POSTAL_ZONE = "postalZone";
	private const ADDITIONAL_STREET = "additionStreet";
	private const STREET = "street";
	private const CITY = "city";
	private const COUNTRY = "country";
	private const FAX_NO = "faxNo";
	private const PHONE_NO = "phoneNo";
	public function __construct(IConfig $config){
		$this->config = $config;
	}
	private $keys = [
		self::FULLNAME,
		self::EMAIL,
		self::PEPPOL_SCHEME,
		self::PEPPOL_ID,
		self::BUILDING_NO,
		self::POSTAL_ZONE,
		self::ADDITIONAL_STREET,
		self::STREET,
		self::CITY,
		self::COUNTRY,
		self::FAX_NO,
		self::PHONE_NO
	];

	/**
	 * @return array
	 */
	public function getAllSettings(): array
	{
		$result = [] ;
		foreach ($this->keys as $key) {
			$result[$key] = $this->config->getAppValue(Application::APP_ID, $key);
		}
		return $result;
	}

	/**
	 * @param array $newValues
	 * @return void
	 */
	public function updateSettings(array $newValues) :void{
		foreach ( $newValues as $key=>$value ){
			$this->config->setAppValue(Application::APP_ID, $key, $value);
		}
	}

	public function getFullname() : string{
		return $this->config->getAppValue(Application::APP_ID,self::FULLNAME);
	}

	public function getEmail() : string{
		return $this->config->getAppValue(Application::APP_ID,self::EMAIL);
	}
	public function getPeppolScheme() : string{
		return $this->config->getAppValue(Application::APP_ID,self::PEPPOL_SCHEME);
	}
	public function getPeppolID() : string{
		return $this->config->getAppValue(Application::APP_ID,self::PEPPOL_ID);
	}
	public function getFaxNo() : string{
		return $this->config->getAppValue(Application::APP_ID,self::FAX_NO);
	}
	public function getPhoneNo() : string{
		return $this->config->getAppValue(Application::APP_ID,self::PHONE_NO);
	}

	public function getAddress() : PostalAddress
	{
		$postalAddress = new PostalAddress();
		$postalAddress->country = $this->config->getAppValue(Application::APP_ID, self::COUNTRY);
		$postalAddress->city = $this->config->getAppValue(Application::APP_ID, self::CITY);
		$postalAddress->street = $this->config->getAppValue(Application::APP_ID, self::STREET);
		$postalAddress->additionalStreet = $this->config->getAppValue(Application::APP_ID, self::ADDITIONAL_STREET);
		$postalAddress->postalZone =  $this->config->getAppValue(Application::APP_ID, self::POSTAL_ZONE);
		$postalAddress->buildingNo = $this->config->getAppValue(Application::APP_ID, self::BUILDING_NO);
		return $postalAddress;
	}


}
