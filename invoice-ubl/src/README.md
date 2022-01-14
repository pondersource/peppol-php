## UBL Invoice

### Requirements

* PHP 7.2
* composer

### Installation 

````
composer install
````

### Usage for generating Invoice EN1691

```php
    include 'vendor/autoload.php';
   // Invoice object
   $invoice = (new Invoice())
   ->setProfileID('urn:fdc:peppol.eu:2017')
   ->setCustomazationID('urn:cen.eu:en16931:2017')
   ->setId(1234)
   ->setIssueDate(new \DateTime())
   ->setNote('invoice note')
   ->setAccountingCostCode('4217:2323:2323')
   ->setDelivery($delivery)
   ->setAccountingSupplierParty($supplierCompany)
   ->setAccountingCustomerParty($clientCompany)
   ->setInvoiceLines($invoiceLines)
   ->setLegalMonetaryTotal($legalMonetaryTotal)
   ->setPaymentTerms($paymentTerms)
   //->setAllowanceCharges($allowanceCharge)
   ->setInvoicePeriod($invoicePeriod)
   ->setPaymentMeans($paymentMeans)
   ->setByerReference('BUYER_REF')
   ->setOrderReference($orderReference)
   ->setTaxTotal($taxTotal);

  $generateInvoice = new GenerateInvoice();
  $outputXMLString = $generateInvoice->invoice($invoice);
  $dom = new \DOMDocument;
  $dom->loadXML($outputXMLString);
  $sign = new Signature;
  $sign->GenerateKeyPair(OPENSSL_KEYTYPE_RSA);
  $signed_dom = $sign->createSignedXml($dom);
  $signed_dom->save('EN16931Test.xml');

```

Output file: EN16931.xml

