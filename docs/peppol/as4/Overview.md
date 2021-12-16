# AS4
## What is AS4?

Applicability Statement 4 (more commonly known as AS4) is a communication protocol that is used for B2B and B2G document exchange. 
AS4 was developed for ebXML messaging services by OASIS (the Organisation for the Advancement of Structured Information Standards). It is based on SOAP/WSDL and uses HTTP as its communication protocol. As AS4 utilises the HTTP protocol, document exchange can be secured via Transport Layer Security (TLS). In the context of Peppol the exchange format of choice will remain the well established and accepted UBL (Universal Business Language) format.

<img src="https://github.com/pondersource/peppol-php/blob/as4-testing-1/docs/pics/test.png?raw=true"/>

## Why is Peppol requiring AS4 compliance?

OpenPEPPOL took the decision to mandate the shift to AS4 in order to be better aligned with international requirements. The European Commision is generally in favor of using AS4 as well as the governments of Australia and New Zealand. Since AS4 is also a well renowned OASIS standard and provides a high level of flexibility, it was chosen in favor of AS2.
<img src="https://github.com/pondersource/peppol-php/blob/as4-testing-1/docs/pics/as4-profile.png?raw=true"/>

* [What is AS4?](https://ecosio.com/en/blog/peppol-access-points-now-required-to-be-as4-compliant)
* [AS4 migration Webinar](https://www.youtube.com/watch?v=hO4r_778Ebo&t=620s)
* [PEPPOL AS4 Profile](https://docs.peppol.eu/edelivery/as4/specification/)
* [OASIS ebXML Messaging Services](http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/core/ebms_core-3.0-spec.pdf)
* [Setup Peppol AP](https://peppol.helger.com/public/menuitem-docs-setup-ap)
* [AS4 Acceptance Test](https://peppol.eu/wp-content/uploads/2018/12/PEPPOL-Testbed-and-Onboarding_v1p2.pdf)
