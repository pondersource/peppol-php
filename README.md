# peppol-python

[![Join the chat at https://gitter.im/pondersource/peppol-python](https://badges.gitter.im/pondersource/peppol-python.svg)](https://gitter.im/pondersource/peppol-python?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

*** UNDER CONSTRUCTION ***

An implementation of Peppol in Python

## Peppol for the masses!
The popular EU-backed e-invoicing network "Peppol" requires both the sender and the receiver to connect through a licensed gateway.

This has obvious drawbacks:
* only registered legal entities from the 39 participating governments can currently benefit from Peppol
* identity management is top-down and in the hands of the certified gateways
* these gateways often charge hundreds of euros per month for a connection
* they can see and alter the unencrypted contents of all your incoming and outgoing invoices

We propose a hybrid system, implementing all of standard Peppol, but additionally supporting self-hosted identities. If the sender and/or the receiver is a standard Peppol node, Peppol will be used as usual:

sender (c1) -> sendingGateway (c2) -> receivingGateway (c3) -> receiver (c4)

But if both the sender and the receiver are hybrid nodes, and the invoice sender is a trusted supplier of the receiver, the invoice can be sent directly over end-to-end encrypted https:

sender (c1) -(https)-> receiver (c4)

Our implementation will allow both the sender and the receiver to publish their identity at a well-known URL, under the company domain names as linked in the XML invoice.

## The Milestones
1. Trust User Interface for both sender and receiver
  * sender can safely pick a recipient from a list of known and verified contacts
  * if relaying through a gateway was necessary (e.g. the recipient has no self-hosted verifiable identity), these will be clearly indicated to both sender and receiver
  * invoices from non-trusted senders will be marked as spam and hidden from the inbox
  * in the inbox, recipient can clearly see the credentials of the sender
    - self-hosted or gateway-certified
    - backed by a government's company registry or not

2. Hybrid sender, including:
  * AS4 client (based on generic SOAP client library)
  * Recipient details discovery (Peppol ID directory lookup)
  * Passing the official AS4 compliance tests for sending
  * Option to send to self-hosted non-Peppol recipient identities

3. Hybrid receiver, including:
  * AS4 server (based on generic SOAP server library)
  * Service Metadata Publisher, to announce the endpoint details for a Peppol ID.
  * Passing the official AS4 compliance tests for receiving
  * Option to receive from self-hosted non-Peppol sender identities
  * Sender identity / signature verification for Peppol ID's and self-hosted ID's

4. Re-signing gateway
  * forwards an invoice from a whitelisted sender, replacing the sender signature with a sending-gateway signature, thus making the invoice Peppol-compliant if the sending gateway's cryptographic key pair is officially certified.
  * Know-Your-Customer implementation, showing ability to check sender identity against two or three different national company registries.
  * re-signs and forwards SMP registrations on behalf of whitelisted receivers.

5. Odoo integration
  * the leading open source self-hostable bookkeeping system Odoo already supports composing and parsing machine-readable UBL (Peppol-like) invoices, but it does not yet support sending and receiving them via Peppol's SOAP-based AS4 protocol.
  * we will package the sender and the receiver modules as Odoo modules, directly installable for existing Odoo self-hosters from the Odoo app store.
  * demo the integration and the full sender-to-receiver flow in a screencast.

