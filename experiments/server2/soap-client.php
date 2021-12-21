<?php

echo 'Create and Consume SOAP Service using PHP';
echo nl2br("\n\n");

//$client = new SoapClient( 'http://localhost:8000/ctof.wsdl' );

try {
	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);

    $wsdlUrl = 'http://localhost/server2/ctof.wsdl';
    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE,
		'trace' => true, 
		'keep_alive' => true,
		'connection_timeout' => 5000,
		//'cache_wsdl' => WSDL_CACHE_NONE,
		'compression'   => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
    );
	$client = new SoapClient($wsdlUrl, $soapClientOptions);
	$response = $client->celsiusToFahrenheit( 36 );
	echo 'Celsius to Fahrenheit: ' . $response;
} catch ( SoapFault $sf ) {
	//echo $sf;
	echo 'Error:: ' . $sf->getMessage();
}

?>