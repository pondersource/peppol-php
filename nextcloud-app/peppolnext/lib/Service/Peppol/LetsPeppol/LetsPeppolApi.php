<?php

namespace OCA\PeppolNext\Service\Peppol\LetsPeppol;

use phpseclib3\Crypt\Common\AsymmetricKey;

class LetsPeppolApi {

    private const BASE_URL = 'https://8000-pondersource-cyb-qy9o8npphpo.ws-us90.gitpod.io/api';
    private const LETS_PEPPOL_BASE_URL = self::BASE_URL.'/connector/lets_peppol';
    private const INFO_URL = self::LETS_PEPPOL_BASE_URL.'/as4direct/info';
    private const IDENTITY_URL = self::LETS_PEPPOL_BASE_URL.'/identity';

    /**
     * returns a json with the following keys:
     * - identity_scheme
     * - identity_value
     * - certificate
     * - endpoint
     */
    public function getInfo(): array {
        $client = new \GuzzleHttp\Client();
		try {
			$response = $client->request('GET', self::INFO_URL);
		} catch (\Exception $e) {
			$message = $e->getResponse()->getBody()->getContents();
			$index = strpos($message, 'Message:');
			$message = substr($message, $index + 8);
			throw new \Exception('Failed to get info> '.$message);
		}

		$statusCode = $response->getStatusCode();
		$responseBody = $response->getBody()->getContents();

        return json_decode($responseBody, true);
    }

    /**
     * Returns identity:
     * {
     *      "id"
     *      "name"
     *      "address"
     *      "city"
     *      "region"
     *      "country"
     *      "zip"
     *      "as4direct_endpoint"
     *      "as4direct_public_key"
     *      "kyc_status"
     *      "identifier_scheme"
     *      "identifier_value"
     *      "as4direct_certificate"
     * }
     */
    public function register(string $name, string $address, string $city, string $region,
            string $country, string $zip, string $endpoint, string $public_key): array {
        $client = new \GuzzleHttp\Client();
        
		try {
			$response = $client->request('POST', self::IDENTITY_URL, [
				'json' => [
                    'name' => $name,
                    'address' => $address,
                    'city' => $city,
                    'region' => $region,
                    'country' => $country,
                    'zip' => $zip,
                    'as4direct_endpoint' => $endpoint,
                    'as4direct_public_key' => $public_key
                ]
			]);
		} catch (\Exception $e) {
			$message = $e->getResponse()->getBody()->getContents();
			$index = strpos($message, 'Message:');
			$message = substr($message, $index + 8);
			throw new \Exception('Failed to register> '.$message);
		}

		$statusCode = $response->getStatusCode();
		$responseBody = $response->getBody()->getContents();

        return json_decode($responseBody, true)['identity'];
    }

    /**
     * KYC status values:
     * 0: pendng approval
     * 1: rejected
     * 2: approved
     */
    public function getIdentity(string $id, AsymmetricKey $private_key): array {
        $client = new \GuzzleHttp\Client();

        $signature = urlencode(base64_encode($private_key->sign('I want identity id '.$id)));
        $endpoint = self::IDENTITY_URL."/$id?signature=$signature";

        try {
            $response = $client->request('GET', $endpoint);
        } catch (\Exception $e) {
            $message = $e->getResponse()->getBody()->getContents();
            $index = strpos($message, 'Message:');
            $message = substr($message, $index + 8);
            throw new \Exception('Failed to get identity> '.$message);
        }

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        return json_decode($responseBody, true);
    }

}