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

* The required `SignedInfo` element contains the information that is actually signed:
* The required `CanonicalizationMethod` element defines the algorithm used to canonicalize the SignedInfo element before it is signed or validated.
* The required `SignatureMethod` element defines the digital signature algorithm used to generate the signature
* The optional `Transforms` element contains a list of one or more Transform elements, each of which describes a transformation algorithm used to transform the data before it is digested
* The required `DigestMethod` element defines the algorithm used to digest the data
* The required `DigestValue` element contains the actual base64-encoded digested value.
* Each `Reference` element identifies the data via a URI
* The required `SignatureValue` element contains the base64-encoded signature value of the signature over the SignedInfo element.
* The optional `KeyInfo` element contains information about the key that is needed to validate the signature:
* The `KeyValue` element contains a single public key that may be useful in validating the signature

### Must see

[Definitions](https://www.w3.org/TR/2013/REC-xmldsig-core1-20130411/#Definitions)

### Resources

[XML Signature Syntax and Processing Version 1.1](https://www.w3.org/TR/xmldsig-core1/)

[Example of an XML Signature](https://docs.oracle.com/cd/E17802_01/webservices/webservices/docs/1.6/tutorial/doc/XMLDigitalSignatureAPI7.html)

[An Introduction to XML Digital Signatures](https://www.xml.com/pub/a/2001/08/08/xmldsig.html#key)
