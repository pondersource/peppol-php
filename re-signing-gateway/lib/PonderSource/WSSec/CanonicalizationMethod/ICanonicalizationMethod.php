<?php

namespace OCA\PeppolNext\PonderSource\WSSec\CanonicalizationMethod;

interface ICanonicalizationMethod {
    public function getAlgorithmUri();
    public function getChildElements();
    public function applyAlgorithm($value);
}