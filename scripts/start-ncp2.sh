#!/bin/bash
set -e
docker run -d --network=testnet -e MARIADB_ROOT_PASSWORD=eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek --name=maria1.docker mariadb --transaction-isolation=READ-COMMITTED --binlog-format=ROW --innodb-file-per-table=1 --skip-innodb-read-only-compressed
docker run -d --network=testnet --name=ncp1.docker -v /root/peppol-php/nextcloud-app/peppolnext:/var/www/html/apps/peppolnext ncp2

sleep 15
docker exec -e DBHOST=maria1.docker -e USER=einstein -e PASS=relativity  -u www-data ncp2.docker sh /init.sh
docker exec maria1.docker mariadb -u root -peilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek nextcloud -e "insert into oc_appconfig (appid, configkey, configvalue) values ('sciencemesh', 'iopUrl', 'https://revanc1.docker/');"
docker exec maria1.docker mariadb -u root -peilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek nextcloud -e "insert into oc_appconfig (appid, configkey, configvalue) values ('sciencemesh', 'revaSharedSecret', 'shared-secret-1');"
