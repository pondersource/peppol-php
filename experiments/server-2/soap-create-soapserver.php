<?php

ini_set('soap.wsdl_cache_enabled', '0');

function celsiusToFahrenheit($celsius) {
	$fahrenheit = $celsius * 9 / 5 + 32;

	return $fahrenheit;
}

// initialize SOAP Server
$server = new SoapServer('ctof.wsdl');

// register available function
$server->addFunction('celsiusToFahrenheit');

// start handling requests
$server->handle();

?>