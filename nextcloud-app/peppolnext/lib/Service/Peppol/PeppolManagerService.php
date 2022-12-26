<?php

namespace OCA\PeppolNext\Service\Peppol;

use OCA\PeppolNext\Db\PeppolIdentity;
use OCA\PeppolNext\Db\PeppolIdentityMapper;
use OCA\PeppolNext\PonderSource\EBMS\Property;

use Exception;

class PeppolManagerService {

    /** @var PeppolIdentityMapper */
    private $peppolIdentityMapper;

    public function __construct(PeppolIdentityMapper $peppolIdentityMapper) {
        $this->peppolIdentityMapper = $peppolIdentityMapper;
    }

    public function findPeppolIdentity(Property $property): ?PeppolIdentity {
        $identity = null;

        try {
            $identity = $this->peppolIdentityMapper->findPeppolIdentity($property->getValue());
        } catch (Exception $e) {
            return null;
        }

        if ($property->getType() !== $identity->getScheme()) {
            return null;
        }

        return $identity;
    }

}