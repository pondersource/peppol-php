<?php

namespace OCA\PeppolNext\Service\Peppol;

use OCA\PeppolNext\Db\PeppolIdentity;

/**
 * There can be only one identity per user.
 */
interface IPeppolService {

    /**
     * Return the service name for this service that will be used in the database.
     */
    public function getServiceName(): string;

    /**
     * Return the identity of the current user.
     * 
     */
    public function getIdentity(): ?PeppolIdentity;

    /**
     * Generate a new identity for the user and return it.
     */
    public function generateIdentity(): PeppolIdentity;

}