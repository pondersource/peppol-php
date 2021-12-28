<?php

require 'Country.php';
require 'PostalAddress.php';
require 'Party.php';
require 'Contact.php';
require 'LegalMonetaryTotal.php';
require 'TaxScheme.php';
require 'FinancialInstitutionBranch.php';
require 'PayeeFinancialAccount.php';

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
var_dump($payeeFinancialAccount);
exit;

// Supplier company node
 $supplierCompany = (new Party())
            ->setPartyName('Ponder Source')
            ->setPhysicalLocation($address)
            ->setPostalAddress($address);

        // Client contact node
$clientContact = (new Contact())
            ->setName('Ismoil')
            ->setElectronicMail('ismail94.94@mail.ru')
            ->setTelephone('908 99 74 74')
            ->setTelefax('1234 1234 1267');

        // Client company node
$clientCompany = (new Party())
            ->setPartyName('Ismoil')
            ->setPostalAddress($address)
            ->setContact($clientContact);
       
$legalMonetaryTotal = (new LegalMonetaryTotal())
            ->setPayableAmount(10 + 2)
            ->setAllowanceTotalAmount(0);
       