```xml
<?xml version="1.0"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
 <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
 <cbc:CustomizationID>urn:cen.eu:en16931:2017</cbc:CustomizationID>
 <cbc:ProfileID>urn:fdc:peppol.eu:2017</cbc:ProfileID>
 <cbc:ID>1234</cbc:ID>
 <cbc:IssueDate>2022-01-14</cbc:IssueDate>
 <cbc:InvoiceTypeCode>380</cbc:InvoiceTypeCode>
 <cbc:Note>invoice note</cbc:Note>
 <cbc:DocumentCurrencyCode>EUR</cbc:DocumentCurrencyCode>
 <cbc:AccountingCost>4217:2323:2323</cbc:AccountingCost>
 <cbc:BuyerReference>BUYER_REF</cbc:BuyerReference>
 <cac:InvoicePeriod>
  <cbc:StartDate>2022-01-14</cbc:StartDate>
 </cac:InvoicePeriod>
 <cac:OrderReference>
  <cbc:ID>5009567</cbc:ID>
  <cbc:SalesOrderID>tRST-tKhM</cbc:SalesOrderID>
 </cac:OrderReference>
 <cac:AccountingSupplierParty>
  <cac:Party>
   <cbc:EndpointID schemeID="0007">7300010000001</cbc:EndpointID>
   <cac:PartyIdentification>
    <cbc:ID>99887766</cbc:ID>
   </cac:PartyIdentification>
   <cac:PartyName>
    <cbc:Name>PonderSource</cbc:Name>
   </cac:PartyName>
   <cac:PostalAddress>
    <cbc:StreetName>Lisk Center Utreht</cbc:StreetName>
    <cbc:AdditionalStreetName>De Burren</cbc:AdditionalStreetName>
    <cbc:CityName>Utreht</cbc:CityName>
    <cbc:PostalZone>3521</cbc:PostalZone>
    <cac:Country>
     <cbc:IdentificationCode>NL</cbc:IdentificationCode>
    </cac:Country>
   </cac:PostalAddress>
   <cac:PartyTaxScheme>
    <cbc:CompanyID>NL123456789</cbc:CompanyID>
    <cac:TaxScheme>
     <cbc:ID>VAT</cbc:ID>
    </cac:TaxScheme>
   </cac:PartyTaxScheme>
   <cac:PartyLegalEntity>
    <cbc:RegistrationName>PonderSource</cbc:RegistrationName>
    <cbc:CompanyID>NL123456789</cbc:CompanyID>
   </cac:PartyLegalEntity>
  </cac:Party>
 </cac:AccountingSupplierParty>
 <cac:AccountingCustomerParty>
  <cac:Party>
   <cbc:EndpointID schemeID="0002">7300010000002</cbc:EndpointID>
   <cac:PartyIdentification>
    <cbc:ID>9988217</cbc:ID>
   </cac:PartyIdentification>
   <cac:PartyName>
    <cbc:Name>Client Company Name</cbc:Name>
   </cac:PartyName>
   <cac:PostalAddress>
    <cbc:StreetName>Lisk Center Utreht</cbc:StreetName>
    <cbc:AdditionalStreetName>De Burren</cbc:AdditionalStreetName>
    <cbc:CityName>Utreht</cbc:CityName>
    <cbc:PostalZone>3521</cbc:PostalZone>
    <cac:Country>
     <cbc:IdentificationCode>NL</cbc:IdentificationCode>
    </cac:Country>
   </cac:PostalAddress>
   <cac:PartyTaxScheme>
    <cbc:CompanyID>BE123456789</cbc:CompanyID>
    <cac:TaxScheme>
     <cbc:ID>VAT</cbc:ID>
    </cac:TaxScheme>
   </cac:PartyTaxScheme>
   <cac:PartyLegalEntity>
    <cbc:RegistrationName>Client Company Name</cbc:RegistrationName>
    <cbc:CompanyID>Client Company Registration</cbc:CompanyID>
   </cac:PartyLegalEntity>
   <cac:Contact>
    <cbc:Name>Client name</cbc:Name>
    <cbc:Telephone>908-99-74-74</cbc:Telephone>
   </cac:Contact>
  </cac:Party>
 </cac:AccountingCustomerParty>
 <cac:Delivery>
  <cbc:ActualDeliveryDate>2022-01-14</cbc:ActualDeliveryDate>
  <cac:DeliveryLocation>
   <cac:Address>
    <cbc:StreetName>Delivery street 2</cbc:StreetName>
    <cbc:AdditionalStreetName>Building 56</cbc:AdditionalStreetName>
    <cbc:CityName>Utreht</cbc:CityName>
    <cbc:PostalZone>3521</cbc:PostalZone>
    <cac:Country>
     <cbc:IdentificationCode>NL</cbc:IdentificationCode>
    </cac:Country>
   </cac:Address>
  </cac:DeliveryLocation>
 </cac:Delivery>
 <cac:PaymentMeans>
  <cbc:PaymentMeansCode>31</cbc:PaymentMeansCode>
  <cbc:PaymentID>our invoice 1234</cbc:PaymentID>
  <cac:PayeeFinancialAccount>
   <cbc:ID>NL00RABO0000000000</cbc:ID>
   <cbc:Name>Customer Account Holder</cbc:Name>
   <cac:FinancialInstitutionBranch>
    <cbc:ID>RABONL2U</cbc:ID>
   </cac:FinancialInstitutionBranch>
  </cac:PayeeFinancialAccount>
 </cac:PaymentMeans>
 <cac:PaymentTerms>
  <cbc:Note>30 days net</cbc:Note>
 </cac:PaymentTerms>
 <cac:TaxTotal>
  <cbc:TaxAmount currencyID="EUR">2.10</cbc:TaxAmount>
  <cac:TaxSubtotal>
   <cbc:TaxableAmount currencyID="EUR">10.00</cbc:TaxableAmount>
   <cbc:TaxAmount currencyID="EUR">2.10</cbc:TaxAmount>
   <cac:TaxCategory>
    <cbc:ID>S</cbc:ID>
    <cbc:Percent>21.00</cbc:Percent>
    <cac:TaxScheme>
     <cbc:ID>VAT</cbc:ID>
    </cac:TaxScheme>
   </cac:TaxCategory>
  </cac:TaxSubtotal>
 </cac:TaxTotal>
 <cac:LegalMonetaryTotal>
  <cbc:LineExtensionAmount currencyID="EUR">10.00</cbc:LineExtensionAmount>
  <cbc:TaxExclusiveAmount currencyID="EUR">10.00</cbc:TaxExclusiveAmount>
  <cbc:TaxInclusiveAmount currencyID="EUR">12.10</cbc:TaxInclusiveAmount>
  <cbc:AllowanceTotalAmount currencyID="EUR">0.00</cbc:AllowanceTotalAmount>
  <cbc:PayableAmount currencyID="EUR">12.10</cbc:PayableAmount>
 </cac:LegalMonetaryTotal>
 <cac:InvoiceLine>
  <cbc:ID>0</cbc:ID>
  <cbc:InvoicedQuantity unitCode="C62">1.00</cbc:InvoicedQuantity>
  <cbc:LineExtensionAmount currencyID="EUR">10.00</cbc:LineExtensionAmount>
  <cac:InvoicePeriod>
   <cbc:StartDate>2022-01-14</cbc:StartDate>
  </cac:InvoicePeriod>
  <cac:Item>
   <cbc:Description>Product Description</cbc:Description>
   <cbc:Name>Product Name</cbc:Name>
   <cac:ClassifiedTaxCategory>
    <cbc:ID>S</cbc:ID>
    <cbc:Percent>21.00</cbc:Percent>
    <cac:TaxScheme>
     <cbc:ID>VAT</cbc:ID>
    </cac:TaxScheme>
   </cac:ClassifiedTaxCategory>
  </cac:Item>
  <cac:Price>
   <cbc:PriceAmount currencyID="EUR">10.00</cbc:PriceAmount>
   <cbc:BaseQuantity unitCode="C62">1.00</cbc:BaseQuantity>
  </cac:Price>
 </cac:InvoiceLine>
<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
  <ds:SignedInfo><ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/>
    <ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"/>
  <ds:Reference><ds:Transforms><ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/></ds:Transforms><ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/><ds:DigestValue>cfje7d7Fbezc+J4H+nCBsbFbbN14rS/Xtkt0F9lc2I4=</ds:DigestValue></ds:Reference></ds:SignedInfo><ds:SignatureValue>DmnwU8Gn/EVNPdUU8kKNt/gHABs149/IzLOP96UgWvZ1yKviMlpTLbSyQPFj1wUxT1tslqWaTp99lbPalyZckwSmUbHdHf5GRUV3nNBhsAtgu+VKJPH3gS+qzxjzCzP8Tv5JZ5aszV/upJWgUqaO3B6IZoKypFTs0AHoKGHR37WidxSkfavfuWSiP1LY/V9+1jnGE/ji0vTRL6om2ILgtM0nGJPCMyNDe44mxoKmqCacnEKpaoCQyely86v1VsouaEho3B6K84Am0rSYbZlcgxSLnW1pYe7Y16168Ixmr+4q/R/kFRisqnWIjdJsYmQ3rZCrJJbNEQYgheYefhncdA==</ds:SignatureValue>
<ds:KeyInfo><ds:X509Data/></ds:KeyInfo></ds:Signature></Invoice>


```

