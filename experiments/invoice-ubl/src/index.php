<?php

require 'Country.php';
require 'PostalAddress.php';
require 'Party.php';
require 'PartyTaxScheme.php';
require 'Contact.php';
require 'LegalMonetaryTotal.php';
require 'TaxScheme.php';
require 'FinancialInstitutionBranch.php';
require 'PayeeFinancialAccount.php';
require 'PaymentMeans.php';
require 'LegalEntity.php';
require 'ClassifiedTaxCategory.php';
require 'Item.php';
require 'UnitCode.php';
require 'Price.php';
require 'TaxTotal.php';
require 'TaxSubTotal.php';
require 'TaxCategory.php';
require 'InvoicePeriod.php';
require 'InvoiceLine.php';
require 'PaymentTerms.php';
require 'Delivery.php';

$url = 'https://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd';
 // Tax scheme
 $taxScheme = (new TaxScheme())
 ->setId('VAT');

$country = (new Country())
            ->setIdentificationCode('NL');

        // Full address
$address = (new PostalAddress())
                ->setStreetName('Lisk Center Utreht')
                ->setAddionalStreetName('De Burren')
                ->setCityName('Utreht')
                ->setPostalZone('3521')
                ->setCountry($country);

$financialInstitutionBranch = (new FinancialInstitutionBranch())
                ->setId('RABONL2U');
    
$payeeFinancialAccount = (new PayeeFinancialAccount())
               ->setFinancialInstitutionBranch($financialInstitutionBranch)
                ->setName('Customer Account Holder')
                ->setId('NL00RABO0000000000');
$paymentMeans = (new PaymentMeans())
                ->setPayeeFinancialAccount($payeeFinancialAccount)
                ->setPaymentMeansCode(31, [])
                ->setPaymentId('our invoice 1234');

 // Supplier company node
 $supplierLegalEntity = (new LegalEntity())
 ->setRegistrationNumber('PonderSource')
 ->setCompanyId('NL123456789');

$supplierPartyTaxScheme = (new PartyTaxScheme())
 ->setTaxScheme($taxScheme)
 ->setCompanyId('NL123456789');

$supplierCompany = (new Party())
 ->setPartyName('PonderSource')
 ->setLegalEntity($supplierLegalEntity)
 ->setPartyTaxScheme($supplierPartyTaxScheme)
 ->setPostalAddress($address);



// Client company node
$clientLegalEntity = (new LegalEntity())
 ->setRegistrationNumber('Client Company Name')
 ->setCompanyId('Client Company Registration');

$clientPartyTaxScheme = (new PartyTaxScheme())
 ->setTaxScheme($taxScheme)
 ->setCompanyId('BE123456789');

$clientCompany = (new Party())
 ->setPartyName('Client Company Name')
 ->setLegalEntity($clientLegalEntity)
 ->setPartyTaxScheme($clientPartyTaxScheme)
 ->setPostalAddress($address);

$legalMonetaryTotal = (new LegalMonetaryTotal())
 ->setPayableAmount(10 + 2.1)
 ->setAllowanceTotalAmount(0)
 ->setTaxInclusiveAmount(10 + 2.1)
 ->setLineExtensionAmount(10)
 ->setTaxExclusiveAmount(10);

 $classifiedTaxCategory = (new ClassifiedTaxCategory())
 ->setId('S')
 ->setPercent(21.00)
 ->setTaxScheme($taxScheme);

  // Product
  $productItem = (new Item())
  ->setName('Product Name')
  ->setClassifiedTaxCategory($classifiedTaxCategory)
  ->setDescription('Product Description');

// Price
 $price = (new Price())
       ->setBaseQuantity(1)
       ->setUnitCode(UnitCode::UNIT)
       ->setPriceAmount(10);

// Invoice Line tax totals
$lineTaxTotal = (new TaxTotal())
            ->setTaxAmount(2.1);

// InvoicePeriod
$invoicePeriod = (new InvoicePeriod())
->setStartDate(new \DateTime());

// Invoice Line(s)
$invoiceLine = (new InvoiceLine())
->setId(0)
->setItem($productItem)
->setPrice($price)
->setInvoicePeriod($invoicePeriod)
->setLinesExtensionAmount(10)
->setInvoiceQuantity(1);

$taxCategory = (new TaxCategory())
            ->setId('S', [])
            ->setPercent(21.00)
            ->setTaxScheme($taxScheme);

 $taxSubTotal = (new TaxSubTotal())
            ->setTaxableAmount(10)
            ->setTaxAmount(2.1)
            ->setTaxCategory($taxCategory);


$taxTotal = (new TaxTotal())
            ->setTaxSubtotal($taxSubTotal)
            ->setTaxAmount(2.1);
   // Payment Terms
$paymentTerms = (new PaymentTerms())
   ->setNote('30 days net');
// Delivery
$deliveryLocation = (new PostalAddress())
  ->setCountry($country);

$delivery = (new Delivery())
  ->setActualDeliveryDate(new \DateTime())
  ->setDeliveryLocation($deliveryLocation);