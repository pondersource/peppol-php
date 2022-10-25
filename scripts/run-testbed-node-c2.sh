#!/bin/bash
set -e
if [[ -z "$PEPPOL_PHP_DIR" ]]; then
    echo "Must provide PEPPOL_PHP_DIR in environment" 1>&2
    exit 1
fi
echo Mounting peppol-php code repo from the host, folder: $PEPPOL_PHP_DIR 

docker run -d --network=host --name=rsg -v /root/tls:/tls -v $PEPPOL_PHP_DIR/re-signing-gateway:/var/www/html re-signing-gateway
docker exec -it rsg tail -f /var/log/apache2/error.log

# docker run -d --network=testnet -e MARIADB_ROOT_PASSWORD=eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek --name=maria mariadb --transaction-isolation=READ-COMMITTED --binlog-format=ROW --innodb-file-per-table=1 --skip-innodb-read-only-compressed
# docker run -d --network=testnet --name=nc1.docker -v /root/tls:/tls -v $PEPPOL_PHP_DIR:/var/www/html/apps/peppol-php -v $PEPPOL_PHP_DIR/p12transport:/p12transport c2
# docker exec -w /var/www/html/apps/peppolnext nc1.docker make composer
# docker run --name=logger -d --network=testnet -p 443:443 -v /root/tls:/tls -v $PEPPOL_PHP_DIR:/var/www/html/apps/peppol-php logger
# 
# echo "sleeping for 15 seconds"
# sleep 15
# echo "slept for 15 seconds"
# 
# docker exec -it -e DBHOST=maria -e USER=einstein -e PASS=relativity  -u www-data nc1.docker sh /init.sh
