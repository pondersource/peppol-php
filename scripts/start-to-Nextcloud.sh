#!/bin/bash
set -e
echo Mounting peppol-php code repo from the host, folder: $PEPPOL_PHP_DIR 
docker run -d --network=testnet -e MARIADB_ROOT_PASSWORD=eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek --name=maria2.docker mariadb --transaction-isolation=READ-COMMITTED --binlog-format=ROW --innodb-file-per-table=1 --skip-innodb-read-only-compressed
docker run -d --network=testnet --name=nc2.docker -v $PEPPOL_PHP_DIR/p12transport:/p12transport -v $PEPPOL_PHP_DIR:/var/www/html/apps/peppol-php nc2
docker exec -w /var/www/html/apps/peppolnext nc2.docker make composer

echo "sleeping 15 seconds"
sleep 15
echo "slept 15 seconds"

docker exec -it -e DBHOST=maria2.docker -e USER=marie -e PASS=radioactivity -u www-data nc2.docker sh /init.sh
