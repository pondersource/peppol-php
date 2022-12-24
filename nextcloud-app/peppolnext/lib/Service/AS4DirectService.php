<?php

namespace OCA\PeppolNext\Service;

use Exception;

use phpseclib3\Crypt\{RSA, Random};
use phpseclib3\File\X509;

use OCP\IUserSession;
use OCP\IURLGenerator;

use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCA\PeppolNext\Db\AS4DirectMapper;
use OCA\PeppolNext\Db\AS4Direct;

class AS4DirectService {

	private const IDENTITY_FILE = 'AS4DirectIdentity';
	private const KEYSTORE_FILE = 'AS4DirectIdentity.p12';

	/** @var IUserSession */
    private $userSession;

	/** @var IURLGenerator */
    private $urlGenerator;

	/** @var FolderManager */
	private $folderManager;

	/** @var AS4DirectMapper */
	private $as4DirectMapper;

	public function __construct(IUserSession $userSession
		, IURLGenerator $urlGenerator
		, FolderManager $folderManager
		, AS4DirectMapper $as4DirectMapper) {
		$this->userSession = $userSession;
		$this->urlGenerator = $urlGenerator;
		$this->folderManager = $folderManager;
		$this->as4DirectMapper = $as4DirectMapper;
	}

	public function getIdentity() {
		$user = $this->userSession->getUser();
		$user_id = $user->getUID();

		try {
			$as4Direct = $this->as4DirectMapper->find($user_id);

			return [
				'scheme' => $as4Direct->getScheme(),
				'id' => $as4Direct->getPeppolId(),
				'endpoint' => $this->urlGenerator->linkToRouteAbsolute(Application::APP_ID.'.message_api.as4Endpoint'),
				'public_key' => $as4Direct->getPublicKey()
			];
		} catch(Exception $e) {
			return [
				'scheme' => '',
				'id' => '',
				'endpoint' => '',
				'public_key' => ''
			];
		}

		$file = $this->folderManager->get(self::IDENTITY_FILE);

		if ($file != null) {
			$file_contents = $file->getContent();
			$identity = json_decode($file_contents, true);
			$identity['endpoint'] = $this->urlGenerator->linkToRouteAbsolute(Application::APP_ID.'.message_api.as4Endpoint');
			return $identity;
		}
		else {
			return [
				'scheme' => '',
				'id' => '',
				'endpoint' => '',
				'public_key' => ''
			];
		}
	}

	public function generateIdentity() {
		$user = $this->userSession->getUser();
		$user_id = $user->getUID();
		$name = $user->getDisplayName();

		$privateKey = RSA::createKey(2048)->withPadding(RSA::ENCRYPTION_OAEP);
		$publicKey = $privateKey->getPublicKey();
		
		$subject = new X509();
		$subject->setPublicKey($publicKey);
		$subject->setDN("/O=$name");

		$issuer = new X509();
		$issuer->setPrivateKey($privateKey);
		$issuer->setDN("/O=$name");

		$x509 = new X509();
		$result = $x509->sign($issuer, $subject); 
		$certificate = $x509->saveX509($result);

		$keystore_password = $user->getUID();
		$keystore_content = null;

		if (!openssl_pkcs12_export($certificate, $keystore_content, $privateKey->__toString(), $keystore_password)) {
			throw new Exception("Error Processing Request", 1);
		}

		$this->folderManager->createFile(self::KEYSTORE_FILE, $keystore_content);

		try {
			$as4Direct = $this->as4DirectMapper->find($user_id);
			$as4Direct->setUserId($user_id);
			$as4Direct->setScheme('iso6523-actorid-upis');
			$as4Direct->setPeppolId(uniqid('as4direct-'));
			$as4Direct->setPublicKey($publicKey->__toString());
			$this->as4DirectMapper->update($as4Direct);
		} catch(Exception $e) {
			$as4Direct = new AS4Direct();
			$as4Direct->setUserId($user_id);
			$as4Direct->setScheme('iso6523-actorid-upis');
			$as4Direct->setPeppolId(uniqid('as4direct-'));
			$as4Direct->setPublicKey($publicKey->__toString());
			$this->as4DirectMapper->insert($as4Direct);
		}

		return [
			'scheme' => $as4Direct->getScheme(),
			'id' => $as4Direct->getPeppolId(),
			'endpoint' => $this->urlGenerator->linkToRouteAbsolute(Application::APP_ID.'.message_api.as4Endpoint'),
			'public_key' => $as4Direct->getPublicKey()
		];
	}

}
