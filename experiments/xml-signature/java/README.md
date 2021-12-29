## Java XML Digital Signature API

In this example we are using this [Java XML Digital Signature API](https://docs.oracle.com/javase/8/docs/technotes/guides/security/xmldsig/XMLDigitalSignature.html) to generate and validate XML Signatures.

### Run example

* Validate XML

Validate signature.xml

```
$ javac Validate.java
$ java Validate signature.xml
```

* Generate enveloped signature

Generate enveloped signature of the document in the file envelope.xml and store it in the file envelopedSignature.xml in the current working directory.

```
$ javac GenEnveloped.java
$ java GenEnveloped envelope.xml envelopedSignature.xml
```

Validate the generated enveloped signature

```
$ java Validate envelopedSignature.xml

```
## Packages


Common classes that are used to perform XML cryptographic operations.

* [javax.xml.crypto](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/package-summary.html)

 Includes interfaces that represent the core elements defined in the W3C XML digital signature specification.

* [javax.xml.crypto.dsig](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/dsig/package-summary.html)

 Contains interfaces that represent most of the KeyInfo structures defined in the W3C XML digital signature recommendation.

* [javax.xml.crypto.dsig.keyinfo](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/dsig/keyinfo/package-summary.html)

Contains interfaces and classes representing input parameters for the digest, signature, transform, or canonicalization algorithms used in the processing of XML signatures.

* [javax.xml.crypto.dsig.spec](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/dsig/spec/package-summary.html)

Contains DOM-specific classes for the javax.xml.crypto and javax.xml.crypto.dsig packages, respectively. Only developers and users who are creating or using a DOM-based XMLSignatureFactory or KeyInfoFactory implementation will need to make direct use of these packages.

* [javax.xml.crypto.dom](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/dom/package-summary.html) and [javax.xml.crypto.dsig.dom](https://docs.oracle.com/javase/8/docs/api/javax/xml/crypto/dsig/dom/package-summary.html)

## Resources

[Java XML Digital Signature API](https://docs.oracle.com/javase/8/docs/technotes/guides/security/xmldsig/XMLDigitalSignature.html)

[XML Digital Signature API Overview and Tutorial](https://docs.oracle.com/en/java/javase/17/security/java-xml-digital-signature-api-overview-and-tutorial.html)
=======
