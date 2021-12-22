# What is UBL?

## What is UBL?

The world of business is fueled by documents such as orders, invoices and waybills that are sent between trading partners such as buyers, sellers, shippers and warehouses. For many years, expensive Electronic Data Interchange (EDI) implementations on costly value-added networks have fulfilled the need to express such documents in a machine-processable form for software applications to act on the contents found therein. 

## Traditional paper-based document exchange 

When automated using software, the sender's application preparing the business document to be sent to the receiver frames the information around the content found in the sender's data model reflecting the sender's business practices. The information is typically then prepared in paper form, perhaps even electronically in paper form using PDF. This document insulates the sender from following or just even knowing about the receiver's business practices. The receiver of the document then needs somehow to convey that information into their application that has its own data model reflecting their business practices. This can be illustrated as follows.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/ubl.png?raw=true"/>

## Document choreography, user data and transport 

Moving to the electronic interchange of information involves three aspects of the interaction between trading partners. The choreography of exchanges (if any) needs to be agreed upon, the structure and use of the documents within each choreography must be unambiguously processable, and the platforms on which each party runs their software must be able to communicate with each other.
For a document format, the OASIS Universal Business Language (UBL) is an open and royalty-free library of standard XML business document types. UBL is made freely available to download without any registration or cost, for users to cherry-pick which constructs are going to convey which business information is needed to be exchanged. Validation tools are included to automate the checking of content against the document constraints.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/ubl-1.png?raw=true"/>

## Parties involved in the shipment of goods across international borders 

A real-world example of a simple request/response exchange for transportation status messages is seen in the US Department of Transportation Electronic Freight Management (EFM) project shipping Victoria's Secret clothing from a supplier in China to a buyer in Cincinnati. There were 11 different parties involved in the handling of a single shipment from source to target, including transportation, customs and warehousing. Each party has their own business practices, data models and applications. The project's work product was a single aggregation application able to report shipment status information in HTML to a user. The application requests each party to respond with a UBL Transportation Status message with details of the desired shipment as known only to the party being asked. Those who received the request and could respond to it returned the information in a UBL-schema-valid XML document. 

<img src="https://github.com/pondersource/peppol-php/blob/ubl/docs/pics/ubl-3.png?raw=true"/>

## The governance of UBL

Do you think your extension elements have the semantic definition that will be of interest to many users of UBL? Do you feel the committee has overlooked a particular document type that is needed in general? If so, UBL governance allows you to participate in the UBL development process, either by joining OASIS and becoming a member of the committee, or by using the available public comment list. For intellectual property reasons, these are the only two ways a Technical Committee can receive input. OASIS has worked hard to ensure that its committees' work products are available to be used by anyone. The membership constraints and the public comment list subscription constraints impose obligations on contributors that that which is submitted by them is allowed to be openly used in work products published by OASIS.

## Modeling and reifying validation artefacts

UBL can be held up as an example of how XML interchange documents are developed. The methodology used has been proposed to develop solutions for other domains where international interchange documents are needed.

The international standard ISO/IEC 14662 formally describes the Open-edi reference model. This model distinguishes at a high level the business semantic perspective of an eBusiness relationship from the functional services perspective of its implementation.

<img src="https://github.com/pondersource/peppol-php/blob/ubl/docs/pics/ubl-4.png?raw=true"/>

## Resources

* [What is UBL?](https://www.xml.com/articles/2017/01/01/what-is-ubl/)