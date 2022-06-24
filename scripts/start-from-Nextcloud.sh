#!/bin/bash
set -e
docker run -d --network=testnet -e MARIADB_ROOT_PASSWORD=eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek --name=maria1.docker mariadb --transaction-isolation=READ-COMMITTED --binlog-format=ROW --innodb-file-per-table=1 --skip-innodb-read-only-compressed
docker run -d --network=testnet --name=nc1.docker nc1

sleep 15
docker exec -it -e DBHOST=maria1.docker -e USER=einstein -e PASS=relativity  -u www-data nc1.docker sh /init.sh
