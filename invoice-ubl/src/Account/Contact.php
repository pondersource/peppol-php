<?php

class Contact {
    private $name;
    private $telephone;
    private $telefax;
    private $electronicMail;
    

    /**
     * Get Name
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Set Name
     */
    public function setName(?string $name): Contact {
        $this->name = $name;
        return $this;
    }

    /**
     * Get telephone
     */
    public function getTelephone(): ?string {
        return $this->telephone;
    }


    /**
     * get telefax
     */
    public function getTelefax(): ?string
    {
        return $this->telefax;
    }

    /**
     * set telefax
     */
    public function setTelefax(?string $telefax): Contact
    {
        $this->telefax = $telefax;
        return $this;
    }

    /**
     * Set telephone
     */
    public function setTelephone(?string $telephone): Contact {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * get electroic Mail
     */
    public function getElectroicMail(): ?string {
        return $this->electronicMail;
    }

    /**
     * Set electronic mail
     */
    public function setElectronicMail(?string $electronicMail): Contact {
        $this->electronicMail = $electronicMail;
        return $this;
    }
}