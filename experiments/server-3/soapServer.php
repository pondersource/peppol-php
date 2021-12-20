<?php

class PeppolSoapServer{
	public function echo($arg){
		return $arg;
	}
	public function hello() {
		return "Hello, World!";
	}
}

$options = ['uri' => 'http://localhost:8080/'];
$server = new SoapServer(null, $options);
$server->setClass('PeppolSoapServer');
$server->handle();

?>
