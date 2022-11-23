./scripts/send-from-Phase4.sh
docker container cp client:/root/phase4/phase4-peppol-client/phase4-dumps .
cat ./phase4-dumps/outgoing/*/*/*/*.as4response
# clean up for next run:
docker rm client
rm -rf phase4-dumps
