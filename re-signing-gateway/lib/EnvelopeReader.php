// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php

namespace OCA\PeppolNext;

class EnvelopeReader {

	static function readEnvelope($raw_envelope) {
		$serializer = \JMS\Serializer\SerializerBuilder::create()->build();
		$obj = $serializer->deserialize($raw_envelope,'OCA\PeppolNext\PonderSource\Envelope\Envelope::class', 'xml');
		
		return $obj;
	}

	static function readEnvelopeFromFile($envelope_file) {
		return EnvelopeReader::readEnvelope(file_get_contents($envelope_file));
	}

}