<?php
/**
 * this does not work, it's just some mockup pseudo-php to sort of document how i imagine this might be implemented,
 * hopefully some libraries will actually keep me from doing all this by hand...
 */

function preparePayload($data, $key) {
    $cipher = "aes-128-gcm";
    if(in_array($cipher, openssl_get_cipher_methods())){
        $ivlen = openssl_get_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return openssl_encrypt(gzcompress($data),"aes-128-gcm",$key,$options=0,$iv,$tag);
    }
    return false;
}

class MIMEMessage{
    private $version;
    private $contentType;
    private $encoding;
    private $boundary;
    private $parts;
}
class MIMEPart{
    private $contentType;
    private $charset;
    private $contentTransferEncoding;
    private $contentId;
    private $contentDescription;
    private $content;
}
class WSHeader{
}
class SOAPMessage{
}

$msg = new MIMEMessage();
$domdocument = new DOMDocument($version="1.0",$encoding="utf-8");
$wsse = new WSHeader(PKCS12);
$soapMessage = new SOAPMessage();
$soapMessage->additionalHeaders($wsse);
$soapMessage->prepareSoapHeader();
$header = new MIMEPart();
$payload = new MIMEPart();
$payload->setContentType("application/octet-stream")
        ->setContentTransferEncoding("binary")
        ->setContentDescription("Attachment")
        ->setContentId("payload.xml")
        ->setContent(preparePayload($data, PKCS12));
$header->setContentType("application/soap+xml")
       ->setCharset("utf-8")
       ->setContentTransferEncoding("binary")
       ->setContent($domdocument)
       ->addAttachment($payload);
$msg->addPart($header);
$msg->addPart($payload);