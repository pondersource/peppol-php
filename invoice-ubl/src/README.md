## UBL Invoice

### Requirements

* PHP 7.2
* composer

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

### Installation 

````
composer install
````

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