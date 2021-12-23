<?php

class Invoice {
    public $customazionID;
    public $profileID;
    public $ID;
}
$invoice  = new Invoice();
$invoice->customazionID = 'urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0'; 
$invoice->profileID = 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0';
$invoice->ID = '33445566';
$client = new SoapClient(null, array(
      'location' => "http://localhost:8081/server.php",
      'uri'      => "http://localhost:8081/server.php",
      'trace'    => 1 ));

$return = $client->__soapCall("invoice",array($invoice));
var_dump($return);
?>