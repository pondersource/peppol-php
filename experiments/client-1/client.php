<?php

class Invoice {
    public $issueDate;
    public $dueDate;
    public $documentCurrencyCode;
}
$invoice  = new Invoice();
$invoice->issueDate = '2021-12-22';
$invoice->dueDate = '2021-12-22';
$invoice->documentCurrencyCode = 'EUR';
$client = new SoapClient(null, array(
      'location' => "http://localhost:8081/server.php",
      'uri'      => "http://localhost:8081/server.php",
      'trace'    => 1 ));

$return = $client->__soapCall("invoice",array($invoice));
var_dump($return);
?>
