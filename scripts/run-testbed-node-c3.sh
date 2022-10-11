#!/bin/bash
set -e
echo Mounting peppol-php code repo from the host, folder: $PEPPOL_PHP_DIR 
docker run -d --network=testnet -e MARIADB_ROOT_PASSWORD=eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek --name=maria mariadb --transaction-isolation=READ-COMMITTED --binlog-format=ROW --innodb-file-per-table=1 --skip-innodb-read-only-compressed
docker run -d --network=testnet --name=nc -p 443:443 -p 80:80 -v /root/tls:/tls -v $PEPPOL_PHP_DIR:/var/www/html/apps/peppol-php c3
docker exec -w /var/www/html/apps/peppolnext nc make composer

echo "sleeping for 15 seconds"
sleep 15
echo "slept for 15 seconds"

docker exec -it -e DBHOST=maria -e USER=marie -e PASS=radioactivity -u www-data nc sh /init.sh
