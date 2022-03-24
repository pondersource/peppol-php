<?php
namespace PonderSource\Peppol;

use PonderSource\Peppol\Utils\GUID;
use Sabre\Xml\Writer;
use Sabre\XML\XmlSerializable;
class WSSE implements XmlSerializable {

	const WSSE = '{http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd}';
	const WSU = '{http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd}';
    const XENC = '{http://www.w3.org/2001/04/xmlenc#}';
    const DS = '{http://www.w3.org/2000/09/xmldsig#}';
    const XENC11 = '{http://www.w3.org/2009/xmlenc11#}';
    const WSSE11 = '{http://docs.oasis-open.org/wss/oasis-wss-wssecurity-secext-1.1.xsd}';
    const EC = '{http://www.w3.org/2001/10/xml-exc-c14n#}';

    private $encryptionSecurityToken;
    private $encryptionSecurityTokenId;
    private $encryptedKeyId;
    private $cipherValue;
    private $encryptedDataId;
    private $signature;
    private $signatureId;
    private $signatureKeyInfoId;
    private $signatureTokenId;
    private $signatureKey;
    private $signatureKeyId;
    private $digests = [];
    private $cipherValues = [];
    private $cipherReferences = [];
    private $myKey;

    public function __construct($myKey, $encryptedKeys, $targetCertificate, $attachments=[]){
        $this->encryptionSecurityTokenId = 'G' . GUID::getNew();
        $this->encryptedKeyId = 'EK-' . GUID::getNew();
        $this->encryptedDataId = 'ED-' . GUID::getNew();
        $this->signatureId = 'SIG-' . GUID::getNew();
        $this->signatureKeyInfoId = 'KI-' . GUID::getNew();
        $this->signatureTokenId = 'STR-' . GUID::getNew();
        $this->signatureKeyId = 'X509-' . GUID::getNew();
		openssl_x509_export($targetCertificate, $targetCertificateString);
		$targetCertificateString = $this->stripCertificateString($targetCertificateString);
		$this->encryptionSecurityToken = $targetCertificateString;
        $this->myKey = $myKey;
		$this->cipherValue = base64_encode($encryptedKeys[0]);
        $this->signatureKey = openssl_pkey_get_details($myKey)['key'];
        $this->digests = [['name' => $this::DS . 'CanonicalizationMethod',
                           'attributes' => ['Algorithm' => 'http://www.w3.org/2001/10/xml-exc-c14n#'],
                           'value' => ['name' => $this::EC . 'InclusiveNamespaces',
                                       'attributes' => ['PrefixList' => 'S12']]],
                          ['name' => $this::DS . 'SignatureMethod',
                           'attributes' => ['Algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256']]];
        foreach($attachments as $attachment) {
            $this->addAttachmentReference($attachment);
        }
        $this->generateSignature();
    }
    public function xmlSerialize(Writer $writer){
        $writer->write(
            [
            [
            'name' => $this::WSSE . 'Security',
            'attributes' => [
                'S12:mustUnderstand' => 'true'
            ],
            'value' => [
                [
                    'name' => $this::WSSE . 'BinarySecurityToken',
                    'attributes' => [
                        'EncodingType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary',
                        'ValueType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#x509v3',
                        $this::WSU . 'Id' => $this->encryptionSecurityTokenId,
                    ],
                    'value' => $this->encryptionSecurityToken
                ],
                [
                    'name' => $this::XENC . 'EncryptedKey',
                    'attributes' => [
                        'Id' => $this->encryptedKeyId
                    ],
                    'value' => [
                        [
                            'name' => $this::XENC . 'EncryptionMethod',
                            'attributes' => [
                                'Algorithm' => 'http://www.w3.org/2009/xmlenc11#rsa-oaep',
                            ],
                            'value' => [
                                [
                                    'name' => $this::DS . 'DigestMethod',
                                    'attributes' => [
                                        'Algorithm' => 'http://www.w3.org/2001/04/xmlenc#sha256',
                                    ],
                                ],
                                [
                                    'name' => $this::XENC11 . 'MGF',
                                    'attributes' => [
                                        'Algorithm' => 'http://www.w3.org/2009/xmlenc11#mgf1sha256'
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => $this::DS . 'KeyInfo',
                            'value' => [
                                'name' => $this::WSSE . 'SecurityTokenReference',
                                'value' => [
                                    'name' => $this::WSSE . 'Reference',
                                    'attributes' => [
                                        'URI' => '#' . $this->encryptionSecurityTokenId,
                                        'ValueType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => $this::XENC . 'CipherData',
                            'value' => [
                                'name' => $this::XENC . 'CipherValue',
                                'value' => $this->cipherValue,
                            ],
                        ],
                        [
                            'name' => $this::XENC . 'ReferenceList',
                            'value' => [
                                'name' => $this::XENC . 'DataReference',
                                'attributes' => [
                                    'URI' => '#' . $this->encryptedDataId,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => $this::XENC . 'EncryptedData',
                    'attributes' => [
                        'Id' => $this->encryptedDataId,
                        'MimeType' => 'application/gzip',
                        'Type' => 'http://docs.oasis-open.org/wss/oasis-wss/SwAProfile-1.1#Attachment-Content-Only',
                    ],
                    'value' => [
                        [
                            'name' => $this::XENC . 'EncryptionMethod',
                            'attributes' => [
                                'Algorithm' => 'http://www.w3.org/2009/xmlenc11#aes128-gcm',
                            ],
                        ],
                        [
                            'name' => $this::DS . 'KeyInfo',
                            'value' => [
                                'name' => $this::WSSE . 'SecurityTokenReference',
                                'attributes' => [
                                    $this::WSSE11 . 'TokenType' => 'http://docs.oasis-open.org/wss/oasis-wss-soap-message-security-1.1#EncryptedKey',
                                ],
                                'value' => [
                                    'name' => $this::WSSE . 'Reference',
                                    'attributes' => [
                                        'URI' => '#' . $this->encryptedKeyId,
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => $this::XENC . 'CipherData',
                            'value' => [
                                $this->cipherReferences,
                            ],
                        ],
                    ],
                ],
                [
                    'name' => $this::WSSE . 'BinarySecurityToken',
                    'attributes' => [
                        'EncodingType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary',
                        'ValueType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3',
                        $this::WSU . 'Id' => $this->signatureKeyId,
                    ],
                    'value' => $this->stripCertificateString($this->signatureKey),
                ],
                [
                    'name' => $this::DS . 'Signature',
                    'attributes' => [
                        'Id' => $this->signatureId
                    ],
                    'value' => [
                        [
                            'name' => $this::DS . 'SignedInfo',
                            'value' => [
                                $this->digests,
                            ],
                        ],
                        [
                            'name' => $this::DS . 'SignatureValue',
                            'value' => $this->signature
                        ],
                        [
                            'name' => $this::DS . 'KeyInfo',
                            'attributes' => [
                                'Id' => $this->signatureKeyInfoId,
                            ],
                            'value' => [
                                'name' => $this::WSSE . 'SecurityTokenReference',
                                'attributes' => [
                                    $this::WSU . 'Id' => $this->signatureTokenId,
                                ],
                                'value' => [
                                    'name' => $this::WSSE . 'Reference',
                                    'attributes' => [
                                        'URI' => '#' . $this->signatureKeyId,
                                        'ValueType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3',
                                    ]]]]]]]]]);
    }
    public function addNodeReference(DOMNode $node, string $transformCallback='noopNormalize', string $digestCallback='sha256Digest'){
        $uri = '#' . $node->getAttributeNS($namespace, 'Id');
        $this->addReference($uri, $node, $transformCallback, $digestCallback);
    }
    public function addAttachmentReference($data, string $transformCallback='noopNormalize', string $digestCallback='sha256Digest'){
        $this->addReference($data['uri'], $data['data'], $transformCallback, $digestCallback);
        array_push($this->cipherReferences, [
            'name' => $this::XENC . 'CipherReference',
            'attributes' => [
                'URI' => $data['uri']
            ],
            'value' => [
                'name' => $this::XENC . 'Transforms',
                'value' => [
                    'name' => $this::DS . 'Transform',
                    'attributes' => [
                        'Algorithm' => 'http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Ciphertext-Transform'
                    ]
                ]
            ]
        ]);
    }
    public function addReference($reference, $data, $transformCallback, $digestCallback){
        $digestInfo = $this->$digestCallback($this->$transformCallback($data));
        $digest = [
            'name' => $this::DS . 'Reference',
            'attributes' => [
                'URI' => '#' . $reference,
            ],
            'value' => [
                [
                    'name' => $this::DS . 'Transforms',
                    'value' => [
                        'name' => $this::DS . 'Transform',
                        'attributes' => [
                            'Algorithm' => $digestInfo['transform'],
                        ],
                    ],
                ],
                [
                    'name' => $this::DS . 'DigestMethod',
                    'attributes' => [
                        'Algorithm' => $digestInfo['algorithm'],
                    ],
                ],
                $this::DS . 'DigestValue' => $digestInfo['value'],
            ],
        ];
        array_push($this->digests,$digest);
        $this->generateSignature();
    }
    public function c14neNormalize(DOMNode $node){
        return [
            'value' => $node->C14N($exclusive=true),
            'transform' => 'http://www.w3.org/2001/10/xml-exc-c14n#',
            ];
    }
    public function noopNormalize($data){
        return [
            'value' => $data,
            'transform' => 'http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Signature-Transform',
            ];
    }
    public function sha256Digest(array $data){
        $value = \base64_encode(\openssl_digest($data['value'], 'sha256', true));
        $transform = $data['transform'];
        $algorithm = 'http://www.w3.org/2001/04/xmlenc#sha256';
        return [
            'value' =>  $value,
            'transform' => $transform,
            'algorithm' => $algorithm,
        ];
    }
    public function serializedDigests(){
        $writer = new \Sabre\Xml\Writer();
        $writer->openMemory();
        $writer->options = LIBXML_NOBLANKS | LIBXML_COMPACT | LIBXML_NSCLEAN;
        $writer->namespaceMap = [
            'http://www.w3.org/2003/05/soap-envelope' => 'S12',
            'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd' => 'wsse',
            'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd' => 'wsu',
            'http://www.w3.org/2001/04/xmlenc#' => 'xenc',
            'http://www.w3.org/2000/09/xmldsig#' => 'ds',
            'http://www.w3.org/2009/xmlenc11#' => 'xenc11',
            'http://docs.oasis-open.org/wss/oasis-wss-wssecurity-secext-1.1.xsd' => 'wsse11',
            'http://www.w3.org/2001/10/xml-exc-c14n#' => 'ec',
            'http://schemas.xmlsoap.org/soap/envelope/' => 'S11',
            'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/' => 'eb',
            'http://docs.oasis-open.org/ebxml-bp/ebbp-signals-2.0' => 'ebbp',
            'http://www.w3.org/1999/xlink' => 'xlink',
        ];
        $writer->setIndent(false);
        $writer->writeElement($this::DS . 'SignedInfo', $this->digests);
        $str = $writer->outputMemory();
        return $str;
    }
    public function generateSignature(){
        $data = $this->serializedDigests();
        $key = $this->signatureKey;
        $binSig = '';
        openssl_sign($data, $binSig, openssl_pkey_get_private($this->myKey), OPENSSL_ALGO_SHA256);
        $this->signature = base64_encode($binSig);
    }
	public function stripCertificateString($certstring) {
		$arr = explode("\n", $certstring);
		foreach($arr as $k => $e) {
			if($e && strstr($e[0], '-')){
				$arr[$k] = '';
			}
		}
		return implode($arr);
	}
}
