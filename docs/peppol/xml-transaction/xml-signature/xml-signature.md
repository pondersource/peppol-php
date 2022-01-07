# XML Signature

### What is an XML signature?

An XML signature is a digital signature represented in XML syntax.

![Digital Signature](https://github.com/pondersource/peppol-php/blob/xml-signature/docs/pics/digital-signature.png?raw=true)

Each XML signature can sign more than one type of resource. For example, a single XML signature might cover character-encoded data (HTML), binary-encoded data (a JPG), XML-encoded data, and a specific section of an XML file.


### [XML Signature Syntax and Processing Version 1.1](https://www.w3.org/TR/xmldsig-core/)
 (based on W3C Recommendatio,  11 April 2013)

### How to Create an XML Signature

1. Determine which resources are to be signed.
2. Calculate the digest of each resource.
3. Collect the Reference elements
4. Signing
5. Add key information
6. Enclose in a Signature element

### Examples

```
<Signature ID?>
  <SignedInfo>
    <CanonicalizationMethod />
    <SignatureMethod />
   (<Reference URI? >
     (<Transforms>)?
      <DigestMethod>
      <DigestValue>
    </Reference>)+
  </SignedInfo>
  <SignatureValue>
 (<KeyInfo>)?
  <KeyValue>
  </KeyValue>
 (<Object ID?>)*
</Signature>
```

| ELEMENTS      | 	REQUIRED | FUNCTIONALLITY     |
| :---        |    :----:   |          ---: |
|Signature| YES | The Signature element has been inserted inside the content that it is signing|
| SignedInfo      | YES     |  Contains the information that is actually signed   |
|CanonicalizationMethod   | YES        |  Defines the algorithm used to canonicalize the SignedInfo element before it is signed or validated     |
| SignatureMethod | YES | Defines the digital signature algorithm used to generate the signature|
| Transforms | NO | Contains a list of one or more Transform elements, each of which describes a transformation algorithm used to transform the data before it is digested |
|DigestMethod | YES | Defines the algorithm used to digest the data|
| DigestValue | YES | Contains the actual base64-encoded digested value |
| Reference | YES 1..n | Identifies the data via a URI |
| SignatureValue | YES | Contains the actual base64-encoded digested value|
| KeyInfo | NO | Contains information about the key that is needed to validate the signature|
| KeyValue | NO | Contains a single public key that may be useful in validating the signature|

## What signature algorithms are?

Algorithms are identified by URIs that appear as an attribute to the element that identifies the algorithms' role

### Algorithms

1. [Digest](https://www.w3.org/TR/xmldsig-core1/#sec-MessageDigests)

* [SHA-1](https://www.w3.org/TR/xmldsig-core1/#sec-SHA-1)
* [SHA-224](https://www.w3.org/TR/xmldsig-core1/#sec-SHA-224)
* [SHA-256](https://www.w3.org/TR/xmldsig-core1/#sec-SHA-256)
* [SHA-384](https://www.w3.org/TR/xmldsig-core1/#sec-SHA-384)
* [SHA-512](https://www.w3.org/TR/xmldsig-core1/#sec-SHA-512)


2. [Transform](https://www.w3.org/TR/xmldsig-core1#secTransformAlg)

* [Canonicalization](https://www.w3.org/TR/xmldsig-core1/#sec-Canonicalization)
* [Base64](https://www.w3.org/TR/xmldsig-core1/#sec-Base-64)
* [XPath Filtering](https://www.w3.org/TR/xmldsig-core1/#sec-XPath)
* [https://www.w3.org/TR/xmldsig-core1/#sec-EnvelopedSignature](https://www.w3.org/TR/xmldsig-core1/#sec-EnvelopedSignature)
* [XSLT Transform](https://www.w3.org/TR/xmldsig-core1/#sec-XSLT)

3. [Signature](https://www.w3.org/TR/xmldsig-core1/#sec-SignatureAlg)

* [DSA](https://www.w3.org/TR/xmldsig-core1/#sec-DSA)
* [RSA](https://www.w3.org/TR/xmldsig-core1/#sec-PKCS1)
* [ECSDA](https://www.w3.org/TR/xmldsig-core1/#sec-ECDSA)


4. [Canonicalization](https://www.w3.org/TR/xmldsig-core1/#sec-c14nAlghttps://www.w3.org/TR/xmldsig-core1/#sec-Canonical)

* [Canonical XML 1.0](https://www.w3.org/TR/xmldsig-core1/#sec-Canonical)
* [Canonical XML 1.1](https://www.w3.org/TR/xmldsig-core1/#sec-Canonical11)
* [Exclusive XML Canonicalization 1.0](https://www.w3.org/TR/xmldsig-core1/#sec-ExcC14N10)


### XSD Schema

* [XML Signature Core Schema Instance](https://www.w3.org/TR/2008/REC-xmldsig-core-20080610/xmldsig-core-schema.xsd)

* [XML Signature 1.1 Schema Instance](https://www.w3.org/TR/xmldsig-core1/xmldsig11-schema.xsd)
* [XML Signature 1.1 Schema Driver](https://www.w3.org/TR/xmldsig-core1/xmldsig1-schema.xsd)

### Must see

[Definitions](https://www.w3.org/TR/2013/REC-xmldsig-core1-20130411/#Definitions)
[xml digital signature core schema](https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd#)

### XML Signature libraries:

#### Python

* [signxml](https://github.com/XML-Security/signxml)
* [python-saml](https://github.com/onelogin/python-saml)

#### PHP

* [php-XmlDigitalSignature](https://github.com/marcelxyz/php-XmlDigitalSignature)
* [xmlseclibs](https://github.com/robrichards/xmlseclibs)
* [php-saml](https://github.com/onelogin/php-saml)

#### C

* [xmlsec](https://github.com/lsh123/xmlsec)

#### JAVA

* [xmlsignverify-core-java](https://github.com/Mastercard/xmlsignverify-core-java)

#### Go

* [gosaml2](https://github.com/russellhaering/gosaml2)
* [goxmldsig](https://github.com/russellhaering/goxmldsig)

### Resources

[XML Signature Syntax and Processing Version 1.1](https://www.w3.org/TR/xmldsig-core1/)

[Example of an XML Signature](https://docs.oracle.com/cd/E17802_01/webservices/webservices/docs/1.6/tutorial/doc/XMLDigitalSignatureAPI7.html)

[An Introduction to XML Digital Signatures](https://www.xml.com/pub/a/2001/08/08/xmldsig.html)
