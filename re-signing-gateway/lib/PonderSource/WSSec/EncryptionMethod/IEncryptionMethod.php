// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php

namespace OCA\PeppolNext\PonderSource\WSSec\EncryptionMethod;

interface IEncryptionMethod {
    public function getUri();
    public function encrypt(string $data, $key);
    public function decrypt(string $data, $key);
}