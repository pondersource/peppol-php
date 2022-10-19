<?php

namespace OCA\PeppolNext\PonderSource\WSSec\DigestMethod;

interface IDigestMethod {
    public function getUri();
    public function getDigest($value);
}