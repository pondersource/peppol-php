<?php

namespace OCA\PeppolNext\Service\Peppol;

use OCA\PeppolNext\Db\PeppolIdentity;

use OCP\IUserSession;

class LetsPeppolService implements IPeppolService {

	public const SERVICE_NAME = 'LetsPeppolService';

	/** @var IUserSession */
    private $userSession;

	public function __construct(IUserSession $userSession) {
		$this->userSession = $userSession;
	}

	public function getServiceName(): string {
		return self::SERVICE_NAME;
	}

	public function getIdentity(): ?PeppolIdentity {
		$user = $this->userSession->getUser();
		$email = $user->getEMailAddress();
		$name = $user->getDisplayName();

		// TODO Talk to Let's Peppol

		$identity = new PeppolIdentity();
		$identity->setScheme('iso6523-actorid-upis');
		$identity->setPeppolId($name);

		return $identity;
	}

	public function generateIdentity(): PeppolIdentity {
		$user = $this->userSession->getUser();
		$email = $user->getEMailAddress();
		$name = $user->getDisplayName();

		// TODO Talk to Let's Peppol
		
		$identity = new PeppolIdentity();
		$identity->setScheme('iso6523-actorid-upis');
		$identity->setPeppolId($name.'_new');

		return $identity;
	}

}
