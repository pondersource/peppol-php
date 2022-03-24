<?php

namespace PonderSource\Peppol;

use PonderSource\Peppol\{MIME,SOAP,WSSE,EBMS,PayloadInfo};
use PonderSource\Peppol\Utils\GUID;

class PeppolClient {
    private $payload;
    private $soap;
    private $ebms;
    private $mime;
    private $security;
    private $messageId;

    public function __construct(){
        $this->soap = new SOAP();
        $this->ebms = new EBMS();
        $this->mime = new MIME();
        $this->security = new WSSE();
        $this->payload = new SBD();
        return $this;
    }

    public function abc(){}

    public function send($uri, $mime, $messageId=null, $date=null){
        if ($date === null) {
            $date = (new \DateTime())->format('D, d M Y H:i:s O (T)');
        }
        if ($messageId === null) {
            $messageId = uniqid('<', true) . '@' . gethostname() ? gethostname() : 'pondersourcePeppol' . '>';
        }
        $request = new Request(
            'POST',
            $uri,
            [
                'Message-Id' => $messageId,
                'Date' => $date,
                'MIME-Version' => $mime->getVersion(),
                'Content-Type' => 'multipart/related;   boundary="' . $mime->getBoundary() . '";    type="application/soap+xml";   charset=UTF-8'
            ],
            $mime->getMessage()
        );
        try {
            $client = new Client(['base_uri' => $uri]);
            $response = $client->send($request);
            $xmlstring = $response->getBody();
            return $xmlstring;
        } catch(Exception $e) {
            error_log($e);
        }
    }
}