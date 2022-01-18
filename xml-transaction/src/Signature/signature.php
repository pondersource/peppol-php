<?php
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

require __DIR__ . '/../vendor/autoload.php';

class Signature{

	private $private_key;
	private $public_key;

	public function __construct(){
		$this->GenerateKeyPair(OPENSSL_KEYTYPE_RSA);
	}

	public function GenerateKeyPair($private_key_type){
		// Generate a new private (public key is included) key pair
		$new_key_pair = openssl_pkey_new(array(
		    "private_key_bits" => 2048,
		    "private_key_type" => $private_key_type,
		));
		openssl_pkey_export($new_key_pair, $private_key);
		// Obtain the public key from the private key
		$public_key = openssl_pkey_get_details($new_key_pair)['key'];
		$this->setPrivateKey($private_key);
		$this->setPublicKey($public_key);
		// Save the public key in public.pem file
		file_put_contents('public_key.pem', $public_key);
	}

	public function addSignatures($xml, $referenceTransformMap) {
		$objDSig = new XMLSecurityDSig();
		$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
		foreach($references as $ref => $transforms){
			$objDSig->addReference(
				$ref,
				XMLSecurityDSig::SHA256,
				$transforms,
			);
		}
		$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));

		// Load the private key
		$objKey->loadKey($this->private_key);
		// Sign the XML file
		$objDSig->sign($objKey);

		// Add the associated public key to the signature
		$objDSig->add509Cert(file_get_contents('public_key.pem'));
		//$objDSig->add509Cert($this->public_key,FALSE);

		// Append the signature to the XML
		$objDSig->appendSignature($xml->documentElement);
		// Save the signed XML
		return $xml;
	}

	public function createSignedXml($doc){
		// Create a new Security object
		$objDSig = new XMLSecurityDSig();
		// Use the c14n exclusive canonicalization
		$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
		// Sign using SHA-256
		$objDSig->addReference(
		    $doc,
		    XMLSecurityDSig::SHA256,
		    array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
		);

		// Create a new (private) Security key
		$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));

		// Load the private key
		$objKey->loadKey($this->private_key);
		// Sign the XML file
		$objDSig->sign($objKey);

		// Add the associated public key to the signature
		$objDSig->add509Cert(file_get_contents('public_key.pem'));
		//$objDSig->add509Cert($this->public_key,FALSE);

		// Append the signature to the XML
		$objDSig->appendSignature($doc->documentElement);
		// Save the signed XML
		return $doc;
		//$doc->save($outputfile);
	}
	private function setPrivateKey($private_key){
		$this->private_key = $private_key;
		return $this;
	}
	private function setPublicKey($public_key){
		$this->public_key = $public_key;
		return $this;
	}

	public function getPrivateKey(){
		return $this->private_key;
	}
	public function getPublicKey(){
		return $this->public_key;
	}
}
?>
