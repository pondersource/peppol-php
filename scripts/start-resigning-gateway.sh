#!/bin/bash
set -e
if [[ -z "$PEPPOL_PHP_DIR" ]]; then
    echo "Must provide PEPPOL_PHP_DIR in environment" 1>&2
    exit 1
fi
echo Mounting peppol-php code repo from the host, folder: $PEPPOL_PHP_DIR 
docker run -d --network=testnet --name=re-signing-gateway.docker -v $PEPPOL_PHP_DIR/p12transport:/p12transport -v $PEPPOL_PHP_DIR/re-signing-gateway:/var/www/html re-signing-gateway
# docker exec -w /var/www/html re-signing-gateway.docker make composer
