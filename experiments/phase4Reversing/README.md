# This documents my experiments with phase4 trying to figure out curl commands and data to generate valid peppol requests.

To do this yourself, grab the non-certificate phase4 source at http://github.com/br0kk0l1/phase4, build it with ```mvn clean install -U``` and then from phase4/phase4-peppol-server-webapp run src/test/java/com/helger/phase4/peppol/server/standalone/RunInJettyPHASE4PEPPOL.java, which will start a jettyserver on localhost:8080 with an as4 endpoint at localhost:8080/as4.

generate a pkcs12 store with
```sh
keytool -genkeypair -keystore test-ap-2021.p12 -storetype PKCS12 -storepass peppol -alias "openpeppol aisbl id von pop00036" -keyalg RSA -keysize 2048 -validity 99999 -dname "CN=My SSL Certificate, OU=My Team, O=My Company, L=My City, ST=My State, C=SA" -ext san=dns:nimladris,dns:localhost,ip:127.0.0.1
```
copy it into resources folder, for good measure i just put it into all of them :^) so it will hopefully be found by whatever thing you're trying to run with 
```sh
for d in $(find -type d -name 'resources'); do cp test-ap-2021.p12 $d; done;
```

Then in phase4/phase4-peppol/client run src/test/java/com/helger/phase4/peppol/MainPhase4PeppolSender.java in a debugger, setting a breakpoint in AbstractAS4UserMessageBuilderMIMEPayload.java on line 118 so you can change the value of m_sEndpointURL to "http://localhost:8080/as4" (this value is parsed from an xml that you get from the smp server, so you cannot change it in config or anything afaik, hence using a debugger), so it will send a request to the phase4-peppol-server-webapp.

