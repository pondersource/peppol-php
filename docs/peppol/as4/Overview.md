# AS4
## What is AS4?

Applicability Statement 4 (more commonly known as AS4) is a communication protocol that is used for B2B and B2G document exchange. 
AS4 was developed for ebXML messaging services by OASIS (the Organisation for the Advancement of Structured Information Standards). It is based on SOAP/WSDL and uses HTTP as its communication protocol. As AS4 utilises the HTTP protocol, document exchange can be secured via Transport Layer Security (TLS). In the context of Peppol the exchange format of choice will remain the well established and accepted UBL (Universal Business Language) format.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/test.png?raw=true"/>

## Why is Peppol requiring AS4 compliance?

OpenPEPPOL took the decision to mandate the shift to AS4 in order to be better aligned with international requirements. The European Commision is generally in favor of using AS4 as well as the governments of Australia and New Zealand. Since AS4 is also a well renowned OASIS standard and provides a high level of flexibility, it was chosen in favor of AS2.
<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/as4-profile.png?raw=true"/>

## AS4 technical specification(Message Structure and UserMessage)

AS4 offers a secure exchange protocol for use over the Internet that leverages the MIME envelope structure to transport arbitrary payloads. Support for Message Security is provided by AS4 via ebMS 3.0 and the WS-Security 1.1 and 1.1.1. specifications. This includes combinations of XML Digital Signature and XML Encryption X.509 security tokens for signing and encrypting as primary means for authenticating messages, ensuring privacy, and guaranteeing safe data transmission. Additionally, AS4 supports the use username/password tokens as access control to message pull channels.
The AS4 Message Structure  provides a standard message header that addresses common data exchange requirements and offers a flexible packaging mechanism based on SOAP and MIME enveloping. Dashed line style is used for optional message components.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/user.png?raw=true"/>

## Messaging Model

The Messaging Model of the AS4 profile constrains the channel bindings of message exchanges between two AS4 MSHs. The following diagram shows the AS4 Messaging Model, various actors and operations in message exchange.
Business applications or middleware, acting as Producer, Submit message content and metadata to the Sending MSH, which packages this content and Sends it to the Receiving MSH of the business partner, which Receives it and in turn Delivers the message to another business application or middleware that Consumes the message

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/message.png?raw=true"/>

## The One-Way/Push MEP

The One-Way/Push MEP specifies a situation when a Sending MSH which has agreed to use the One-Way/Push MEP sends a message to a Receiving MSH which has agreed to use One-Way/Push MEP as well. After the successful reception of the message, the receiving MSH returns a non-user message (i.e. a signal message) to the sending MSH to confirm the reception. Different user messages do not have any reference to each other, except possibly if they are part of the same conversation.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/as4_push.png?raw=true"/>

* [What is AS4?](https://ecosio.com/en/blog/peppol-access-points-now-required-to-be-as4-compliant)
* [AS4 migration Webinar](https://www.youtube.com/watch?v=hO4r_778Ebo&t=620s)
* [PEPPOL AS4 Profile](https://docs.peppol.eu/edelivery/as4/specification/)
* [OASIS ebXML Messaging Services](http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/core/ebms_core-3.0-spec.pdf)
* [Setup Peppol AP](https://peppol.helger.com/public/menuitem-docs-setup-ap)
* [AS4 Acceptance Test](https://peppol.eu/wp-content/uploads/2018/12/PEPPOL-Testbed-and-Onboarding_v1p2.pdf)
