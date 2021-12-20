<?php

class PeppolSoapServer{
	public function invoice($input){
		$saxonProc = new Saxon\SaxonProcessor();
		$xslt = $saxonProc->newXsltProcessor();
		$tempfile = tempnam('.','invoice_');
		file_put_contents($tempfile, $input);
		$xslt->setSourceFromFile($tempfile);
		$xslt->compileFromFile('invoice.xslt');
		$html = $xslt->transformToString();
		unlink($tempfile);
		return $html;
	}
}

$options = ['uri' => 'http://localhost:8000/'];
$server = new SoapServer(null, $options);
$server->setClass('PeppolSoapServer');
$server->handle();

?>