the resulting request is then stored by the server in phase4-data and can be inspected. (see ./phase4-data/*)

the server is still returning an as4 error message, but my guess is that it's certificate related, i'm now gonna ponder over the phase4-data for a bit to make sense of it as much as i can

now for some preliminary analysis of phase4-data/as4dump/[...]/*.as4in (ie the request sent by phase4-peppol-client):

# Part I: Http Header

```http
Connection: keep-alive
User-Agent: phase4/1.3.6-SNAPSHOT https://github.com/phax/phase4
Host: localhost:8080
Message-Id: <290797668.1.1640773679773@nimladris>
Accept-Encoding: gzip,deflate
Content-Length: 13638
Date: Wed, 29 Dec 2021 11:27:59 +0100 (CET)
MIME-Version: 1.0
Content-Type: multipart/related;    boundary="----=_Part_0_1471949830.1640773679747";    type="application/soap+xml"; charset=UTF-8
```

# Part II: SOAP Request
## MIME Header for SOAP Envelope
```http

------=_Part_0_1471949830.1640773679747
Content-Type: application/soap+xml;charset=UTF-8
Content-Transfer-Encoding: binary

```
## SOAP Envelope
```xml
<?xml version="1.0" encoding="UTF-8"?>
    <S12:Envelope xmlns:S12="http://www.w3.org/2003/05/soap-envelope">
```
### SOAP Header
#### WSSE Security
```xml
   <S12:Header>
        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" S12:mustUnderstand="true">
            <wsse:BinarySecurityToken EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" wsu:Id="Gca3589a7-3c1e-46d3-b2c9-e64c28e716f6">MIIF0DCCA7igAwIBAgIQaTLeH2w+k17SRJj3jdnb2DANBgkqhkiG9w0BAQsFADBrMQswCQYDVQQGEwJCRTEZMBcGA1UEChMQT3BlblBFUFBPTCBBSVNCTDEWMBQGA1UECxMNRk9SIFRFU1QgT05MWTEpMCcGA1UEAxMgUEVQUE9MIEFDQ0VTUyBQT0lOVCBURVNUIENBIC0gRzIwHhcNMjEwMTA3MDAwMDAwWhcNMjIxMjI4MjM1OTU5WjBdMRIwEAYDVQQDDAlQT1AwMDAyNjAxFzAVBgNVBAsMDlBFUFBPTCBURVNUIEFQMSEwHwYDVQQKDBhHb3Zlcm5pa3VzIEdtYkggJiBDby4gS0cxCzAJBgNVBAYTAkRFMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3TmCGKB1my+zwT/hWvYlyQlOKbueaZSCgUKMG4+d+LgdRrN8lAT0S8Dc9UKbr6wvp9PUU1xrMQgf+54YPlHZbNXPHT9rhvn1N9bWHdcVz6LWq1EoyrDcAA46oxOWe4oLHbbPdx4IDiC5AGzIQm3sjdRcOeLHZHRintAPGMYCRJWKjIe97sb3zB/4GAJlckxUNyz7uz++9HR1QBUOADHAL+VsW/Yc1XeZl93fNPZynBqvkqg75aYRKJ016teR2cyYHISZNKz0oNGSBodXWgBr9a9mHp0O5E0H3Smi7QGmohj7O0YAesb2bTMURTg+g87QSVsdWUfwRRS1c6oDtkrzQwIDAQABo4IBfDCCAXgwDAYDVR0TAQH/BAIwADAOBgNVHQ8BAf8EBAMCA6gwFgYDVR0lAQH/BAwwCgYIKwYBBQUHAwIwHQYDVR0OBBYEFBLISp8hPBjKFJtgAKz9olX2LSI3MF0GA1UdHwRWMFQwUqBQoE6GTGh0dHA6Ly9wa2ktY3JsLnN5bWF1dGguY29tL2NhXzZhOTM3NzM0YTM5M2EwODA1YmYzM2NkYThiMzMxMDkzL0xhdGVzdENSTC5jcmwwNwYIKwYBBQUHAQEEKzApMCcGCCsGAQUFBzABhhtodHRwOi8vcGtpLW9jc3Auc3ltYXV0aC5jb20wHwYDVR0jBBgwFoAUa29LtvE3uis8fxjNuiuyuXwqN+swLQYKYIZIAYb4RQEQAwQfMB0GE2CGSAGG+EUBEAECAwEBgamQ4QMWBjk1NzYwODA5BgpghkgBhvhFARAFBCswKQIBABYkYUhSMGNITTZMeTl3YTJrdGNtRXVjM2x0WVhWMGFDNWpiMjA9MA0GCSqGSIb3DQEBCwUAA4ICAQB2rxS1vlydpIuWpM9qeQo+ghA8tYOIRqJTjA0fCXUHraz7DQI15k+4tHR2QQaz2vL6HAROCS793JtJjgUcHthz87/t8kktdjCe6U+xmWLb/VHGWBf/s9n7rp4uXKego12KSmrIpDa+BTcFjaiE4XaZZmVNkDMGTfhdSfL7epk0A01WelBTgVJPlN+Hv+ZNyyoqKbZQGJXQfv87z0Ot4NVJakk8WfjPZnjxHxutlkNIoYBoQaP8ujoRZKn94KglqbWHywOY6ZZ6PCxqV5q/KmBtg491/6gkolNzNlHeztalXrUi8V27VRoj752+zhswB2hDnLmjsvHllDbEgH/Rju/+RsrBFndVbwWiM+D6Wd82ttBv0YNlpw6Pe54Mqp9sCMNcfmVjzsOBPx3NkMKMeCZI8K1E8zV+KnWd8THZGcOOR3xNGbp23CLIki2jtvXU2M4IQ6R4ew8ae2Sf0LpLdu54z7cgO40Ca+Z0Cin1hC9BB5vqNVuadJ+LPTy2Hjt3GlQbKciVBAuOTP+oQhpB1DlSFKM4apWttIar/i0loZNHQN0/92UvnHYM4CzWwpuct/3PwOXVWU11MABCYlcWRy7wZyn5OaEPo3zE6MbeotHfozbLw2VVGt0doVFhIwbaABmASmZ10HNUZzBVgeLOAl9VIkgYNNp50is3xQBllyyBdQ==</wsse:BinarySecurityToken>
            <xenc:EncryptedKey xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" Id="EK-b28696a2-74fd-4c22-ab8f-88765082a6ab">
                <xenc:EncryptionMethod Algorithm="http://www.w3.org/2009/xmlenc11#rsa-oaep">
                    <ds:DigestMethod xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                    <xenc11:MGF xmlns:xenc11="http://www.w3.org/2009/xmlenc11#" Algorithm="http://www.w3.org/2009/xmlenc11#mgf1sha256" />
                </xenc:EncryptionMethod>
                <ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
                    <wsse:SecurityTokenReference>
                        <wsse:Reference URI="#Gca3589a7-3c1e-46d3-b2c9-e64c28e716f6" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" />
                    </wsse:SecurityTokenReference>
                </ds:KeyInfo>
                <xenc:CipherData>
                    <xenc:CipherValue>ceuuS2fNpeTlH9UmgQdaquxODd5px6KjsslcYbnw9Z8SCI8kXcfpU4cUp4T8wvRvei78rQoQGxCDfMJHoOfr//wbdDeJ3D0Ni7PzKIsypVuXQXAam70ZnLiM6A4M1pv3oq8T+a/UHIaYK2MQaCkxE7meYHZZvy52CN4Ad9oDQ7U5Ia2HFwGbV8LY2OOtI5drGZm/n9e9VgFpqs+rjgPBRvX0LGcKSpSN3/tKcbeIoyffInKqhRHXtkLs94TpmYxf7aq6tW/JGc03FOnRd+BozZ+cqt2dzI/WYtJi5jjCuPY8RVTs8PLOzYQkLI5YUHbSL5J4IwDPljBG/vLr4Kj1/Q==</xenc:CipherValue>
                </xenc:CipherData>
                <xenc:ReferenceList>
                    <xenc:DataReference URI="#ED-002189a7-1c00-4f33-a79a-6f99439ef4fa" />
                </xenc:ReferenceList>
            </xenc:EncryptedKey>
            <xenc:EncryptedData xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" Id="ED-002189a7-1c00-4f33-a79a-6f99439ef4fa" MimeType="application/gzip" Type="http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Only">
                <xenc:EncryptionMethod Algorithm="http://www.w3.org/2009/xmlenc11#aes128-gcm" />
                <ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
                    <wsse:SecurityTokenReference xmlns:wsse11="http://docs.oasis-open.org/wss/oasis-wss-wssecurity-secext-1.1.xsd" wsse11:TokenType="http://docs.oasis-open.org/wss/oasis-wss-soap-message-security-1.1#EncryptedKey">
                        <wsse:Reference URI="#EK-b28696a2-74fd-4c22-ab8f-88765082a6ab" />
                    </wsse:SecurityTokenReference>
                </ds:KeyInfo>
                <xenc:CipherData>
                    <xenc:CipherReference URI="cid:phase4-att-b6c46176-2a7b-4fc4-9fa5-019659d9f377@cid">
                        <xenc:Transforms>
                            <ds:Transform xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Algorithm="http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Ciphertext-Transform" />
                        </xenc:Transforms>
                    </xenc:CipherReference>
                </xenc:CipherData>
            </xenc:EncryptedData>
            <wsse:BinarySecurityToken EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" wsu:Id="X509-d5706120-b055-40ec-93dc-0396503acdd0">MIIDtDCCApygAwIBAgIEUWNOEzANBgkqhkiG9w0BAQsFADB2MQswCQYDVQQGEwJTQTERMA8GA1UECBMITXkgU3RhdGUxEDAOBgNVBAcTB015IENpdHkxEzARBgNVBAoTCk15IENvbXBhbnkxEDAOBgNVBAsTB015IFRlYW0xGzAZBgNVBAMTEk15IFNTTCBDZXJ0aWZpY2F0ZTAgFw0yMTEyMjkxMDAxMzdaGA8yMjk1MTAxMzEwMDEzN1owdjELMAkGA1UEBhMCU0ExETAPBgNVBAgTCE15IFN0YXRlMRAwDgYDVQQHEwdNeSBDaXR5MRMwEQYDVQQKEwpNeSBDb21wYW55MRAwDgYDVQQLEwdNeSBUZWFtMRswGQYDVQQDExJNeSBTU0wgQ2VydGlmaWNhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCWp+YMylQs4DgoPHTnHC2Md3IQk8pD1ozq8xCsIwZ7ia93GvDIQvPvxBYUKVpO4/wMGJFdhXxLpdsSVpE2w8I8gD8dedcFUXcqBWoiHpGm+kLfr2T/QCb4YjEa+f6S5D0gN8MbMBRuzVedfgkOOyB5BEeInq/OC84Ewx2ejfNHjcKC9Z3yVUqJ4NfNUSDwxqib2ig1MwzVkcxvstA4E/vPlnOF7ZxuAbPIbGxHll97Vg5cnpjxp8wAJoIJyrAE4KP0QNAbnN8d37nu2jCokKz7UY4z0/ZnsK+dt4MvRfWmV6jIIGmQ+Ep5HsMpOpAT3ElSmp1EHWxSyFhbgj1qaNUJAgMBAAGjSDBGMB0GA1UdDgQWBBTQjPH/D/yGzXQQ8M/zw4okuB9dZjAlBgNVHREEHjAcggluaW1sYWRyaXOCCWxvY2FsaG9zdIcEfwAAATANBgkqhkiG9w0BAQsFAAOCAQEADbJ0Tn/RremWhpwsn3MjDxPSdwAlEamvzcE+ZFwYMah7RzRvFbhQ3CY4JSn9BMgkZJF6C3ybefQO4/E4D3J6lz25L2JT1SfohiamOKhdMoKtIOWHJec5MaTgQQ08yga+9I91xdONtmE07byNIh7S3M2GfBBlC/+0Ic48SocgfiOw2ASQCzmqnbqFSX17097vepuMQLNR2nORbGLGWGM7TbfxanoaUVJXM3+CLPnj6qvYEM1zjO7agThL3PCeucRrubApUhxYrisYNFhMCy7NJqCM7oBgp/eM0Ne7dBeijICDv71ERgU4s59EwxSiDyBxVLWHfnQRJ6X2SY6Vn79Mew==</wsse:BinarySecurityToken>
            <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="SIG-e1276a41-9e81-4df8-95ac-b74fead73696">
                <ds:SignedInfo>
                    <ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#">
                        <ec:InclusiveNamespaces xmlns:ec="http://www.w3.org/2001/10/xml-exc-c14n#" PrefixList="S12" />
                    </ds:CanonicalizationMethod>
                    <ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256" />
                    <ds:Reference URI="#phase4-msg-ab281644-449c-4c6f-93cd-621c0e3820b7">
                        <ds:Transforms>
                            <ds:Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#" />
                        </ds:Transforms>
                        <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                        <ds:DigestValue>1vQneNUsroRODXfOjAJk9tUEqjXW5FF8E7qxLaQ4t44=</ds:DigestValue>
                    </ds:Reference>
                    <ds:Reference URI="#id-5faf524a-9076-4eb3-a619-5b6c43d50a67">
                        <ds:Transforms>
                            <ds:Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#" />
                        </ds:Transforms>
                        <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                        <ds:DigestValue>ppG21MAP6DuUSgz39E5p40ohVWMKxoIFXam4/tUNx78=</ds:DigestValue>
                    </ds:Reference>
                    <ds:Reference URI="cid:phase4-att-b6c46176-2a7b-4fc4-9fa5-019659d9f377@cid">
                        <ds:Transforms>
                            <ds:Transform Algorithm="http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Signature-Transform" />
                        </ds:Transforms>
                        <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                        <ds:DigestValue>XmiWQC4ICVED4bKQz98T/Le3Sa1j0vZu+TL7SM4n+gE=</ds:DigestValue>
                    </ds:Reference>
                </ds:SignedInfo>
                <ds:SignatureValue>dOkx4AgUO2TJRUy4U/pGwr1LntoCcVFlXIaf72sD9vP+8C5hLllpbkz9oA9b5XUk5EWiX3dna5lOxOusl1vfdODbV/y1PMgN85OlFo9BRUo4iLO6iPT/p1rLSlNkHEFn+loLTv14S82Rk6em9g0dUSbsNU84UBQ/+02TjIlqzWl7fHdbmW1mhvrp+XewdcFcDeTP/k/PkQJt70HHFAYDFJkOIKwoMpAUEb3rTwpmDYukJBTwnhgcbGiOyHP5/xQxkfJuHyQMOQMeTC/nsyKO4UeE8cqIeSYwou5zrPkI6xq2V4L/pnRxKnCDvEAgzdraYsNs197/b/Qy74c+a6c/6Q==</ds:SignatureValue>
                <ds:KeyInfo Id="KI-2ac03e35-2687-4eb9-915c-630b3ab86cef">
                    <wsse:SecurityTokenReference wsu:Id="STR-3db4e175-b04e-420f-81ff-e7f268725039">
                        <wsse:Reference URI="#X509-d5706120-b055-40ec-93dc-0396503acdd0" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" />
                    </wsse:SecurityTokenReference>
                </ds:KeyInfo>
            </ds:Signature>
        </wsse:Security>

```
#### Actual SOAP Header 
```xml
        <eb:Messaging xmlns:S11="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:eb="http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/" xmlns:ebbp="http://docs.oasis-open.org/ebxml-bp/ebbp-signals-2.0" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" xmlns:xlink="http://www.w3.org/1999/xlink" S12:mustUnderstand="true" wsu:Id="phase4-msg-ab281644-449c-4c6f-93cd-621c0e3820b7">
            <eb:UserMessage>
                <eb:MessageInfo>
                    <eb:Timestamp>2021-12-29T11:27:59.203+01:00</eb:Timestamp>
                    <eb:MessageId>17c26b79-d056-49ee-9948-1e66896baeb4@phase4</eb:MessageId>
                </eb:MessageInfo>
                <eb:PartyInfo>
                    <eb:From>
                        <eb:PartyId type="urn:fdc:peppol.eu:2017:identifiers:ap">POP000306</eb:PartyId>
                        <eb:Role>http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/initiator</eb:Role>
                    </eb:From>
                    <eb:To>
                        <eb:PartyId type="urn:fdc:peppol.eu:2017:identifiers:ap">POP000260</eb:PartyId>
                        <eb:Role>http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/responder</eb:Role>
                    </eb:To>
                </eb:PartyInfo>
                <eb:CollaborationInfo>
                    <eb:AgreementRef>urn:fdc:peppol.eu:2017:agreements:tia:ap_provider</eb:AgreementRef>
                    <eb:Service type="cenbii-procid-ubl">urn:fdc:peppol.eu:2017:poacc:billing:01:1.0</eb:Service>
                    <eb:Action>busdox-docid-qns::urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1</eb:Action>
                    <eb:ConversationId>phase4@Conv3042295173416196702</eb:ConversationId>
                </eb:CollaborationInfo>
                <eb:MessageProperties>
                    <eb:Property name="originalSender" type="iso6523-actorid-upis">9915:phase4-test-sender</eb:Property>
                    <eb:Property name="finalRecipient" type="iso6523-actorid-upis">9958:peppol-development-governikus-01</eb:Property>
                </eb:MessageProperties>
                <eb:PayloadInfo>
                    <eb:PartInfo href="cid:phase4-att-b6c46176-2a7b-4fc4-9fa5-019659d9f377@cid">
                        <eb:PartProperties>
                            <eb:Property name="MimeType">application/xml</eb:Property>
                            <eb:Property name="CompressionType">application/gzip</eb:Property>
                        </eb:PartProperties>
                    </eb:PartInfo>
                </eb:PayloadInfo>
            </eb:UserMessage>
        </eb:Messaging>
    </S12:Header>
```
### SOAP Body
```xml
    <S12:Body xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" wsu:Id="id-5faf524a-9076-4eb3-a619-5b6c43d50a67" />
</S12:Envelope>
```

## MIME Header for the Attachment
```http
------=_Part_0_1471949830.1640773679747
Content-Type: application/octet-stream
Content-Transfer-Encoding: binary
Content-Description: Attachment
Content-ID: <phase4-att-b6c46176-2a7b-4fc4-9fa5-019659d9f377@cid>
```
## binary data encoding ubl-invoice.xml
>TODO: figure out exact encoding of binary data
```
[...snip binary blob]
------=_Part_0_1471949830.1640773679747--
```