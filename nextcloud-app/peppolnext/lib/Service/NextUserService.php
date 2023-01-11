<?php

namespace OCA\PeppolNext\Service;

use Exception;

use OCP\IUserSession;

use OCA\PeppolNext\AppInfo\Application;
use OCA\PeppolNext\Db\NextUserMapper;
use OCA\PeppolNext\Db\NextUser;

class NextUserService {

	/** @var IUserSession */
    private $userSession;

	/** @var NextUserMapper */
	private $nextUserMapper;

	public function __construct(IUserSession $userSession
		, NextUserMapper $nextUserMapper) {
		$this->userSession = $userSession;
		$this->nextUserMapper = $nextUserMapper;
	}

	public function getNextUser(): ?NextUser {
		$user = $this->userSession->getUser();
		$user_id = $user->getUID();

		try {
			return $this->nextUserMapper->get($user_id);
		} catch(Exception $e) {
			return null;
		}
	}

	public function updateNextUser(NextUser $nextUser): NextUser {
		return $this->nextUserMapper->insertOrUpdate($nextUser);
	}

}
