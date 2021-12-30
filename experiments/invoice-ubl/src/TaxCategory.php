<?php

class TaxCategory extends ServiceTax {
    private $id;
    private $idAttributes = [
        'schemeID' => TaxCategory::UNCL5305,
        'schemeName' => 'Duty or tax or fee category'
    ];
    private $percent;
    private $taxScheme;

    public const UNCL5305 = 'UNCL5305';

    /**
     * Document level allowance or charge VAT category code
     */
    public function getId() {
       return $this->id;
    }
}