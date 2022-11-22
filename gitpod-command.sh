#!/bin/bash
set -e

docker network create testnet
export PEPPOL_PHP_DIR=`pwd`
./scripts/start-to-Nextcloud.sh
sleep 10
# this will send 1 message to the Phase4 server and then exit:
./scripts/send-from-Phase4.sh
docker container cp client:/root/phase4/phase4-peppol-client/phase4-dumps .
cat phase4-dumps/outgoing/*/*/*/*.as4response
# clean up for next run:
docker rm client
rm -rf phase4-dumps