# SMP Lookup Algorithm
Sample SMP lookup url

http://b-c5dfca40c96105ec54e99c1103bbe603.iso6523-actorid-upis.acc.edelivery.tech.ec.europa.eu/iso6523-actorid-upis%3A%3A9915%3Aphase4-test-sender/services/busdox-docid-qns%3A%3Aurn%3Aoasis%3Anames%3Aspecification%3Aubl%3Aschema%3Axsd%3AInvoice-2%3A%3AInvoice%23%23urn%3Acen.eu%3Aen16931%3A2017%23compliant%23urn%3Afdc%3Apeppol.eu%3A2017%3Apoacc%3Abilling%3A3.0%3A%3A2.1


## SMLInfo
ID, DisplayName, DNSZone, ManagementServiceURL, ClientCertificateRequired

DIGIT_PRODUCTION("digitprod", "SML", "edelivery.tech.ec.europa.eu.", "https://edelivery.tech.ec.europa.eu/edelivery-sml", true)

DIGIT_TEST("digittest", "SMK", "acc.edelivery.tech.ec.europa.eu.", "https://acc.edelivery.tech.ec.europa.eu/edelivery-sml", true)

DEVELOPMENT_LOCAL("local", "Development", "smj.peppolcentral.org.", "http://localhost:8080", false)


## Inputs
- ServiceGroupID/ParticipantIdentifier
- DocumentTypeID
- ProcessID
- TransportProfile

```
DefaultParticipantIdentifierScheme = "iso6523-actorid-upis"
       ParticipantIdentifierValue = "9915:phase4-test-sender"

DefaultDocumentTypeScheme = "busdox-docid-qns"
InvoiceDocumentType = "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1"

DefaultProcessIdentifierScheme = "cenbii-procid-ubl"
DefaultProcessIdentifier = "urn:fdc:peppol.eu:2017:poacc:billing:01:1.0"
```

## Look up
if (ParticipantIdentifierValue == '\*') dnsPart = "\*" else dnsPart = lowercase("B-" + hashMD5(ParticipantIdentifierValue))

SMPHost = http:// dnsPart . ParticipantIdentifierScheme . DNSZone(removing the . in the end of the zone)

SMPEndPoint = SMPHost / url_encode(ParticipantIdentifierScheme::ParticipantIdentifierValue) /services/ url_encode(DocumentTypeScheme::DocumentType)

GET SMPEndPoint

200