### Library that we use

we use the library for serialization and deserialization [sabre/xml](https://github.com/sabre-io/xml)


### Go to the folder
````
cd /var/www/peppol-php/experiments/invoice-ubl/src
````


### Run this to check if the tests for Invoice will pass
````
./vendor/bin/phpunit
````

### And run to see how EN16931 standard will be work validation will be pass or not

````
php -S localhost:8080
````

### UBL Address and Attachment

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/diagram_ubl_start.PNG?raw=true"/>

### Unit Code 
We have more unit code that need fill. I created the class for it. But we can add more unit codes. Feel free create PR.

- [Unit Code](https://docs.peppol.eu/poacc/billing/3.0/codelist/UNECERec20/)

### Invoice Type Code 
A code specifying the functional type of the Invoice. The base value for send invoice is 380. But you can see more code below in link.

- [Invoice Type Code](https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL1001-inv/)

### UBL Party

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/ubl-party.PNG?raw=true"/>

### UBL Payments

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/ubl-payment.PNG?raw=true"/>

### Duty or tax or fee category code(Subset of UNCL5305)
- [Vat Categrory Code](https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL5305/)

### UBL Item with classified tax

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/item-ubl.PNG?raw=true"/>

### UBL Tax

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/ubl-tax.PNG?raw=true"/>


### UBL Invoice Line

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/ubl-invoice-line.PNG?raw=true"/>

### Invoice 

<img src="https://github.com/pondersource/peppol-php/blob/main/invoice-ubl/src/pics/invoice-ubl.PNG?raw=true"/>