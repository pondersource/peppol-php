<?php
include 'vendor/autoload.php';
require 'Account/Country.php';
require 'Account/PostalAddress.php';
require 'Party/Party.php';
require 'Party/PartyTaxScheme.php';
require 'Account/Contact.php';
require 'Legal/LegalMonetaryTotal.php';
require 'Party/TaxScheme.php';
require 'Financial/FinancialInstitutionBranch.php';
require 'Financial/PayeeFinancialAccount.php';
require 'Payment/PaymentMeans.php';
require 'Legal/LegalEntity.php';
require 'Tax/ClassifiedTaxCategory.php';
require 'Item.php';
require 'Codes/UnitCode.php';
require 'Payment/Price.php';
require 'Tax/TaxTotal.php';
require 'Tax/TaxSubTotal.php';
require 'Tax/TaxCategory.php';
require 'Invoice/InvoicePeriod.php';
require 'Invoice/InvoiceLine.php';
require 'Payment/PaymentTerms.php';
require 'Account/Delivery.php';
require 'Payment/OrderReference.php';
require 'Invoice/Invoice.php';
require 'Invoice/GenerateInvoice.php';
require '../../xml-transaction/src/Signature/signature.php';
require 'AllowanceCharge.php';
require 'DeserializeInvoice.php';


 // Tax scheme
 $taxScheme = (new TaxScheme())
 ->setId('VAT');

  // Client contact node
  $clientContact = (new Contact())
   ->setName('Client name')
   ->setTelephone('908-99-74-74');



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
 $supplierLegalEntity = (new LegalEntity())		// $doc = new DOMDocument();
		// $doc->load($path);
 ->setRegistrationNumber('PonderSource')
 ->setCompanyId('NL123456789');


$supplierPartyTaxScheme = (new PartyTaxScheme())
 ->setTaxScheme($taxScheme)
 ->setCompanyId('NL123456789');

$supplierCompany = (new Party())
 ->setEndPointId('7300010000001', '0007')
 ->setPartyIdentificationId('99887766')
 ->setName('PonderSource')
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
->setPartyIdentificationId('9988217')
->setEndPointId('7300010000002', '0002')
 ->setName('Client Company Name')
 ->setLegalEntity($clientLegalEntity)
 ->setPartyTaxScheme($clientPartyTaxScheme)
 ->setPostalAddress($address)
 ->setContact($clientContact);

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
->setLineExtensionAmount(10)
->setInvoicedQuantity(1);

$invoiceLines = [$invoiceLine];

$taxCategory = (new TaxCategory())
            ->setId('S', [])
            ->setPercent(21.00)
            ->setTaxScheme($taxScheme);

$allowanceCharge = (new AllowanceCharge())
->setChargeIndicator(true)
->setAllowanceReason('Insurance')
->setAmount(10)
->setTaxCategory($taxCategory);

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
->setStreetName('Delivery street 2')
->setAddionalStreetName('Building 56')
->setCityName('Utreht')
->setPostalZone('3521')
->setCountry($country);

$delivery = (new Delivery())
  ->setActualDeliveryDate(new \DateTime())
  ->setDeliveryLocation($deliveryLocation);


$orderReference = (new OrderReference())
  ->setId('5009567')
  ->setSalesOrderId('tRST-tKhM');

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
  //$sign = new Signature;
  //$sign->GenerateKeyPair(OPENSSL_KEYTYPE_RSA);
  //$signed_dom = $sign->createSignedXml($dom);
  $dom->save('EN16931Test.xml');
  // Use webservice at peppol.helger.com to verify the result
  $wsdl = "http://peppol.helger.com/wsdvs?wsdl=1";
  $client = new \SoapClient($wsdl);
  $response = $client->validate(['XML' => $outputXMLString, 'VESID' => 'eu.cen.en16931:ubl:1.3.7']);
  echo json_encode($response);

 $deserialize = new DeserializeInvoice();
 var_dump($deserialize->deserializeXML($outputXMLString));
 exit;