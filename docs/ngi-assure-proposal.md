https://nlnet.nl/propose/

# Basics
* Thematic call: NGI Assure
* Your name: Michiel de Jong
* Email address: michiel@pondersource.com
* Phone numbers: ...
* Organisation: Stichting Ponder Source
* Country: The Netherlands
* Project name: Self-hosted e-invoicing with decentralized identities
* Website / wiki: https://github.com/pondersource/peppol-python

# Abstract: Can you explain the whole project and its expected outcome(s).
In Federated Bookkeeping, we use the internet and open protocols to interconnect (open source) bookkeeping systems. The need for Federated Bookkeeping is enormous, since everybody needs a bookkeeping system, and at the same time it's very privacy-sensitive for especially one-person businesses, it involves business secrets for almost everyone, and there is a large risk risk of dominant players who want to extract data.

To make Federated Bookkeeping a reality, we propose an open source implementation of the popular EU-backed Peppol standard, integrated directly with popular open source bookkeeping systems, and extended to allow participants self-host their public key information.

Peppol is a new successful e-Invoicing network, driven by the EU to unite government procurement processes. It can be used to send purchase orders and invoices from any legal person to any other legal person in any of the participating countries.

Peppol uses a four-corner model, where every document sent goes from the sender (1) via the sending gateway (2) to the receiving gateway (3) to the recipient (4). This is similar to how home internet works: your home router is not directly connected to the internet, your ISP acts as your gateway. Both the sender and the receiver are at arm's length from the core network, via an access point service. This service validates and vouches for the identity of all senders and receivers.

For many electronic invoices, both the sender and the recipient are legal entities in a European country. With a little bit of effort, and sometimes even zero cost, a legal entity can obtain a Peppol ID at one of the many existing Peppol gateways. The sender can then pay their gateway to relay outgoing invoices from them, and the recipient can pay their gateway to relay incoming invoices to them. Often, both the sending gateway service and the receiving gateway service, come as part of a package deal for those who use SaaS closed-source bookkeeping software providers.

For legal entities that use open-source bookkeeping software (Odoo, Dolibarr, ERPNext), it is usually a bit harder but still not impossible to send and receive invoices via Peppol: they can set up an SMTP connection or a custom webhook between their bookkeeping system and a commercial Peppol gateway service like StoreCove or one of the many others. This would probably require them to pay a monthly subscription fee, which can be hundreds of euros per month, and most gateways only operate in some specific countries, so there are some hurdles, but it's technically feasible today.

What is not possible today is to send and receive Peppol-compatible invoices where the sender and/or the receiver:
* is not able or willing to pay the significant monthly fee for the services of a Peppol gateway service
* does not want a gateway to proxy (i.e. potentially read and potentially edit) their outgoing/incoming invoices, or
* is not a legal entity (e.g. is a human being, or an unregistered group of people)

