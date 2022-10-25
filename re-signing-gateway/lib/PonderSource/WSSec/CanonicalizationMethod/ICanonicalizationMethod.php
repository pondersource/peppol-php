<?php

// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

namespace OCA\PeppolNext\PonderSource\WSSec\CanonicalizationMethod;

interface ICanonicalizationMethod {
    public function getAlgorithmUri();
    public function getChildElements();
    public function applyAlgorithm($value);
}