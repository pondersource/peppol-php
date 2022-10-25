// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php

namespace OCA\PeppolNext;

use phpseclib3\Crypt\RSA;
use OCA\PeppolNext\EnvelopeReader;

class PayloadReader {

	static function readPayload($raw_envelope, $raw_payload, $certificate, $private_key) {
		$envelope = EnvelopeReader::readEnvelope($raw_envelope);
		$decrypted_payload = $envelope->getHeader()->decodePayload($raw_payload, $private_key);
		
		$serializer = \JMS\Serializer\SerializerBuilder::create()->build();
		$sbd = $serializer->deserialize($decrypted_payload,'OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocument::class', 'xml');
		$invoice = $sbd->getInvoice();

		return [$envelope, $invoice, $decrypted_payload];
	}

	static function readPayloadWithKeystore($raw_envelope, $raw_payload, $keystore_file, $passphrase) {
		if (!$cert_store = file_get_contents($keystore_file)) {
			echo "Error: Unable to read the cert file\n";
			exit;
		}
		
		if (openssl_pkcs12_read($cert_store, $cert_info, $passphrase)) {
		} else {
			echo "Error: Unable to read the cert store.\n";
			exit;
		}
		
		$cert = openssl_x509_parse($cert_info['cert']);
		
		$private_key = RSA::loadPrivateKey($cert_info['pkey']);

		return PayloadReader::readPayload($raw_envelope, $raw_payload, $cert, $private_key);
	}

	static function readPayloadFromFiles($envelope_file, $payload_file, $keystore_file, $passphrase) {
		$raw_envelope = file_get_contents($envelope_file);
		$raw_payload = file_get_contents($payload_file);
		return PayloadReader::readPayloadWithKeystore($raw_envelope, $raw_payload, $keystore_file, $passphrase);
	}

}