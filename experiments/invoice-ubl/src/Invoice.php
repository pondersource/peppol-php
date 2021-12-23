<?php

class Invoice {

    private $customazionID;
    private $profileID;
    private $ID;
    private $issueDate;
    private $dueDate;
    private $currencyCode = 'EUR';
    
    /**
     * get Customazation ID
     */
    public function getCustomazationID() {
        return $this->customazionID;
    }

    /**
     * Set ID
     */
    public function setCustomazationID($customazionID) {
        $this->customazionID = $customazionID;
        return $this;
    }

      /**
     * get Customazation ID
     */
    public function getprofileID() {
        return $this->ID;
    }

    /**
     * Set ID
     */
    public function setprofileID($ID) {
        $this->ID = $ID;
        return $this;
    }

      /**
     * get Customazation ID
     */
    public function getId() {
        return $this->profileID;
    }

    /**
     * Set ID
     */
    public function setID($profileID) {
        $this->profileID = $profileID;
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