We aim to fix this by:
* implementing AS4 in Python (see https://peppol.eu/downloads/peppolimplementations/ for the existing Java/CS#-based ones)
* plugging this functionality straight into existing open source bookkeeping systems (in particular Odoo and ERPNext, which are both in Python)
* adding a public key discovery scheme which allows users to self-host their identity on their own domain name.

In order to increase the impact of e-Invoicing on humanity, we want to enable direct sender-to-receiver document sending as well as the gateway-verified path. In this case, the receiver will not be able to rely on identity verification by a sending gateway, nor on the signature checking carried out by the receiving gateway, so the sender needs to publish their own public key information (for instance using WebID or other established https-based mechanisms), and the receiver needs to discover the sender's public key from the addressbook entry they have.

For instance, if you receive an invoice which purports to be from https://sender.com/#peppol, you would retrieve that URL as a public JSON-LD document, extract the public key information, and check the signature on the invoice. If your addressbook shows you already do business with the company whose website is https://sender.com then you know you have a reason to trust this sender, even though both sender and receiver avoided the need for access to the official EU-based Peppol network.

We looked at the landscape of open source bookkeeping systems (https://github.com/federatedbookkeeping/research/blob/main/open-source-erp.md#accounting-and-erp), measuring their activity by number of unique monthly code contributors on GitHub. The top three is Odoo (Python), Dolibarr (PHP), ERPNext (Python).

There are four open source implementations of Peppol's current AS4 transport protocol in Java, and one in C#.

# Have you been involved with projects or organisations relevant to this project before? And if so, can you tell us a bit about your contributions?
Yes. I recently founded Stichting Ponder Source which is a non-profit startup aimed at open source software development and promoting open protocols in the world of bookkeeping. We now have two employees (Triantafullenia Doumani and myself).

Triantafullenia is an exceptionally bright, fast learning, and talented software engineer who is finalizing a Master's Degree in Computer Science, and who is permanently relocating from Greece to Utrecht to work on this project.

I (Michiel de Jong) recently founded the Federated Bookkeeping community which ties together related projects in credit network protocols, e-invoicing protocols, and everything in between, and which now regularly active in https://gitter.im/federatedbookkeeping/community chat and a weekly videocall with usually 4 or 5 attendees so far.

Regarding fintech and decentralized finance, in the past, I worked on credit network protocols as the inventor of LedgerLoops, as an employee at Ripple, in the Interledger team, and more recently working on Web Monetization as a Grant for the Web grantee.

Regarding personal data on the web, in 2010 I founded the Unhosted project which received numerous NLNet grants over the years, worked on Firefox OS at Mozilla, and I am now an active member of the Solid project alongside Sir Tim Berners-Lee, including the recent NLNet-funded Solid-Nextcloud integration. I also co-founded the "Terms of Service; Didn't Read" project which received wide-spread coverage in the mainstream press.

I wrote the test suite for Open Cloud Mesh and Stichting Ponder Source is now a sub-contractor of the ScienceMesh project, where we implement the cs3 protocol in Nextcloud.

I am an advisory board member for NGI-DAPSI and recently gave a keynote speech about Federated Bookkeeping at Surf Research Week.

# Requested Amount
50000

# Explain what the requested budget will be used for?
Five milestones:
1. Sending gateway, including:
  * AS4 client (based on generic SOAP client library)
  * Recipient details discovery (Peppol ID directory lookup)
  * proxy that signs XML messages according to Peppol PKI and then forwards them on
  * Option to send to non-Peppol recipient identities (like Solid WebID's) through https://www.w3.org/TR/did-core/ 
2. Receiving gateway, including:
  * AS4 server (based on generic SOAP server library)
  * Service Metadata Publisher, to announce the endpoint details for a Peppol ID.
  * Sender identity / signature verification for Peppol ID's
  * Option to receive from non-Peppol sender identities (like Solid WebID's) through https://www.w3.org/TR/did-core/ 
3. Peppol-Invoice composer
  * based on existing code from https://github.com/OCA/edi 
4. Peppol-Invoice parser
  * based on existing code from https://github.com/OCA/edi 
5. Proof-of-Concept of CRDT-based collaborative invoice composition (joint with George Svarovsky's "Securing Shared Decentralised Live Information with m-ld" project, which was already funded through NGI-Assure).

# Does the project have other funding sources, both past and present?
# (If you want, you can in addition attach a budget at the bottom of the form)

Stichting Ponder Source was only just created and this will be one of our two launching projects, so in this early phase we heavily rely on outside funding to bootstrap our existence.

In the future we plan to monetize this software project, which will be part of our business model. One option would be running a Peppol gateway ourselves, with reseller agreements, another would be software consultancy (but always keeping the entire code base open source, so no "enterprise edition").

Milestone 5 would be a collaboration with the M-ld project, but they are not funding us, nor are we funding them.

# Compare your own project with existing or historical efforts.
We reached out to all Python-based open source Peppol implementations we could find, and found that Odoo supports the XML-based message format UBL in general, but not Peppol-Billing 3.0 in particular, and also not the transport protocol AS4. There is an open source implementation of Peppol-Billing 3.0 in Python and we spoke to the author; he agreed to open source it but said it was an ad-hoc patch inside a one-off project, and would not be very useful to us beyond serving as an inspiration.

See https://github.com/pondersource/peppol-python/issues/7 for more info.
