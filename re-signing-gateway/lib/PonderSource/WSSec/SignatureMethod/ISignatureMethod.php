<?php

// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

namespace OCA\PeppolNext\PonderSource\WSSec\SignatureMethod;

use JMS\Serializer\Annotation\{XmlAttribute,Type,SerializedName,XmlNamespace};

/**
 * @XmlNamespace("http://www.w3.org/2000/09/xmldsig#")
 */
interface ISignatureMethod {
    public function getUri();
    public function sign($pkey, $value);
}