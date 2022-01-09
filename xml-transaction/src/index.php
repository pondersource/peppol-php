<?php

use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

require __DIR__ . '/../vendor/autoload.php';
require 'Signature/signature.php';

$sign = new Signature;
$sign->GenerateKeyPair();
$sign->createSignedXml('test.xml','signed.xml');
?>
