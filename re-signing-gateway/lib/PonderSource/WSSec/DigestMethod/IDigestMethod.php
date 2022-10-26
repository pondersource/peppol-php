<?php

// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

namespace OCA\PeppolNext\PonderSource\WSSec\DigestMethod;

interface IDigestMethod {
    public function getUri();
    public function getDigest($value);
}