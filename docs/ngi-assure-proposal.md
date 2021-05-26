https://nlnet.nl/propose/

# Basics
* Thematic call: NGI Assure
* Your name: Michiel de Jong
* Email address: michiel@pondersource.com
* Phone numbers: ...
* Organisation: Stichting Ponder Source
* Country: The Netherlands
* Project name: "Peppol to the People!" - self-hosted e-invoicing with decentralized identities
* Website / wiki: https://github.com/pondersource/peppol-python

# Abstract: Can you explain the whole project and its expected outcome(s).
Every organisation has a bookkeeping system, and it always contains sensitive data about both business and humans. The market for bookkeeping software is dominated by large commercial players who build silos, and especially when sending invoices, there is a large risk of closed networks and data extraction by intermediates.

We propose an open source implementation of the popular EU-backed Peppol standard, integrated directly with popular open source bookkeeping systems, and extended to allow participants self-host their public key information.

Just like home internet users need to use an Internet Service Provider to get onto the main global tcp/ip network that we call internet, bookkeeping systems need to go through a certified Peppol gateway server to get onto the main global Peppol network. The sending gateway certifies the identity of the sender (looking at their legal entity in the country where they are registered) by signing the invoice as it passes through. The receiving gateway checks the sending gateway's signature before delivering it to the final recipient. This is called the four-corner model (sender -> sending gateway -> receiving gateway -> recipient).

Peppol is a great solution, except if the sender/receiver may not able or willing to pay the significant monthly fee for the services of a Peppol gateway service, may not want a gateway to proxy (i.e. potentially read and potentially edit) their outgoing/incoming invoices, or may not be a legal entity (e.g. is a human being, or an unregistered group of people).

