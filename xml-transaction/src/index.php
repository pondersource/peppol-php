<?php

use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

require __DIR__ . '/../vendor/autoload.php';
require 'Signature/signature.php';

$dom = new \DOMDocument;
$XMLString = file_get_contents('EN16931Test.xml');
$dom->loadXML($XMLString);
$sign = new Signature;
$sign->GenerateKeyPair(OPENSSL_KEYTYPE_RSA);
$sign->createSignedXml($dom,'signed_EN16931Test.xml');
?>
