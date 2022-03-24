<?php

namespace PonderSource\Peppol;

use PonderSource\Peppol\{MIME,SOAP,WSSE,EBMS,PayloadInfo,Namespaces};
use PonderSource\Peppol\Utils\GUID;

class PeppolServer {
    private $mimeBoundary;
    private $binarySecurityTokens;
    private $encryptedKey;
    private $encryptedData;
    private $signature;
    private $attachments;
    private $soapMessage;

    public $knownHeaders = [
        'Content-Type',
        'Content-Transfer-Encoding',
        'Content-Description',
        'Content-ID'
    ];

    function parseIncomingMessage() {
        $rawInput = file_get_contents('php://input');
        $this->mimeBoundary = explode('"', explode('boundary=', $_SERVER['CONTENT_TYPE'])[1])[1];
        $this->attachments = array_filter(explode($this->mimeBoundary, $rawInput), function($m) {
            return trim($m) !== '--';
        });
        foreach($this->attachments as $attachment){
            $this->parseAttachment($attachment);
        }
        $this->decryptData();
    }

    function parseAttachment($a) {
        //parse headers
        $headers = [];
        $n = 0;
        $rest = [];
        $lines = explode("\n", $a);
        while(isset($lines[$n])){
            if($this->isHeader($lines[$n])){
                $pos = strpos($lines[$n], ':');
                $key = substr($lines[$n], 0, $pos);
                $value = substr($lines[$n], $pos+1);
                if(!isset($headers[$key])){
                    $headers[$key] = \trim($value);
                }
            } else if(isset($headers['Content-Type']) && \trim($lines[$n] !== '--' && \trim($lines[$n] !== ''))){
                array_push($rest, $lines[$n]);
            }
            $n++;
        }
        $rest = implode("\n", $rest);
        //soap message
        if($this->str_starts_with($headers['Content-Type'], "application/soap+xml")){
            $dom = \DOMDocument::loadXML(\trim($rest));
            $this->parseSoapMessage($dom);
        } else { //attachment TODO
            if($headers['Content-Description'] === 'Attachment'){
                if($headers['Content-ID'] === '<' . $this->encryptedData['DataReference'] . '>'){
                    $this->encryptedData['Data'] = $rest;
                }
            }
        }
    }

    function isHeader($line){
        foreach($this->knownHeaders as $knownHeader) {
            if($this->str_starts_with(\trim($line), $knownHeader)){
                return true;
            }
        }
        return false;
    }

    function str_starts_with($haystack, $needle) {
        $l = \strlen($needle);
        return substr($haystack, 0, $l) === $needle;
    }
    
