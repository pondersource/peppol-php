<?php

use PHPUnit\Framework\TestCase;

/**
 * Test an UBL2.1 invoice document
 */
class SimpleInvoiceTest extends TestCase {
    private $schema = 'http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd';

    /**
     * @test
     */
    public function testIfXMLIsValid()
    {
        //Address Country
        $country = (new Country())
        ->setIdentificationCode('NL');

        //Full Address
        $address = (new PostalAddress())
                ->setStreetName('Lisk Center Utreht')
                ->setAddionalStreetName('De Burren')
                ->setCityName('Utreht')
                ->setPostalZone('3521')
                ->setCountry($country);

        // Supplier company node
        $supplierCompany = (new Party())
        ->setName('Supplier Company Name')
        ->setPhysicalLocation($address)
        ->setPostalAddress($address);
           
        // Client contact node
        $clientContact = (new Contact())
            ->setName('Client name')
            ->setTelephone('908-99-74-74');

            // Client company node
        $clientCompany = (new Party())
            ->setName('My client')
            ->setPostalAddress($address)
            ->setContact($clientContact);
            $legalMonetaryTotal = (new LegalMonetaryTotal())
            ->setPayableAmount(10 + 2)
            ->setAllowanceTotalAmount(0);

        // Tax scheme
        $taxScheme = (new TaxScheme())
            ->setId(0);

        // Product
        $productItem = (new Item())
            ->setName('Product Name')
            ->setDescription('Product Description')
            ->setSellersItemIdentification('SELLERID');

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
        
        $invoiceLines = [];

        $invoiceLines[] = (new InvoiceLine())
        ->setId(0)
        ->setItem($productItem)
        ->setInvoicePeriod($invoicePeriod)
        ->setPrice($price)
        ->setAccountingCost('Product 123')
        ->setTaxTotal($lineTaxTotal)
        ->setInvoicedQuantity(1);

        $invoiceLines[] = (new InvoiceLine())
            ->setId(0)
            ->setItem($productItem)
            ->setInvoicePeriod($invoicePeriod)
            ->setPrice($price)
            ->setAccountingCostCode('Product 123')
            ->setTaxTotal($lineTaxTotal)
            ->setInvoicedQuantity(1);

        // Total Taxes
        $taxCategory = (new TaxCategory())
            ->setId(0)
            ->setName('VAT21%')
            ->setPercent(.21)
            ->setTaxScheme($taxScheme);

        $taxSubTotal = (new TaxSubTotal())
            ->setTaxableAmount(10)
            ->setTaxAmount(2.1)
            ->setTaxCategory($taxCategory);


        $taxTotal = (new TaxTotal())
            ->setTaxSubtotal($taxSubTotal)
            ->setTaxAmount(2.1);

          // Invoice object
          $invoice = (new Invoice())
          ->setId(1234)
          ->setCopyIndicator(false)
          ->setIssueDate(new \DateTime())
          ->setAccountingSupplierParty($supplierCompany)
          ->setAccountingCustomerParty($clientCompany)
          ->setSupplierAssignedAccountID('10001')
          ->setInvoiceLines($invoiceLines)
          ->setLegalMonetaryTotal($legalMonetaryTotal)
          ->setTaxTotal($taxTotal);

            $generateInvoice = new GenerateInvoice();
            $outputXMLString = $generateInvoice->invoice($invoice);

            $dom = new \DOMDocument;
            $dom->loadXML($outputXMLString);

            $dom->save('./tests/SimpleInvoiceTest.xml');

            $this->assertEquals(true, $dom->schemaValidate($this->schema));
    }
}