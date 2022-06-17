```
cd mutual
docker build -t mutual .
cd ..
cd client
docker build -t client .
cd ..
cd server
docker buidl -t server .
cd ..
docker create network testnet
docker run -d --name=server --network=testnet server
docker run -d --name=client -e "AS4_END_POINT=http://server" --network=testnet client
