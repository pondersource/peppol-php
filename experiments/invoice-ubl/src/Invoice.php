<?php

class Invoice {
    private $customazionID;
    private $profileID;
    private $ID;
    
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
    }
}
