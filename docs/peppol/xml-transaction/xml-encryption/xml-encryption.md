# XML Encryption

### What XML Encryption does?

XML Encryption(XML-Enc) defines how to encrypt the contents of an XML element.

There are 2 types of XML Encryption:

* Symmetric or secret key encryption(faster): Sender and receiver use the the same secrete key to both encrypt and decrypt messages.

* Asymmetric or public key encryption: Sender shares public key with receiver. Receiver uses this public to use for encryption and his private key for decryption.

Hybrid encryption = Symmetric or secret key + Asymmetric or public key encryption


#### Before and after hybrid Encryption

##### Original/Decrypted
 ```
 <?xml version="1.0" encoding="utf-8" ?>
 <PayInfo>
   <Name>John Smith</Name>
   <CreditCard Limit='2,000' Currency='USD'>
     <Number>1076 2478 0678 5589</Number>
     <Issuer>CitiBank</Issuer>
     <Expiration>06/10</Expiration>
   </CreditCard>
 </PayInfo>

```

##### Encrypted

```  

session-key-template.xml

<?xml version="1.0" encoding="UTF-8"?>
<!--
XML Security Library example: Original XML
 doc file before encryption (encrypt3 example).
-->
<EncryptedData
  xmlns="http://www.w3.org/2001/04/xmlenc#"
  Type="http://www.w3.org/2001/04/xmlenc#Element">
 <EncryptionMethod Algorithm=
   "http://www.w3.org/2001/04/xmlenc#tripledes-cbc"/>
 <KeyInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
  <EncryptedKey xmlns="http://www.w3.org/2001/04/xmlenc#">
   <EncryptionMethod Algorithm=
     "http://www.w3.org/2001/04/xmlenc#rsa-1_5"/>
   <KeyInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
    <KeyName/>
   </KeyInfo>
   <CipherData>
    <CipherValue/>
   </CipherData>
  </EncryptedKey>
 </KeyInfo>
 <CipherData>
  <CipherValue/>
 </CipherData>
</EncryptedData>

```

### Processing Rules

#### Intended Application Model

* If we have an encrypted element: `encrypted` element-> constructed `EncryptedData` element
* If XML `content` element is encrypted:  `content` element -> constructed `EncryptedData` element

###  Encryption

1. Obtain (or derive) and represent the key(Optional)

 *  If the key is to be identified: Construct the `ds:KeyInfo`( (e.g., `ds:KeyName`, `ds:KeyValue`, `ds:RetrievalMethod`, etc.)

)
 * If the key itself is to be encrypted -> construct an `EncryptedKey` element
 * If the key was derived from a master: construct a `DerivedKey` element with associated child elements

2. Encrypt the data
	* Encrypt the octets using the algorithm and key.
	* If the decryptor don't know the type of the encrypted data: The encryptor should set the Type. See [ Well-known Type parameter values](https://www.w3.org/TR/xmlenc-core/#sec-Type-Parameters).
	If the data is a simple octet sequence it may be described with the `MimeType` and `Encoding`  attributes.(e.g `MimeType="text/xml"`, `MimeType="text/plain"`, `MimeType="image/png"`).

3. Build the `EncryptedData` or `EncryptedKey` structure(encrypted data, encryption algorithm, parameters, key, type of the encrypted data, etc)

	* If the encrypted octet sequence is to be stored in the `CipherData`: the base64 representation of the encrypted octet sequence is inserted as the content of a `CipherValue` element.
	* If the encrypted octet sequence is stored externally to the `EncryptedData` or `EncryptedKey` element: `CipherReference` element describes URI and transforms (if any) required for the Decryptor to retrieve the encrypted octet sequence.


###  Algorithms

* [Algorithm Identifiers and Implementation Requirements](https://www.w3.org/TR/xmlenc-core/#sec-AlgID)
* [ Block Encryption Algorithms](https://www.w3.org/TR/xmlenc-core/#sec-Alg-Block)
* [Stream Encryption Algorithms](https://www.w3.org/TR/xmlenc-core/#sec-Alg-Stream)
* [Key Derivation](https://www.w3.org/TR/xmlenc-core/#sec-Alg-KeyDerivation)
* [Key Transport](https://www.w3.org/TR/xmlenc-core/#sec-Alg-KeyTransport)
* [Key Agreement](https://www.w3.org/TR/xmlenc-core/#sec-Alg-KeyAgreement)
* [Symmetric Key Wrap](https://www.w3.org/TR/xmlenc-core/#sec-Alg-SymmetricKeyWrap)
* [Message Digest](https://www.w3.org/TR/xmlenc-core/#sec-Alg-MessageDigest)
* [Canonicalization](https://www.w3.org/TR/xmlenc-core/#sec-Alg-Canonicalition)


### XSD Schema

* XML Encryption Core Schema Instance: [xenc-schema.xsd](https://www.w3.org/TR/xmlenc-core/xenc-schema.xsd)
* XML Encryption 1.1 Schema Instance: [xenc-schema11.xsd](https://www.w3.org/TR/xmlenc-core/xenc-schema-11.xsd)
*

### Examples

#### SOAP message

```
<?xml version="1.0" encoding="UTF-8"?>
<Envelope xmlns="http://www.w3.org/2001/06/soap-envelope">
  <Body>
    <VerifyCreditCardRequest xmlns="http://…/actions">
      <EncryptedData Type="NodeList“ xmlns="http://…/xmlenc">
        <EncryptionMethod Algorithm="urn:nist-gov:tripledes…">
          <IV>adCwS3wowQ8=</IV>
        </EncryptionMethod>
        …<CipherData>Ynj…M1f</CipherData>…
      </EncryptedData>
    </VerifyCreditCardRequest>
  </Body>
</Envelope>
```

## Resources

[XML Encryption:Processing Rules for XML Elements and Content](https://www.w3.org/Encryption/2001/Minutes/0720-Redwood/simon-outline.html)

[XML Encryption Syntax and Processing Version 1.1](https://www.w3.org/TR/xmlenc-core/)
