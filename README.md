# peppol-php

[![Join the chat at https://gitter.im/pondersource/peppol-php](https://badges.gitter.im/pondersource/peppol-php.svg)](https://gitter.im/pondersource/peppol-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

*** UNDER CONSTRUCTION ***

An implementation of Peppol in PHP

## Peppol for the masses!

### Summary
Peppol is an EU-backed e-Invoicing network which uses a top-down certification infrastructure to establish trust between the sender and the receiver of an invoice.
In the "Peppol for the Masses!" project, we will implement Peppol in PHP (so far only Java and C# implementations are available), and package its core components (the AS4 sender and the AS4 receiver) as a Nextcloud app, so that users of the popular Nextcloud personal cloud server can send and receive invoices over AS4 directly into their self-hosted server.
Due to the top-down nature of Peppol's trust infrastructure, it's not possible to self-host a node in the Peppol network unless you go through a reasonably heavy certification process. Therefore, we will extend our implementation with support for self-hosted identities, using the "WebID" identity pattern which was popularized by the Solid project. We will also develop a re-signing gateway which replaces the signature on an AS4-Direct invoice with a Peppol-certified signature. In a follow-up project, we will also host an instance of this re-signing gateway and make it available free of charge, similar to how the LetsEncrypt project has made TLS certificates available free of charge.
This project will lower the (cost) barrier for machine-readable cryptographically-signed e-Invoicing messages, and at the same time increase the sovereignty of end-users, towards a human-centric internet of business documents.

### How it works
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
# 1. Trust User Interface for both sender and receiver

  ### Network of Trust
  
  * Users can create a Network of Trust 
    - How?  By sending and receiving contact requests
  * Each contact can be:
    - Supplier
    - Costumer
    - Simple contact 

 ### Messages
 
 * Users can exchange messages
 * Each message can be:
   - Invoice
   - Purchase Prder
   - Simple message
 * Each message includes:
   - Receipient: From the contact list or by entering a WebID/ PeppolID address  
   - Subject   : The subject of the message
   - Body      : Simple Text 
   - XML file  : Uploload Invoice or Purchase order (if required) 
   - Type      : The type of the message ( Invoice/ Purchase order/ Simple message) to inform the receipient 
   - Shipping method: Through Peppol classic or AS4  
 * Recipient can clearly see the credentials of the sender
   - Self-hosted or gateway-certified
   - Backed by a government's company registry or not
 
  ### Send a new message out the Network of Trust 
  
  #### Invoice
   * The Receipient will be asked if he trust the Sender as a supplier or not
     - ACCEPT : Sender marked as a supplier and added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 

  #### Purchase Order
   * The Receipient will be asked if he trust the Sender as a costumer or not
     - ACCEPT : Sender marked as a costumer and added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 
  
  #### Simple Message
  * The Receipient will just receive a new contact request
     - ACCEPT : Sender added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 
  
  ### UI
  
  * Custom icons exists for each terminology
  * Q&A
  
# 2. Hybrid sender, including:
  * AS4 client (based on generic SOAP client library)
  * Recipient details discovery (Peppol ID directory lookup)
  * Passing the official AS4 compliance tests for sending
  * Option to send to self-hosted non-Peppol recipient identities

# 3. Hybrid receiver, including:
  * AS4 server (based on generic SOAP server library)
  * Service Metadata Publisher, to announce the endpoint details for a Peppol ID.
  * Passing the official AS4 compliance tests for receiving
  * Option to receive from self-hosted non-Peppol sender identities
  * Sender identity / signature verification for Peppol ID's and self-hosted ID's

# 4. Re-signing gateway
  * forwards an invoice from a whitelisted sender, replacing the sender signature with a sending-gateway signature, thus making the invoice Peppol-compliant if the sending gateway's cryptographic key pair is officially certified.
  * Know-Your-Customer implementation, showing ability to check sender identity against two or three different national company registries.
  * re-signs and forwards SMP registrations on behalf of whitelisted receivers.

# 5. Nextcloud integration
  * the leading open source self-hostable personal cloud system Nextcloud does not yet support sending and receiving them via Peppol's SOAP-based AS4 protocol.
  * we will package the sender and the receiver modules as a Nextcloud app, directly installable for existing Nextcloud self-hosters from the Nextcloud app store.
  * demo the integration and the full sender-to-receiver flow in a screencast.

