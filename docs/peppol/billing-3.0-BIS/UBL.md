# What is UBL?

## What is UBL?

The world of business is fueled by documents such as orders, invoices and waybills that are sent between trading partners such as buyers, sellers, shippers and warehouses. For many years, expensive Electronic Data Interchange (EDI) implementations on costly value-added networks have fulfilled the need to express such documents in a machine-processable form for software applications to act on the contents found therein. 

## Traditional paper-based document exchange 

When automated using software, the sender's application preparing the business document to be sent to the receiver frames the information around the content found in the sender's data model reflecting the sender's business practices. The information is typically then prepared in paper form, perhaps even electronically in paper form using PDF. This document insulates the sender from following or just even knowing about the receiver's business practices. The receiver of the document then needs somehow to convey that information into their application that has its own data model reflecting their business practices. This can be illustrated as follows.

<img src="https://github.com/pondersource/peppol-php/blob/ubl/docs/pics/ubl.png?raw=true"/>

## Document choreography, user data and transport 

Moving to the electronic interchange of information involves three aspects of the interaction between trading partners. The choreography of exchanges (if any) needs to be agreed upon, the structure and use of the documents within each choreography must be unambiguously processable, and the platforms on which each party runs their software must be able to communicate with each other.
For a document format, the OASIS Universal Business Language (UBL) is an open and royalty-free library of standard XML business document types. UBL is made freely available to download without any registration or cost, for users to cherry-pick which constructs are going to convey which business information is needed to be exchanged. Validation tools are included to automate the checking of content against the document constraints.

<img src="https://github.com/pondersource/peppol-php/blob/ubl/docs/pics/ubl-1.png?raw=true"/>