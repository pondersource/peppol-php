<?php

class WSSE implements XmlSerializable {
    private $encryptionSecurityToken;
    private $encryptedKey;
    private $encryptedData;
    private $signatureSecurityToken;
    private $signature;

    public function __construct(){}
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
                            value => [
                                [
                                    'name' => $this::DS . 'DigestMethod',
                                    'attributes' => [
                                        'Algorithm' => 'http://www.w3.org/2001/04/xmlenc#sha256',
                                    ],
                                ],
                                [
                                    'name' => $this:XENC11 . 'MGF',
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
                                'value' => $this->cipherValue
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
                        'URI' => $this->encryptedDataId,
                        'MimeType' => 'application/xml',
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
                    ],
                ],
                [
                    'name' => $this::WSSE . 'BinarySecurityToken',
                    'attributes' => [
                        'EncodingType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary',
                        'ValueType' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3'
                        $this::WSU . 'Id' => $this->signatureKeyId,
                    ],
                    'value' => [
                        $this->signatureKey,
                    ],
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
                                [
                                    'name' => $this::DS . 'CanonicalizationMethod',
                                    'attributes' => [
                                        'Algorithm' => 'http://www.w3.org/2001/10/xml-exc-c14n#',
                                    ],
                                    'value' => [
                                        'name' => $this::EC . 'InclusiveNamespaces',
                                        'attributes' => [
                                            'PrefixList' => 'S12',
                                        ],
                                    ],
                                ],
                                [
                                    'name' => $this::DS . 'SignatureMethod',
                                    'attributes' => [
                                        'Algorithm' => 'http:/www.w3.org/2001/04/xmldsig-more-rsa-sha256',
                                    ],
                                ],
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
                                    ]]]]]]]]);
    }
    public function addReference(DOMNode $node, string $transformCallback='noopNormalize', string $digestCallback='sha256Digest'){
        $uri = '#' . $node->getAttributeNS($namespace, 'Id');
        $digestInfo = $digestCallback($transformCallback($node));
        $digestValue = $digestInfo['value'];
        $digestTransform = $digestInfo['transform'];
        $signature->addReference($digestValue, $digestTransform);
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
    public function sha256Digest(string $data){
        return [
            'value' => base64_encode(openssl_digest($data['value'], 'sha256', true)),
            'transform' => $data['transform'],
        ];
    }
}

