<?php
include('./vendor/autoload.php');

use GuzzleHttp\Client;

$invoice = file_get_contents('./base-example.xml');
$soapHeader = file_get_contents('./soapHeader.xml');
$mimeBoundary = "----=PeppolPhpSoapBoundary";
$cipher = "aes-128-gcm";
$key = 'peppol'; //?
$tag = 'peppoltag123456789'; //?

$client = new Client([
	'base_uri' => 'http://localhost:8080/as4',
	'headers' => [
		'MIME-Version' => '1.0',
		'Content-Type' => "multipart/related; boundary='$mimeBoundary'; type='application/soap+xml'; charset=UTF-8"
	]]);

function mimePart($boundary, $headers, $content){
	$res = $boundary . "\n";
	foreach($headers as $key => $value){
		$res = $res . $key . ': ' . $value . "\n";
	}
	$res = $res . $content;
}

function preparePayload($content) {
	$cipher = "aes-128-gcm";
	$key = "peppol";
	$tag = "peppoltag";
	$zip = gzcompress($content);
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
	return openssl_encrypt($zip,$cipher,$key,0,$iv,$tag);
	return '';
}

$requestString = mimePart($mimeBoundary, 
						  ['Content-Type' => 'application/soap+xml;charset=UTF-8', 
						   'Content-Transfer-Encoding' => 'binary'], 
						   $soapHeader) .
				 mimePart($mimeBoundary, 
				 		  ['Content-Type' => 'application/octet-stream',
						   'Content-Transfer-Encoding' => 'binary', 
						   'Content-Description' => 'Attachment', 
						   'Content-ID' => '<phase4-att-7abd0eda-6da5-477f-b43c-ba90ea347169@cid>'], 
						   preparePayload($invoice));

$r = $client->request('POST','http://localhost:8080/as4',['body' => $requestString]);
echo json_encode($r);