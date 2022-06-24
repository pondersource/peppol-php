#!/bin/bash
set -e
docker build -t tester .
docker run -p 6080:80 -p 5900:5900 -v /dev/shm:/dev/shm --network=testnet --name=tester -d --cap-add=SYS_ADMIN tester
TESTER_IP_ADDR=`docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' tester`
echo $TESTER_IP_ADDR
# set up port forwarding from host to testnet for vnc:
sysctl net.ipv4.ip_forward=1
iptables -t nat -A PREROUTING -p tcp --dport 5900 -j DNAT --to-destination $TESTER_IP_ADDR:5900
echo Now connect to vnc://ocmhost with password 1234 and use Firefox and Terminal in there
echo You may want to run 'sh /ubuntu-init-script.sh' there in the terminal, once logged in as the Desktop OS user.
