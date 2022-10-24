# Peppol for the Masses
## Re-signing Gateway
This code module implements the functionality of the re-signing gateway as described
in milestone 4 of [the MoU](https://github.com/pondersource/peppol-php/blob/main/pftm-mou-annexe-milestones.pdf).

To run it, you have two options: with or without Docker.

### With Docker
```
git clone https://github.com/pondersource/peppol-php
cd peppol-php
./scripts/gencerts.sh
cd re-signing-gateway
docker build -t re-signing-gateway .
docker run -d re-signing-gateway
```

### Without Docker
You will need PHP v7 with the php-soap extension, and composer installed; then you should be able to:
```
git clone https://github.com/pondersource/peppol-php
cd peppol-php
cd re-signing-gateway
composer install
php -S localhost:8080
```
Now you can visit http://localhost:8080/kyc.php

### How does the KYC process take place?

