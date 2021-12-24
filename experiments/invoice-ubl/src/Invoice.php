<?php

class Invoice {
    private $UBLVersionID = '2.1';
    private $customazionID;
    private $profileID;
    private $id;
    private $issueDate;
    private $dueDate;
    private $currencyCode = 'EUR';
    
    /**
     * get UBL version ID
     */
    public function getUBLVersionID(): ?string
    {
        return $this->UBLVersionID;
    }

    /**
     * Set UBL version ID
     */
    public function setUBLVersionID(?string $UBLVersionID)
    {
        $this->UBLVersionID = $UBLVersionID;
        return $this;
    }

    /**
     * get Customazation ID
     */
    public function getCustomazationID(): ?string {
        return $this->customazionID;
    }

    /**
     * Set ID
     */
    public function setCustomazationID(?string $customazionID) {
        $this->customazionID = $customazionID;
        return $this;
    }

      /**
     * get Customazation ID
     */
    public function getProfileID(): ?string {
        return $this->profileID;
    }

    /**
     * Set Profile ID
     */
    public function setProfileID(?string $profileID) {
        $this->profileID = $profileID;
        return $this;
    }

      /**
     * get ID
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Set ID
     */
    public function setID(?string $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set issue Date
    */
    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
        return $this;
    }
    
    /**
     * get issue date
     */
    public function getIssueDate() {
        return $this->issueDate;
    }

    /**
     * Set due date  
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

     /**
     * Get due date  
     */
    public function getDueDate() {
        return $this->dueDate;
    }

    /**
     * Set Currency
     */
    public function setCurrencyCode($currencyCode = 'EUR')
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

     /**
     * Get Currency
     */
    public function getCurrencyCode() 
    {
       return $this->currencyCode;
    }

}
