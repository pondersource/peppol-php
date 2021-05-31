https://nlnet.nl/propose/
Submitted: 13:40 on 31 May
Code assigned: 2021-06-065

# Basics
* Thematic call: NGI Assure
* Your name: Michiel de Jong
* Email address: michiel@pondersource.com
* Phone numbers: ...
* Organisation: Stichting Ponder Source
* Country: The Netherlands
* Project name: "Peppol for the masses!" - hybrid self-hosted e-invoicing with decentralized identities
* Website / wiki: https://github.com/pondersource/peppol-python

# Abstract: Can you explain the whole project and its expected outcome(s).
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

# Have you been involved with projects or organisations relevant to this project before? And if so, can you tell us a bit about your contributions?
Yes. I (Michiel de Jong) recently founded Stichting Ponder Source which is a non-profit startup aimed at open source software development and promoting open protocols in the world of bookkeeping. We now have two employees (Triantafullenia Doumani and myself).

I also recently founded the Federated Bookkeeping community which ties together related projects in credit network protocols, e-invoicing protocols, and everything in between, and which is now regularly active in the https://gitter.im/federatedbookkeeping/community chat, with a weekly videocall of usually 4 or 5 attendees so far.

Regarding fintech and decentralized finance, in the past, I worked on credit network protocols as the inventor of LedgerLoops, as an employee at Ripple, in the Interledger team, and more recently working on Web Monetization as a Grant for the Web grantee.

Regarding personal data on the web, in 2010 I founded the Unhosted project which received numerous NLNet and other grants over the years, worked on Firefox OS at Mozilla, and I am now an active member of the Solid project alongside Sir Tim Berners-Lee, including the recent NLNet-funded Solid-Nextcloud integration. I also co-founded the "Terms of Service; Didn't Read" project which received wide-spread coverage in the mainstream press.

I wrote the test suite for both Solid and Open Cloud Mesh, and Stichting Ponder Source is now a sub-contractor of the ScienceMesh project, where we implement the new EU-funded CS3 protocol in Nextcloud.

I am an advisory board member for NGI-DAPSI and recently gave a keynote speech about Federated Bookkeeping at Surf Research Week.

Triantafullenia is an exceptionally bright, fast learning, and talented software engineer who is finalizing a Master's Degree in Computer Science, and who is permanently relocating from Greece to Utrecht to work on this project.

# Requested Amount
50000

# Explain what the requested budget will be used for?
48000 euros on salaries (10 months from Triantafullenia and 3 months from Michiel).
2000 euros on other expenses like hosting, travel, office space, laptops, etc.
Five milestones:
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

# Does the project have other funding sources, both past and present?
# (If you want, you can in addition attach a budget at the bottom of the form)

Stichting Ponder Source is a young earn-to-give startup that was only just created, and "Peppol for the masses!" will be one of our two launching projects (the other one being our participation in the prestigious Sciencemesh project), so in this early phase we heavily rely on outside funding to bootstrap our existence.

Although the result of this project will be completely open source, well documented, and free to use, in the future we plan to monetize this software project, which will be part of our business model. One option would be running a Peppol gateway ourselves, with reseller agreements, another would be software consultancy (but always keeping the entire code base open source, so no closed-source "enterprise edition" features).

All the profit Stichting Ponder Source makes will be either spent on more in-house research around Federated Bookkeeping, or donated to other open source projects.

# Compare your own project with existing or historical efforts.
We reached out to all Python-based open source Peppol implementations we could find, and found that Odoo supports the XML-based message format UBL in general, but not Peppol-Billing 3.0 in particular, and also not the transport protocol AS4. There is an open source implementation of Peppol-Billing 3.0 in Python and we spoke to the author; he agreed to add an open source license to the code which is already on github, but said it was an ad-hoc patch inside a one-off project, and would not be very useful to us beyond serving as an inspiration.

See https://github.com/pondersource/peppol-python/issues/7 for more info.

# What are significant technical challenges you expect to solve during the project, if any?
Although open source implementations of Peppol exist in Java and C#, we will implement it in Python so that it can be either run stand-alone, or integrated into Odoo and ERPNext, which nowadays are two of the three leading open source self-hostable bookkeeping systems.

Although the documentation of Peppol AS4 (the transport protocol) and Peppol Billing (the data format) is quite lengthy and spread with cross-references between peppol.eu and OASIS specs that it is based on, we can use existing implementations and test suites to guide us, and if we take it step-by-step, doing only core functionality first and then expanding incrementally, it should be doable.

The XML, the SOAP calls, and the PKI certificates and signatures are all non-trivial tasks to develop, but we feel we have the right team in place to work through it.

Peppol is based on Java-oriented protocols like XML and SOAP. Although we have already checked that there are sufficient building blocks available in Python through pip/PyPI, the IDE tooling around things like XSD will not be as good in Python as it would be in a Java-oriented IDE.

The UBL syntax of a Peppol invoice is quite verbose, and it will probably be a lot of work to implement that from scratch in Python. We'll start with a subset, based on what UBL functionality we can find in the Odoo and ERPNext open source communities, and then expand.

Regarding our innovative addition to the Peppol protocol stack, namely self-hosted identities, we think we have a pretty good idea of how to build this, and ample experience in building similar constructs in the past. For instance, if you receive an invoice which purports to be from https://sender.com/#peppol, you would retrieve that URL as a public JSON-LD document, extract the public key information, and check the signature on the invoice. If your address book shows you already do business with the company whose website is https://sender.com then you know you have a reason to trust this sender, even though both sender and receiver avoided the need for access to the official EU-based Peppol network. This the same mechanism used in Solid WebID's and in W3C DID's.

For the implementation of the Know-Your-Customer system for the re-signing gateway, we will look at the well-documented acme challenge protocols that were developed by the LetsEncrypt project, who disrupted the world of TLS certificates in much the same way as we intend to disrupt the world of e-invoicing now.

# Describe the ecosystem of the project, and how you will engage with relevant actors and promote the outcomes?
Most importantly, we will submit our open source Peppol implementation to https://peppol.eu/downloads/peppolimplementations/ as the sixth entry in the official list there. This will give our project, as well as Stichting Ponder Source as a new startup, important visibility within the world of Peppol.

We also have some open business development conversations with potential resellers of a hosted instance of our Peppol implementation.

The presence in the Odoo app store will give us visibility to existing Odoo self-hosters.

We also aim to submit it to ERPNext at a later stage, but their code eco-system seems to be more centralized than the Odoo eco-system (no concept of apps/plugins, apparently), so we probably rely on the acceptance of upstream pull request into their main codebase there.

Stichting Ponder Source is an active driver of the Federated Bookkeeping community, and we will disseminate our work through our website and when speaking at conferences.

On the one hand, we will speak about the vision of Federated Bookkeeping at open source conferences in the "hacker" world of decentralized identity and trust.

On the other hand, we will promote the benefits of open source self-hostable software at Peppol-related networking events in the "white collar" world of bookkeeping software.

Combining these, we passionately believe this project stands at the beginning of a beautiful revolution of how open source software empowers a more open business economy, where each organisation's (self-hosted) bookkeeping system can be "connected, but sovereign".