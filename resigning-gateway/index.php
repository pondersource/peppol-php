<?php

require_once("./lib/PonderSource/AS4.php");

// echo "Hi";
$as4 = new \OCA\PeppolNext\PonderSource\AS4();
$response = $as4->handleAs4(apache_request_headers(), file_get_contents('php://input'));
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=3600;includeSubDomains');
header('Cache-Control: no-cache, no-store, must-revalidate, proxy-revalidate');
header('Content-Type: application/soap+xml;charset=utf-8');
header('Content-Disposition:');
echo $response;
