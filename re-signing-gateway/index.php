// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php
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
} else {
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Connect your Books!</title>
    <style>
      body { background-color: #A3DDDF }
      header { width: 40em; margin: 5em auto; color: white }
      article { width: 40em; margin: 5em auto; padding: 3em; border-radius: 1em; background-color: #FFE4B5 }
      article pre { background-color: grey; padding: 3em; color: yellow; border-radius: 1em; text-align: center }
      footer { width: 40em; margin: 5em auto; color: white }
    </style>
  </head>
  <body>
    <header>
      <h2>Connect your Books!</h2>
    </header>
    <article>
      <p>We at <a href="https://pondersource.com">Ponder Source</a> are working on a product that will allow bookkeeping systems to be connected
      to each other, in the vision of <a href="https://federatedbookkeeping.org">Federated Bookkeeping</a>.</p>
      <p>For this, we will combine a number of technologies:</p>
      <ul>
        <li><a href="https://peppol.eu">Peppol</a> and <a href="https://github.com/pondersource/peppol-php/blob/main/docs/ngi-assure-proposal.md">AS4+WebID</a> for e-invoicing</li>
        <li><a href="https://www.w3.org/community/timesh/">Federated Timesheets</a></li>
        <li>Integration of all the <a href="https://github.com/federatedbookkeeping/research/blob/main/api.md">proprietary billing APIs</a> we can find</li>
        <li>Integration of all the bookkeeping software platforms we can find</li>
        <li>Novel <a href="https://prejournal.org">Prejournal</a> bookkeeping techniques</li>
      </ul>
      <p>The HTML code of this website is maintained through a <a href="https://github.com/pondersource/connectyourbooks.com">GitHub repo</a>.</p>
    </article>
  </body>
</html>
<?php
}
?>
