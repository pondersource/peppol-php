<?php

namespace OCA\PeppolNext\Service;

use OCP\IUserSession;

class LetsPeppolService {

	/** @var IUserSession */
    private $userSession;

	public function __construct(IUserSession $userSession) {
		$this->userSession = $userSession;
	}

	public function getIdentity() {
		$user = $this->userSession->getUser();
		$email = $user->getEMailAddress();
		$name = $user->getDisplayName();

		// TODO Talk to Let's Peppol

		return [
			'scheme' => 'iso6523-actorid-upis',
			'id' => $name
		];
	}

	public function generateIdentity() {
		$user = $this->userSession->getUser();
		$email = $user->getEMailAddress();
		$name = $user->getDisplayName();

		// TODO Talk to Let's Peppol
		
		return [
			'scheme' => 'iso6523-actorid-upis',
			'id' => $name.'_new'
		];
	}

}
