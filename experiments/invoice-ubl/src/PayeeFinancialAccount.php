<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

//require 'Schema.php';

class PayeeFinancialAccount implements XmlSerializable {
    private $id;
    private $name;
    private $financialInstitutionBranch;

    /**
     * Payment account identifier
     * Example value: NO99991122222
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Set payment account id
     */
    public function setId(?string $id): PayeeFinancialAccount {
        $this->id = $id;
        return $this;
    }

    /**
     * Payment account name
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Set account name
     */
    public function setName(?string $name): PayeeFinancialAccount {
        $this->name = $name;
        return $this;
    }

    /**
     * financial instution branch
     */
    public function getFinancialInstitutionBranch(): ?FinancialInstitutionBranch {
        return $this->financialInstitutionBranch;
    }

    /**
     * Set finiancial instution branch
     */
    public function setFinancialInstitutionBranch(FinancialInstitutionBranch $financialInstitutionBranch): PayeeFinancialAccount {
        $this->financialInstitutionBranch = $financialInstitutionBranch;
        return $this;
    }

    /**
     * Serialize XML Payee Financial Account
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
            'name' => Schema::CBC . 'ID',
            'value' => $this->id,
            'attributes' => [
                //'schemeID' => 'IBAN'
            ]
        ]);

        if($this->getName() !== null) {
            $writer->write([
                Schema::CBC . 'Name' => $this->name
            ]);
        }

        if($this->getFinancialInstitutionBranch() !== null) {
            $writer->write([
                Schema::CAC . 'FinancialInstitutionBranch' => $this->name
            ]);
        }
    }
}