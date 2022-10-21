<?php

namespace OCA\PeppolNext\Service;


use GuzzleHttp\Client;
use OC\AppFramework\Http;
use OCP\Files\Node;
use OCP\Lock\ILockingProvider;


class UploadService {

	public function __construct(){
	}

	public function upload(string $url, Node $folder, string $fileName) :bool{
		try {

			/** @var Node $o */
			$body = $folder->get($fileName)->getContent();
			$client = new Client(
				[
					'base_url' => $url,
					'timeout' => 10.0
				]
			);
			$res = $client->post( $url, ['multipart' => [
				[
					'name'     => 'file',
					'contents' => \Safe\fopen('data://text/plain,'.$body, 'r'),
					'filename' => $fileName
				]]]
			);

			return $res->getStatusCode() == Http::STATUS_OK;
		}
		catch (\Throwable $ex)
		{
			return false;
		}
	}
}
