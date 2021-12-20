<?php

$client = new SoapClient(null, array(
	'location' => 'http://localhost:8080',
	'uri' => 'http://localhost:8080',
	'trace' => 1));
$return = $client->__soapCall("hello",[]);
echo $return;
echo "\n";
$return = $client->__soapCall("echo",['test 1, 2, 3']);
echo $return;
echo "\n";
?>
