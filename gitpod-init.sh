#!/bin/bash
set -e

./scripts/gencerts.sh
./scripts/rebuild.sh
./scripts/transportp12.sh
docker pull mariadb

export PEPPOL_PHP_DIR=`pwd`
docker run -w /var/www/html/apps/peppolnext -v $PEPPOL_PHP_DIR:/var/www/html/apps/peppol-php nc2 make composer