<?php

require 'Country.php';
require 'PostalAddress.php';
require 'Party.php';
require 'Contact.php';

$country = (new Country())
            ->setIdentificationCode('NE');

        // Full address
        $address = (new PostalAddress())
            ->setStreetName('NetherLand')
            ->setBuildingNumber(1)
            ->setCityName('Utreht')
            ->setPostalZone('9000')
            ->setCountry($country);

        // Supplier company node
        $supplierCompany = (new Party())
            ->setPartyName('Ponder Source')
            ->setPhysicalLocation($address)
            ->setPostalAddress($address);

        // Client contact node
        $clientContact = (new Contact())
            ->setName('Ismoil')
            ->setElectronicMail('ismail94.94@mail.ru')
            ->setTelephone('908 99 74 74')
            ->setTelefax('1234 1234 1267');

        // Client company node
        var_dump($clientCompany = (new Party())
            ->setPartyName('Ismoil')
            ->setPostalAddress($address)
            ->setContact($clientContact));