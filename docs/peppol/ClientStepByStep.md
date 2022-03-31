## Peppol AS4

1. Generate Standard Business Document [sbd](/docs/rules/examples/base-example.xml)
2. Generate SOAP Message [soap](/docs/rules/examples/empty-soap.xml)
3. Generate Messaging Element [msg](/docs/rules/examples/ebms.xml) with metadata and a cid reference to the payload [cid]
3. Add [msg] to SOAP Header [head], leave SOAP Body [body] empty, but add an Id => [soap](/docs/rules/examples/soap-with-ebms.xml)
4. Prepend Security Element [sec] to [head] => [soap](/docs/rules/examples/soap-with-empty-wssec.xml) 
5. Canonicalize [sbd], [msg] and [body] with Exclusive C14N 
6. Compress [sbd] => [gzip]
7. Generate Reference Elements [refs] with [cid] and digest of [gzip] and a digest and reference to [msg] and [body] respectively
8. Generate Signature [sig] with private Key [pK] and [refs]
9. Prepend [sig] to [sec]
10. Prepend BinarySecurityToken [BST1] containing a Base64 Encoded X.509 Certificate [x509Client] containing the public Key corresponding to [pK] to [sec] => [soap](/docs/rules/examples/soap-with-signature.xml)
11. Grab the Recipients X.509 Certificate [x509Server]
12. Generate a Random Key compatible with AES128GCM [encryptionKey]
13. Encrypt [encryptionKey] with RSA-OAEP using [x509Server]s public Key => [encryptedKey]
14. Encrypt [gzip] with AES128GCM => [payloadEncrypted] using [encryptionKey], keep track of the nonce/initialization vector [nonce] and the authentication tag [tag]
15. [nonce] + [payloadEncrypted] + [tag] => [payload]
16. Generate the EncryptedData Element [ED] with CipherData containing a CipherReference to [cid] and KeyInfo containing a SecurityTokenReference to [encryptedKey]
17. Prepend [ED] to [sec]
18. Generate an EncryptedKey Element [EK] using the Reference Id referenced in [ED], a reference to [BST2], a CipherData Element Containing [encryptedKey] and a reference to [ED] within a ReferenceList
19. Prepend [EK] to [sec]
20. Generate a BinarySecurityToken[BST2] Element containing the base64 encoded [x509Server] certificate.
21. Prepend [BST2] to [sec] => [soap](/docs/rules/examples/soap-complete.xml)
22. Generate MIME Message with Part 1 being [soap] and Part 2 being [payload] making sure that the Content-ID MIME Header is set to the cid used to reference [cid] within the SOAP Header => [MIMEMessage](/docs/rules/examples/completeMessage)
23. Send