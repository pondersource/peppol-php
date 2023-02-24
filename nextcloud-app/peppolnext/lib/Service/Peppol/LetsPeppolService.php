<?php

namespace OCA\PeppolNext\Service\Peppol;

use OCA\PeppolNext\Db\PeppolIdentity;
use OCA\PeppolNext\Db\PeppolIdentityMapper;
use OCA\PeppolNext\Service\Helper\FolderManager;
use OCA\PeppolNext\Service\Helper\PostalAddress;
use OCA\PeppolNext\Service\NextUserService;
use OCA\PeppolNext\Service\Peppol\LetsPeppol\LetsPeppolApi;

use OCP\IURLGenerator;
use OCP\IUserSession;

use phpseclib3\Crypt\{RSA, Random};
use phpseclib3\File\X509;

class LetsPeppolService implements IPeppolService {

	public const SERVICE_NAME = 'LetsPeppolService';
	
	private const KEYSTORE_FILE = 'keystore.p12';
	private const CERTIFICATE_FILE = 'certificate.p12';

	/** @var IURLGenerator */
    private $urlGenerator;

	/** @var IUserSession */
    private $userSession;

	/** @var FolderManager */
	private $folderManager;

	/** @var PeppolIdentityMapper */
	private $peppolIdentityMapper;

	/** @var NextUserService  */
	private $nextUserService;

	/** @var LetsPeppolApi */
	private $api;

	public function __construct(IURLGenerator $urlGenerator
			, IUserSession $userSession
			, FolderManager $folderManager
			, NextUserService $nextUserService
			, PeppolIdentityMapper $peppolIdentityMapper
			, LetsPeppolApi $api) {
		$this->urlGenerator = $urlGenerator;
		$this->userSession = $userSession;
		$this->folderManager = $folderManager;
		$this->nextUserService = $nextUserService;
		$this->peppolIdentityMapper = $peppolIdentityMapper;
		$this->api = $api;
	}

	public function getServiceName(): string {
		return self::SERVICE_NAME;
	}

	public function getIdentity(): ?PeppolIdentity {
		$user = $this->userSession->getUser();
		$user_id = $user->getUID();

		try {
			$identity = $this->peppolIdentityMapper->findUserIdentity($user_id, self::SERVICE_NAME);

			if (empty($identity->getScheme())) {
				$keystore_file = $this->folderManager->get(self::KEYSTORE_FILE);

				if (isset($keystore_file)) {
					$keystore = $keystore_file->getContent();

					if (!openssl_pkcs12_read($keystore, $cert_info, $user_id)) {
						echo "Error: Unable to read the key store.\n";
						return [null, null];
					}
			
					$private_key = RSA::loadPrivateKey($cert_info['pkey']);

					$letspeppol_identity = $this->api->getIdentity($identity->getData(), $private_key);

					if ($letspeppol_identity['kyc_status'] === 2) {
						$identity->setScheme($letspeppol_identity['identifierScheme']);
						$identity->setPeppolId($letspeppol_identity['identifierValue']);

						$certificate = $letspeppol_identity['as4direct_certificate'];
						$keystore_password = $user_id;
						$keystore_content = null;
				
						if (!openssl_pkcs12_export($certificate, $keystore_content, $private_key->__toString(), $keystore_password)) {
							throw new Exception("Error Processing Request", 1);
						}
				
						$this->folderManager->createFile(self::CERTIFICATE_FILE, $keystore_content);
						$this->peppolIdentityMapper->update($identity);
					}
					else if ($letspeppol_identity['kyc_status'] === 1) {
						// Rejected!
						$this->peppolIdentityMapper->delete($identity);
						return null;
					}
				}
			}

			return $identity;
		} catch(Exception $e) {
			return null;
		}
	}

	public function getCertificateStore(PeppolIdentity $identity): ?string {
		$file = $this->folderManager->getForUser(self::KEYSTORE_FILE, $identity->getUserId());

		return $file->getContent();
	}

	public function generateIdentity(): PeppolIdentity {
		$identity = $this->getIdentity();

		if (!empty($identity)) {
			if (empty($identity->getScheme())) {
				throw new \Exception('Already have an identity');
			}
			else {
				throw new \Exception('Identity pending KYC approval');
			}
		}

		$next_user = $this->nextUserService->getNextUser();

		if (empty($next_user) || empty($next_user->getAddress())) {
			throw new \Exception('User does not have address.');
		}

		$address = json_decode($next_user->getAddress(), true);

		$user = $this->userSession->getUser();
		$user_id = $user->getUID();
		$name = $user->getDisplayName();

		$privateKey = RSA::createKey(2048)->withPadding(RSA::ENCRYPTION_OAEP);
		$publicKey = $privateKey->getPublicKey();

		$letspeppol_identity = $this->api->register(
			$name,
			PostalAddress::streetFromAddress($address),
			$address['city'],
			$address['state'],
			$address['country']['code'],
			$address['post_code'],
			$this->urlGenerator->linkToRouteAbsolute(Application::APP_ID.'.message_api.as4Endpoint'),
			$publicKey->__toString()
		);

		$subject = new X509();
		$subject->setPublicKey($publicKey);
		$subject->setDN("/CN=$name");

		$issuer = new X509();
		$issuer->setPrivateKey($privateKey);
		$issuer->setDN("/CN=$name");

		$x509 = new X509();
		$result = $x509->sign($issuer, $subject); 
		$certificate = $x509->saveX509($result);

		$keystore_password = $user_id;
		$keystore_content = null;

		if (!openssl_pkcs12_export($certificate, $keystore_content, $privateKey->__toString(), $keystore_password)) {
			throw new Exception("Error Processing Request", 1);
		}

		$this->folderManager->createFile(self::KEYSTORE_FILE, $keystore_content);
		
		$identity = new PeppolIdentity();
		$identity->setUserId($user_id);
		$identity->setScheme('');
		$identity->setPeppolId('');
		$identity->setData($letspeppol_identity['id']);
		$this->peppolIdentityMapper->insert($identity);

		return $identity;
	}

}
