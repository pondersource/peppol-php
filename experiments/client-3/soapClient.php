<?php
$example = file_get_contents('./base-example.xml');

file_exists('./config.php') && include('./config.php');

$serverUrl?:$serverUrl='http://localhost:8080';

$client = new SoapClient(null, array(
	'location' => $serverUrl,
	'uri' => $serverUrl,
	'trace' => 1));
$return = $client->__soapCall("invoice",[$example]);
echo $return;
?>
