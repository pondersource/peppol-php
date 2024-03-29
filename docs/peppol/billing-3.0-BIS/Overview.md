# Introduction to openPEPPOL and BIS

## PEPPOL BIS provides

This PEPPOL BIS provides a set of specifications for implementing a PEPPOL business process.The purpose of this document is to facilitate an efficient implementation and increased use of electronic collaboration regarding the billing process.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/introduction.png?raw=true"/>


## The invoice and credit note

The invoice and credit note provides simple support for complex invoicing, where there is a need for credit note in addition to an invoice. Other potential benefits are, among others:

- Can be mandated as a basis for national or regional eInvoicing initiatives.

- Procurement agencies can use them as basis for moving all invoices into electronic form. The flexibility of the specifications allows the buyers to automate processing of invoices gradually, based on different sets of identifiers or references, based on a cost/benefit approach.

- SME can offer their trading partners the option of exchanging standardised documents in a uniform way and thereby move all invoices/credit notes into electronic form.

## Parties and roles

The diagram below shows the roles involved in the invoice and credit note transactions. The customer and invoice receiver is the same entity, as is the supplier and the invoice sender.

### Parties

**Customer** 

The customer is the legal person or organisation who is in demand of a product or service. Examples of customer roles: buyer, consignee, debtor, contracting authority.

**Supplier** 

The supplier is the legal person or organisation who provides a product or service.

## Roles

**Creditor**

One to whom a debt is owe. The party that claims the payment and is responsible for resolving billing issues and arranging settlement. The party that sends the invoice or credit note. Also known as invoice issuer, accounts receivable or seller.

**Debtor** 

One who owes debt. The party responsible for making settlement relating to a purchase. The party that receives the invoice or credit note. Also known as invoicee, accounts payable, or buyer.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/roles.png?raw=true"/>

## General invoicing process

The invoicing process includes issuing and sending the invoice and the credit note from the supplier to the customer and the reception and handling of the same at the customer’s site.

The invoicing process is shown in this work flow:

* A supplier issues and sends an invoice to a customer. The invoice refers to one order and a specification of delivered goods and services.

An invoice may also refer to a contract or a frame agreement. The invoice may specify articles (goods and services) with article number or article description.

1) The customer receives the invoice and processes it in the invoice control system leading to one of the following results:

- The customer fully approves the invoice, posts it in the accounting system and passes it on to be paid.

- The customer completely rejects the invoice, contacts the supplier and requests a credit note.

- The customer disputes parts of the invoice, contacts the supplier and requests a credit note and a new invoice.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/process.png?raw=true"/>

## Invoice functionality

An invoice may support functions related to a number of related (internal) business processes. This PEPPOL BIS shall support the following functions:

* Accounting

* Invoice verification against the contract, the purchase order and the goods and service delivered

* VAT reporting

* Auditing

* Payment

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/functionality.png?raw=true"/>

## Accounting

Recording a business transaction into the financial accounts of an organization is one of the main objectives of the invoice. According to financial accounting best practice and VAT rules every Taxable person shall keep accounts in sufficient detail for VAT to be applied and its application checked by the tax authorities.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/accounting.PNG?raw=true"/>

- [Accounting](https://docs.peppol.eu/poacc/billing/3.0/bis/#_accounting)

## Invoice verification

This process forms part of the Buyer’s internal business controls. The invoice shall refer to an authentic commercial transaction. Support for invoice verification is a key function of an invoice. An invoice should also contain sufficient information that allows the received invoice to be transferred to a responsible authority, person or department, for verification and approval.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/invoice-verification.PNG?raw=true"/>

- [Invoice verification](https://docs.peppol.eu/poacc/billing/3.0/bis/#_invoice_verification)

## Auditing

Companies audit themselves as means of internal control or they may be audited by external parties as part of a legal obligation. Invoices, conformant to this PEPPOL BIS support the auditing process by providing sufficient information for:

- identification of the relevant Buyer and Seller

- identification of the products and services traded, including description, value and quantity

- information for connecting the invoice to its payment

- information for connecting the invoice to relevant documents such as a contract and a purchase order

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/auditing.PNG?raw=true"/>

- [Auditing](https://docs.peppol.eu/poacc/billing/3.0/bis/#_auditing)

## VAT Reporting

The invoice is used to carry VAT related information from the Seller to the Buyer to enable the Buyer and Seller to correctly handle VAT booking and reporting. 

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/vat-reporting.PNG?raw=true"/>

- [Vat Reporting](https://docs.peppol.eu/poacc/billing/3.0/bis/#_vat_reporting)

## Payment

An invoice represents a claim for payment. The issuance of an invoice may take place either before or after the payment is carried out. When an invoice is issued before payment it represents a request to the Buyer to pay, in which case the invoice commonly contains information that enables the Buyer, in the role of a debtor, to correctly initiate the transfer of the payment, unless that information is already agreed in prior contracts or by means of payment instructions separately lodged with the Buyer.

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/payment.PNG?raw=true"/>

- [Payment](https://docs.peppol.eu/poacc/billing/3.0/bis/#_payment)


## Resources 

- [PEPPOL BIS Billing](https://docs.peppol.eu/poacc/billing/3.0/bis/)

- [Vat Reporting(Directive 2006/112/EC)](https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=LEGISSUM:l31057)






