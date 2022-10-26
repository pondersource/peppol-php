<?php

// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

require_once("./lib/PonderSource/AS4.php");
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
  error_log("Hi");
  $as4 = new \OCA\PeppolNext\PonderSource\AS4();
  $contentType = "unknown";
  $headers = apache_request_headers();
  foreach ($headers as $header => $value) {
    if (strtolower($header) == "content-type") {
      $contentType = $value;
    }
    error_log("[INCOMING HEADER] $header: $value");
  }
  error_log("[CONTENT-TYPE] $contentType");
  $body = file_get_contents('php://input');
  error_log("[REQUEST BODY LENGTH] " . strlen($body));
  $response = $as4->handleAs4($contentType, $body);
  error_log("[RESPONSE BODY LENGTH] " . strlen($response));
  header('Referrer-Policy: strict-origin-when-cross-origin');
  header('X-Frame-Options: SAMEORIGIN');
  header('X-Content-Type-Options: nosniff');
  header('X-XSS-Protection: 1; mode=block');
  header('Strict-Transport-Security: max-age=3600;includeSubDomains');
  header('Cache-Control: no-cache, no-store, must-revalidate, proxy-revalidate');
  header('Content-Type: application/soap+xml;charset=utf-8');
  header('Content-Disposition:');
  echo $response;
}