<?php

namespace OCA\PeppolNext\PonderSource\WSSec\EncryptionMethod;

interface IEncryptionMethod {
    public function getUri();
    public function encrypt(string $data, $key);
    public function decrypt(string $data, $key);
}