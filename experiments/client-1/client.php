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
// model
class Book
{
        public $name;
        public $year;
}

// create instance and set a book name
$book      =new Book();
$book->name='test 2';

// initialize SOAP client and call web service function
$client=new SoapClient('test.wsdl');

$resp  =$client->bookYear($book);

// dump response
var_dump($resp);
