docker run -d --name=firefox -p 5800:5800 -v /tmp/shm:/config:rw --network=testnet --shm-size 2g jlesage/firefox:v1.17.1
echo Now browse to http://ocmhost:5800 to see a Firefox instance that sits inside the Docker testnet.