We aim to fix this by:
* implementing AS4 in Python (see https://peppol.eu/downloads/peppolimplementations/ for the existing Java/CS#-based ones)
* plugging this functionality straight into existing open source bookkeeping systems (in particular Odoo and ERPNext, which are both in Python)
* adding a public key discovery scheme which allows users to self-host their identity on their own domain name.

# Have you been involved with projects or organisations relevant to this project before? And if so, can you tell us a bit about your contributions?
Yes. I (Michiel de Jong) recently founded Stichting Ponder Source which is a non-profit startup aimed at open source software development and promoting open protocols in the world of bookkeeping. We now have two employees (Triantafullenia Doumani and myself).

Triantafullenia is an exceptionally bright, fast learning, and talented software engineer who is finalizing a Master's Degree in Computer Science, and who is permanently relocating from Greece to Utrecht to work on this project.

I also recently founded the Federated Bookkeeping community which ties together related projects in credit network protocols, e-invoicing protocols, and everything in between, and which is now regularly active in https://gitter.im/federatedbookkeeping/community chat and a weekly videocall with usually 4 or 5 attendees so far.

Regarding fintech and decentralized finance, in the past, I worked on credit network protocols as the inventor of LedgerLoops, as an employee at Ripple, in the Interledger team, and more recently working on Web Monetization as a Grant for the Web grantee.

Regarding personal data on the web, in 2010 I founded the Unhosted project which received numerous NLNet grants over the years, worked on Firefox OS at Mozilla, and I am now an active member of the Solid project alongside Sir Tim Berners-Lee, including the recent NLNet-funded Solid-Nextcloud integration. I also co-founded the "Terms of Service; Didn't Read" project which received wide-spread coverage in the mainstream press.

I wrote the test suite for both Solid and Open Cloud Mesh, and Stichting Ponder Source is now a sub-contractor of the ScienceMesh project, where we implement the new EU-funded CS3 protocol in Nextcloud.

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
5. Proof-of-Concept of CRDT-based collaborative invoice composition (joint with George Svarovsky's "Securing Shared Decentralised Live Information with m-ld" project, which was already funded through NGI-Assure). This part will be done in JavaScript as a stand-alone piece of code, since it's only a proof-of-concept, and m-ld is not available in Python yet.

# Does the project have other funding sources, both past and present?
# (If you want, you can in addition attach a budget at the bottom of the form)

Stichting Ponder Source was only just created and this will be one of our two launching projects, so in this early phase we heavily rely on outside funding to bootstrap our existence.

In the future we plan to monetize this software project, which will be part of our business model. One option would be running a Peppol gateway ourselves, with reseller agreements, another would be software consultancy (but always keeping the entire code base open source, so no "enterprise edition").

Milestone 5 would be a collaboration with the M-ld project, but they are not funding us, nor are we funding them.

# Compare your own project with existing or historical efforts.
We reached out to all Python-based open source Peppol implementations we could find, and found that Odoo supports the XML-based message format UBL in general, but not Peppol-Billing 3.0 in particular, and also not the transport protocol AS4. There is an open source implementation of Peppol-Billing 3.0 in Python and we spoke to the author; he agreed to open source it but said it was an ad-hoc patch inside a one-off project, and would not be very useful to us beyond serving as an inspiration.

See https://github.com/pondersource/peppol-python/issues/7 for more info.

# What are significant technical challenges you expect to solve during the project, if any?
Although the documentation of Peppol AS4 (the transport protocol) and Peppol Billing (the data format) is quite length and spread with cross-references between peppol.eu and OASIS specs that it is based on, we can use existing implementations and test suites to guide us, if we take it step-by-step, doing only core functionality first and then expanding incrementally, it should be doable.
The XML, the SOAP calls, and the PKI certificates and signatures are all non-trivial tasks to develop, but we feel we have the right team in place to work through it.
Peppol is based on Java-oriented protocols like XML and SOAP. Although we have already checked that there are sufficient building blocks available in Python through pip/PyPI, the IDE tooling around things like XSD will not be as good in Python as it would be in a Java-oriented IDE.
The UBL syntax of a Peppol invoice is quite verbose, and it will probably be a lot of work to implement that from scratch in Python. We'll start with a subset and then expand.

Regarding our innovative addition to the Peppol protocol stack, namely self-hosted identities, we think we have a pretty good idea of how to build this, and ample experience in building similar constructs in the past. For instance, if you receive an invoice which purports to be from https://sender.com/#peppol, you would retrieve that URL as a public JSON-LD document, extract the public key information, and check the signature on the invoice. If your addressbook shows you already do business with the company whose website is https://sender.com then you know you have a reason to trust this sender, even though both sender and receiver avoided the need for access to the official EU-based Peppol network.

Regarding milestone 5, we already discussed with George Svarovsky that it would probably be a mistake to try to do this in Python at the first try, and better to do it in JavaScript first, where we have m-ld available. This part of the project is more experimental than the other parts, and may fail if we run into fundamental obstacles to applying CRDTs in a Federated Bookkeeping use case. In this case, we will find a way to work around the limitation and document why our original design didn't work out as expected. At the same time, our project of collaborative invoice composition will serve as a use-case study and beta-user of George's NLNet-funded project.

# Describe the ecosystem of the project, and how you will engage with relevant actors and promote the outcomes?
Most importantly, we will submit our open source Peppol implementation to https://peppol.eu/downloads/peppolimplementations/ as the sixth entry in the official list there. This will give our project, as well as Ponder Source as a new startup, important visibility within the Peppol community.
We also have some open business development conversations with potential resellers of a hosted instance of our Peppol implementation.
As a follow-up project, will complete the integration with Odoo's internal data formats, package our code as an Odoo app, and submit it to https://apps.odoo.com/apps.
We also aim to submit it to ERPNext.
We actively collaborate with George Svarovsky from https://nlnet.nl/project/m-ld/.
Stichting Ponder Source is an active driver of the Federated Bookkeeping community, and we will disseminate our work through our website and when speaking at conferences.
