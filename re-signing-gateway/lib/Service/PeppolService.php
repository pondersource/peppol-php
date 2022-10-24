<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\Files\IRootFolder;

class InvoiceService {

	/** @var IRootFolder*/
	private IRootFolder $rootFolder;
	public function __construct(IRootFolder $rootFolder){
		$this->rootFolder = $rootFolder;
	}

	public function Save(string $content, string $fileName): void{

	}

	public function Read(string $fileName) :void{

	}
}
