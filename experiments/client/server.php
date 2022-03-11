<?php

require __DIR__ . '/vendor/autoload.php';

use PonderSource\Peppol\PeppolServer;

$server = new PeppolServer();
$server->parseIncomingMessage();