``` xml
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<smp:SignedServiceMetadata xmlns:smp="http://busdox.org/serviceMetadata/publishing/1.0/" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:id="http://busdox.org/transport/identifiers/1.0/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <smp:ServiceMetadata>
        <smp:ServiceInformation>
            <id:ParticipantIdentifier scheme="iso6523-actorid-upis">9915:phase4-test-sender</id:ParticipantIdentifier>
            <id:DocumentIdentifier scheme="busdox-docid-qns">urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1</id:DocumentIdentifier>
            <smp:ProcessList>
                <smp:Process>
                    <id:ProcessIdentifier scheme="cenbii-procid-ubl">urn:fdc:peppol.eu:2017:poacc:billing:01:1.0</id:ProcessIdentifier>
                    <smp:ServiceEndpointList>
                        <smp:Endpoint transportProfile="peppol-transport-as4-v2_0">
                            <wsa:EndpointReference>
                                <wsa:Address>https://www.helger.com/phase4/as4</wsa:Address>
                            </wsa:EndpointReference>
                            <smp:RequireBusinessLevelSignature>false</smp:RequireBusinessLevelSignature>
                            <smp:Certificate>MIIF2DCCA8CgAwIBAgIQBcAefsdQIk7jCCLVCAicizANBgkqhkiG9w0BAQsFADBr
MQswCQYDVQQGEwJCRTEZMBcGA1UEChMQT3BlblBFUFBPTCBBSVNCTDEWMBQGA1UE
CxMNRk9SIFRFU1QgT05MWTEpMCcGA1UEAxMgUEVQUE9MIEFDQ0VTUyBQT0lOVCBU
RVNUIENBIC0gRzIwHhcNMjEwNTI0MDAwMDAwWhcNMjMwNTE0MjM1OTU5WjBlMQsw
CQYDVQQGEwJBVDEpMCcGA1UECgwgUGhpbGlwIEhlbGdlciBJVCBDb25zdWx0aW5n
IGUuVS4xFzAVBgNVBAsMDlBFUFBPTCBURVNUIEFQMRIwEAYDVQQDDAlQT1AwMDAz
MDYwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCZ5JhELH0Dt9BIViJM
+G1KaXNkTJLXQnJk/iBRz1DamVDEFgO7TK68iJ61Uo3K5YyG+hry88Xuq+3ld5sA
o/bHkPM+jXkxXSypa7xJooWtmPVNsTanMXWSwckOCuXN1g3+cSXucgJSCGlxJ7C6
48rsbb0w0Ax7/rc0L5oSMoG3D/PS+8JwMOzskp1h/obQ2inwUmHYQ8k3XnugjQGi
dZk3Yg3F262bGtjDoBALJoscz6tQzYl5cSYvxG17U8a4d9la1tFFGO7nKJOYRoAj
QlbHZmG0X9NJycL9GlCN8lc4kQdqy/0yWMdFD8VavS3hPJXYgnoB6+7tUXqwkwCM
yPELAgMBAAGjggF8MIIBeDAMBgNVHRMBAf8EAjAAMA4GA1UdDwEB/wQEAwIDqDAW
BgNVHSUBAf8EDDAKBggrBgEFBQcDAjAdBgNVHQ4EFgQUgsniY6pSk2BsXSwTUpfO
8e4MwBMwXQYDVR0fBFYwVDBSoFCgToZMaHR0cDovL3BraS1jcmwuc3ltYXV0aC5j
b20vY2FfNmE5Mzc3MzRhMzkzYTA4MDViZjMzY2RhOGIzMzEwOTMvTGF0ZXN0Q1JM
LmNybDA3BggrBgEFBQcBAQQrMCkwJwYIKwYBBQUHMAGGG2h0dHA6Ly9wa2ktb2Nz
cC5zeW1hdXRoLmNvbTAfBgNVHSMEGDAWgBRrb0u28Te6Kzx/GM26K7K5fCo36zAt
BgpghkgBhvhFARADBB8wHQYTYIZIAYb4RQEQAQIDAQGBqZDhAxYGOTU3NjA4MDkG
CmCGSAGG+EUBEAUEKzApAgEAFiRhSFIwY0hNNkx5OXdhMmt0Y21FdWMzbHRZWFYw
YUM1amIyMD0wDQYJKoZIhvcNAQELBQADggIBAEKChnxTRm0v2witAJaXR/COiMsf
wmbdc24q59ePcij9hrcFmJdfBahZE2iwf3HVg1I0ZH73ltd8B4J6xUCE63YjzMQC
weDTr/enKmsEYOmAS5tHL7XGVjrA6DII0q2ZuTL9rwFs6iQnTMrUDIdhaWaGlPRC
MKu46I+uu44hhfDj6Z6f40wyfrGbyTYvzNHpCN66rUTH0Tsp3myvgX0KAD3F/6iD
zcb5m2OMz4uv/ES5soOWRuso9vZ/l4hM9TTTWn0MZMo6pKCBAjdKqCD+/SHkLnX0
0PcAaUZSWxxX24EEIO43/ayuwclHK9onRve9YA/jmbLOFh1SLP+ce/NTDGI5mOZa
qCYNqAH8ehiDvy4HmBkeLWZyWktUVMi+v6F/dufDVvlh4kNIDXHR8yYykWTLA8Od
g5+h7nFsLmrPsuRojYBFbOHhMtljaabVRfgis1Fbccc8rp2gY+jPeT6yeoLuVgJb
Ai5OnpFLh8IrYpbI1X07/Rq65/rH6cZ6ycvBZOb7QnvFUiQ8xScqJGZ25mLTdwzj
PyuBgo8SPGQCiEI/30nWouK6tSl20MFj6gI8TkNUSrhLi/EFxxIpgZW08CGf4Hso
vspud5kJ+cB9hYT1Xqbjq0RT9asvMz3g6HMyD/64ip9BXocAbe6zb4ueU8tKkDIP
QN2iwe7sEx4qUZf3</smp:Certificate>
                            <smp:ServiceDescription>Philip Helger Test endpoint</smp:ServiceDescription>
                            <smp:TechnicalContactUrl>peppol-support@helger.com</smp:TechnicalContactUrl>
                        </smp:Endpoint>
                    </smp:ServiceEndpointList>
                </smp:Process>
            </smp:ProcessList>
        </smp:ServiceInformation>
    </smp:ServiceMetadata>
    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
        <SignedInfo>
            <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
            <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
            <Reference URI="">
                <Transforms>
                    <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                <DigestValue>GW1PW/2NgXM7wzox5Ri6IQzjfzU=</DigestValue>
            </Reference>
        </SignedInfo>
        <SignatureValue>Thl63aHhhngk+7kG3MER0zWIxpcWuocX7pLMaZcUzdorSNg565qWlhOsbc/lvfdQBkem8gMduqtp&#13;
yKdwSv7qhsbz3OYSxY1XKabafE0zWgzkQ2v9N4c7oYXomo12JJxl2lXmz5kqlym0iaPvjgqZKueb&#13;
At18YHNuxHlXLhBTgtv5qLAkRkjfrNaK3njUpRHRX9OG6eAlShfipzaDvyvSFlFSUhjUq6fPwCEL&#13;
2yOex7hrfd2iHz6wrn+TvgxCo8JwC3d13zTvynz0n3nup5PES3tijPobl/zP9gESv2P8cK0TVswr&#13;
IKVEu7b1x04d8k73G9ideQUvXTt+vCr9HfhbrA==</SignatureValue>
        <KeyInfo>
            <X509Data>
                <X509SubjectName>CN=POP000306,OU=PEPPOL TEST SMP,O=Philip Helger IT Consulting e.U.,C=AT</X509SubjectName>
                <X509Certificate>MIIF5zCCA8+gAwIBAgIQbxyuoR5hHMDw6ICQWDVwsjANBgkqhkiG9w0BAQsFADB5MQswCQYDVQQG&#13;
EwJCRTEZMBcGA1UEChMQT3BlblBFUFBPTCBBSVNCTDEWMBQGA1UECxMNRk9SIFRFU1QgT05MWTE3&#13;
MDUGA1UEAxMuUEVQUE9MIFNFUlZJQ0UgTUVUQURBVEEgUFVCTElTSEVSIFRFU1QgQ0EgLSBHMjAe&#13;
Fw0yMTA1MjQwMDAwMDBaFw0yMzA1MTQyMzU5NTlaMGYxCzAJBgNVBAYTAkFUMSkwJwYDVQQKDCBQ&#13;
aGlsaXAgSGVsZ2VyIElUIENvbnN1bHRpbmcgZS5VLjEYMBYGA1UECwwPUEVQUE9MIFRFU1QgU01Q&#13;
MRIwEAYDVQQDDAlQT1AwMDAzMDYwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCww64p&#13;
jQWX7QBvz4nUKmlqXotiRrLlkQDgSE4CkzF2enu/giFb/lQ9pxQF9em9u4hjuPYXdsEhJFtuEcle&#13;
B7iJoXUuvLDH4rLhd4LwafcXyq/kL3r3p7txLJCMEsEMaWLmkgWr14u8OsFTRSsA/Pt8x3UXriBE&#13;
J75qnYnSjSHOrU+uEA+9kNJdErwhtuGzWi2+/oXHjVUSGxBDkXaPNCV876VFd0dhUtlUjsGgVeZT&#13;
Jiro5Cng4e+5DL1abqzmTyvO8BdQJg8AUiUiBEndOPXZ4/KaKroA647ut+NOWh4n0vF2aRoHcWPF&#13;
wl9s+ZuChswgYMmdywv/YO4TN9lZfBmTAgMBAAGjggF8MIIBeDAMBgNVHRMBAf8EAjAAMA4GA1Ud&#13;
DwEB/wQEAwIDqDAWBgNVHSUBAf8EDDAKBggrBgEFBQcDAjAdBgNVHQ4EFgQUt9LMpwRWVjJIYg7g&#13;
euFNhZasYzwwXQYDVR0fBFYwVDBSoFCgToZMaHR0cDovL3BraS1jcmwuc3ltYXV0aC5jb20vY2Ff&#13;
YjZkMGRjMWRjMzE0NzcyM2ZlMzZiNzU3NTk5N2FmYzQvTGF0ZXN0Q1JMLmNybDA3BggrBgEFBQcB&#13;
AQQrMCkwJwYIKwYBBQUHMAGGG2h0dHA6Ly9wa2ktb2NzcC5zeW1hdXRoLmNvbTAfBgNVHSMEGDAW&#13;
gBR8HbJI8brZCgbKFmOp8HpPvSOdezAtBgpghkgBhvhFARADBB8wHQYTYIZIAYb4RQEQAQIDAQGB&#13;
qNWBChYGOTU3NjA4MDkGCmCGSAGG+EUBEAUEKzApAgEAFiRhSFIwY0hNNkx5OXdhMmt0Y21FdWMz&#13;
bHRZWFYwYUM1amIyMD0wDQYJKoZIhvcNAQELBQADggIBAA0pHdLD2S/DynBDRM0j+kAsDtsyfeje&#13;
8AUQcNLkEZ1WB0YuQmCfcKqj90EkIGLGfjqA+U7ue/LjcJwb4vLBOAY1WlkrrfdBpWD2taliRkNr&#13;
CY9X0+rYIRqcSf+PGz2krVXeU1R9O+lFiawHqubc6wwAGdcLgVYbmsFwSS08I4I0mqjrA1pAmzxA&#13;
tKEjXjUDN827W2CPNual5ctnyXiI+ECrJyk+flXj88d0tloVEmBDd8aUM5he2Sl1sk1ZSmmitMmx&#13;
3DjpGO+cP1jVy+gU94cIH6jhimJVafmKf1kYk6UslNCeCMAf5vWWRN4gfTOhOGveLz1J4wv2LIv7&#13;
0GEHInCLEQ/wBit8aSmuyKRkULRq46nSvA8LsLf0kZlLIa9o7fftuuJu+ZYg/bXzU7e0hc5Vmnir&#13;
tVdgAaMQPKnmeOY8R+gNBHXnFsSAibLLnxPMmeMKzpcE2V81voF4jLqLBZ0WTYuBUT5bkciAu7oh&#13;
19XdOmjcTxgib0ixJAph1Itm25oZkW3hoJHY/eGDTNZkTax9df8y+GteTr+bUSi8VNC7UiF87Zsp&#13;
JhBwiJzo45K7fkNpmP2VzfEuMc+BErKgyGXuK/jpPm7iS48RHZgxCtR4HatKbvSzkko4dejC+/cz&#13;
6IaEZgvhHyu6UyQn3naZ17ss26W3wngt5+SMcCyNWgtS</X509Certificate>
            </X509Data>
        </KeyInfo>
    </Signature>
</smp:SignedServiceMetadata>
```

### Caution
The SMP response may contain a redirect instruction. You can find it in Phase4 class `com.helger.smpclient.peppol.SMPClientReadOnly` method `getServiceMetadata` where it says `getServiceMetadata().getRedirect()`.
