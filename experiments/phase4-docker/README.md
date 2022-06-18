```
cd mutual
docker build -t mutual .
cd ..
cd client
docker build -t client .
cd ..
cd server
docker build -t server .
cd ..
docker create network testnet
docker run -d --name=server --network=testnet -p 8080:8080 server
docker run --name=client -e "AS4_END_POINT=http://server:8080" --network=testnet client
docker container cp client:/root/phase4/phase4-peppol-client/phase4-dumps .