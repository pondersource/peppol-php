<?php

namespace OCA\PeppolNext\Service\Peppol;

use OCA\PeppolNext\Db\PeppolIdentity;
use OCA\PeppolNext\Db\PeppolIdentityMapper;
use OCA\PeppolNext\PonderSource\EBMS\Property;

use Exception;

class PeppolManagerService {

    /** @var PeppolIdentityMapper */
    private $peppolIdentityMapper;

    private $services = [];

    public function __construct(PeppolIdentityMapper $peppolIdentityMapper
        , AS4DirectService $aS4DirectService
        , LetsPeppolService $letsPeppolService) {
        $this->peppolIdentityMapper = $peppolIdentityMapper;

        $this->registerService($aS4DirectService);
        $this->registerService($letsPeppolService);
    }

    private function registerService(IPeppolService $service) {
        $this->services[$service->getServiceName()] = $service;
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

    public function getCertificateStore(PeppolIdentity $identity): ?string {
        $service = $this->getPeppolServiceForName($identity->getServiceName());
        return $service->getCertificateStore($identity);
    }

    public function getPeppolServiceForName(string $serviceName): IPeppolService {
        return $this->services[$serviceName];
    }

}