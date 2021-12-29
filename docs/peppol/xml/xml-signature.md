# XML Signature

### What is a XML signature?

An XML signature is a digital signature represented in XML syntax.

![digitan signature](https://github.com/pondersource/peppol-php/blob/xml-signature/docs/pics/digital-signature.png?raw=true)

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

### XML namespace URIs:

| URI      | namespace prefix	 | XML internal entity     |
| :---        |    :----:   |          ---: |
| http://www.w3.org/2000/09/xmldsig#      | default namespace, ds:, dsig:       |  `<!ENTITY dsig "http://www.w3.org/2000/09/xmldsig#">`   |
| http://www.w3.org/2009/xmldsig11#   | dsig11:        | `<!ENTITY dsig11 "http://www.w3.org/2009/xmldsig11#">`     |

While implementations must support XML and XML namespaces, and while use of the above namespace URIs is required, the namespace prefixes and entity declarations given are merely editorial conventions used in this document. Their use by implementations is optional.

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
    <DSAKeyValue>
      <P>...</P><Q>...</Q><G>...</G><Y>...</Y>
    </DSAKeyValue>
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

* [Digest](https://www.w3.org/TR/xmldsig-core1/#sec-MessageDigests)
* [Transform](https://www.w3.org/TR/xmldsig-core1#secTransformAlg)
* [Signature](https://www.w3.org/TR/xmldsig-core1/#sec-SignatureAlg)
* [Canonicalization](https://www.w3.org/TR/xmldsig-core1/#sec-c14nAlg)

### Must see

[Definitions](https://www.w3.org/TR/2013/REC-xmldsig-core1-20130411/#Definitions)

### XML Signature libraries:

#### Python

* [signxml](https://github.com/XML-Security/signxml)
* [python-saml](https://github.com/onelogin/python-saml)

#### PHP

* [php-XmlDigitalSignature](https://github.com/marcelxyz/php-XmlDigitalSignature)
* [xmlseclibs](https://github.com/robrichards/xmlseclibs)
* [https://github.com/onelogin/php-saml](https://github.com/onelogin/php-saml)

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
