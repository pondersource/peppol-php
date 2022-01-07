## XML transaction based on Peppol standars.

The XMl Transaction includes:

* Signature
* Encryption
* Decryption
* Validation

Signature, Encryption -> both use the `KeyInfo` element(Optional)

About `KeyInfo`

* What keying material to use to validate a signature or decrypt encrypted data.
* It can be attached in the message, or be delivered through a secure channel.

### Signature

The XML Signature defines:

* [digital signature processing rules](https://www.w3.org/TR/xmldsig-core1/#sec-Processing)
* [digital signature processing syntax](https://www.w3.org/TR/xmldsig-core1/#sec-CoreSyntax)

XML Signatures provide integrity, message authentication, and/or signer authentication services for data of any type, whether located within the XML that includes the signature or elsewhere.

```
<Signature>
  <SignedInfo>
    <CanonicalizationMethod />
    <SignatureMethod />
    <Reference>
       <Transforms />
       <DigestMethod />
       <DigestValue />
    </Reference>
    <Reference /> etc.
  </SignedInfo>
  <SignatureValue />
  <KeyInfo />
  <Object />
</Signature>
```

Read more about XML Signatures here.

#### How to validate an XML Signature ❓

**Core Validation**:

Steps to validate an XML Signature

1. [Reference Validation](https://www.w3.org/TR/xmldsig-core1/#sec-ReferenceValidation): Verification of the digest contained in each Reference in `SignedInfo`

2. [Signature Validation](https://www.w3.org/TR/xmldsig-core1/#sec-SignatureValidation): Cryptographic verification of the signature, calculated over `SignedInfo`)

### Encryption

XML Encryption specifies a process for encrypting data and representing the result in XML.

The data may be arbitrary data (including an XML document), an XML element, or XML element content. The result of encrypting data is an XML Encryption element which contains or references the cipher data.

XML Encryption != [TLS](https://en.wikipedia.org/wiki/Transport_Layer_Security)

```
<EncryptedData Id='ed1'
  Type='...'
  xmlns='...'>
  <EncryptionMethod
    Algorithm='...'/>
  <KeyInfo xmlns=''>
    <KeyName>...</KeyName>
  </KeyInfo>
  <CipherData>
    <CipherValue>...</CipherValue>
  </CipherData>
</EncryptedData>
```

Read more about XML Encryption here.

### Decryption
### Validation
