#!/bin/bash
set -e
if [[ -z "$PEPPOL_PHP_DIR" ]]; then
    echo "Must provide PEPPOL_PHP_DIR in environment" 1>&2
    exit 1
fi
echo Mounting peppol-php code repo from the host, folder: $PEPPOL_PHP_DIR 
docker run -d --network=testnet --name=resigning-gateway.docker -v $PEPPOL_PHP_DIR/p12transport:/p12transport -v $PEPPOL_PHP_DIR/resigning-gateway:/var/www/html/ resigning-gateway
docker exec -w /var/www/html resigning-gateway.docker make composer