    function parseSoapMessage($xml){
        foreach($xml->childNodes as $node){
            switch($node->localName){
                case 'Envelope':
                case 'Header':
                case 'Body':
                case 'Messaging':
                case 'UserMessage':
                    $this->parseSoapMessage($node);
                    break;
                case 'MessageInfo':
                    $messageInfo = $node->nodeValue;
                    break;
                case 'PartyInfo':
                    $partyInfo = $node->nodeValue;
                    break;
                case 'CollaborationInfo':
                    $collaborationInfo = $node->nodeValue;
                    break;
                case 'MessageProperties':
                    $messageProps = $node->nodeValue;
                    break;
                case 'PayloadInfo':
                    $payloadInfo = $node->nodeValue;
                    break;
                case 'Security':
                    $this->parseWSSE($node);
                    break;
                default:
                    print($node->localName);
            }
        }
    }
    function parseWSSE($xml){
        foreach($xml->childNodes as $node){
            switch($node->localName){
                case 'BinarySecurityToken':
                    $this->binarySecurityTokens[$node->attributes->getNamedItemNS(Namespaces::WSU, "Id")->nodeValue] = $node->nodeValue;
                    break;
                case 'EncryptedKey':
                    $this->parseKey($node);
                    break;
                case 'EncryptedData':
                    $this->parseEncryptedData($node);
                    break;
                case 'Signature':

                    break;
                default:
                    print($node->localName);
            }
        }
    }
    function parseEncryptedData($node){
        foreach($node->childNodes as $n){
            switch($n->localName){
                case 'EncryptionMethod':
                    $this->encryptedData['Method'] = $n->attributes->getNamedItem('Algorithm')->nodeValue;
                    break;
                case 'KeyInfo':
                    foreach($n->childNodes as $ref){
                        switch($ref->localName){
                            case 'SecurityTokenReference':
                                foreach($ref->childNodes as $r){
                                    switch($r->localName){
                                        case 'Reference':
                                            $this->encryptedData['TokenReference'] = $r->attributes->getNamedItem('URI')->nodeValue;
                                        default:
                                            break;
                                    }
                                }
                            default:
                                break;
                        }
                    }
                    break;
                case 'CipherData':
                    foreach($n->childNodes as $ref){
                        switch($ref->localName){
                            case 'CipherReference':
                                $this->encryptedData['DataReference'] = $ref->attributes->getNamedItem('URI')->nodeValue;
                        }
                    }
            }
        }
    }
    function parseKey($xml){
        $key = [];
        $key['Id'] = $xml->attributes->getNamedItem('Id')->nodeValue;
        foreach($xml->childNodes as $node){
            switch($node->localName){
                case 'EncryptionMethod':
                    $method['Algorithm'] = $node->attributes->getNamedItem('Algorithm')->nodeValue;
                    foreach($node->childNodes as $n){
                        switch($n->localName){
                            case 'DigestMethod':
                                $method['Digest'] = $n->attributes->getNamedItem('Algorithm')->nodeValue;
                                break;
                            case 'MGF':
                                $method['MGF'] = $n->attributes->getNamedItem('Algorithm')->nodeValue;
                                break;
                            default:
                                break;
                        }
                    }
                    $key['Method'] = $method;
                    break;
                case 'KeyInfo':
                    foreach($node->childNodes as $n) {
                        switch($n->localName){
                            case 'SecurityTokenRefernce':
                                foreach($n->childNodes as $ref){
                                    switch($ref->localName){
                                        case 'Reference':
                                            $key['Reference'] = $ref->attributes->getNamedItem('URI')->nodeValue;
                                        default:
                                            break;
                                    }
                                }
                            default:
                                break;
                        }
                    }
                    break;
                case 'CipherData':
                    foreach($node->childNodes as $n){
                        switch($n->localName){
                            case 'CipherValue':
                                $key['Value'] = $n->nodeValue;
                            default:
                                break;
                        }
                    }
                    break;
                case 'ReferenceList':
                    foreach($node->childNodes as $n) {
                        switch($n->localName){
                            case 'DataReference':
                                $key['DataReferece'] = $n->attributes->getNamedItem('URI')->nodeValue;
                            default:
                                break;
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        $this->encryptedKey = $key;
    }
    function decryptData(){
        $privateKey = \file_get_contents('keys/private.key');
        $privateKey = \openssl_pkey_get_private($privateKey);
        $iv = file_get_contents('/home/eru/development/pondersource/peppol-php/experiments/client/.iv');
        $success = openssl_open($this->encryptedData['Data'], $decryptedData, $this->encryptedKey['Value'],$privateKey,'aes-128-gcm',$iv);
        var_dump($success, $this->encryptedData, $this->encryptedKey, $privateKey, $iv);
    }

    function initialSetup($key=null, $ca=null){
        if(\file_exists('keys/private.key') && \file_exists('keys/public.pem')){
            $privateKey = \file_get_contents('keys/private.key');
            $privateKey = \openssl_pkey_get_private($privateKey);
            $publicKey = \file_get_contents('keys/public.pem');
            $publicKey = \openssl_x509_read($publicKey);
            return ($publicKey && $privateKey);
        }
        if($key===null){
            $privateKey = \openssl_pkey_new(
                [
                    'digest_alg' => 'sha256',
                    'private_key_bits' => 2048,
                    'private_key_type' => OPENSSL_KEYTYPE_RSA,
                ]
            );
            $success = \openssl_pkey_export_to_file($privateKey, 'keys/private.key');
            $csr = \openssl_csr_new([], $privateKey);
            $cert = \openssl_csr_sign($csr,$ca,$privateKey,90);
            $success &= \openssl_x509_export_to_file($cert, 'keys/public.pem');
            /*
            $publicKey = \openssl_pkey_get_details($privateKey);
            $success &= \file_put_contents('keys/public.key', $publicKey['key']);
            */
            \openssl_free_key($privateKey);
            return ($success);
        } else {
            $success = \openssl_pkey_export_to_file($key, 'keys/private.key');
            $csr = \openssl_csr_new([],$key);
            $cert = \openssl_csr_sign($csr,$ca,$privateKey,90);
            $success &= \openssl_x509_export_to_file($cert, 'keys/public.pem');
            /*
            $publicKey = \openssl_pkey_get_details($privateKey);
            $success &= \file_put_contents('keys/public.key', $publicKey['key']);
            */
            \openssl_free_key($key);
            return ($success);
        }
    }
}