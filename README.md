# An implementation of Peppol in PHP [![Join the chat at https://gitter.im/pondersource/peppol-php](https://badges.gitter.im/pondersource/peppol-php.svg)](https://gitter.im/pondersource/peppol-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[Funded by NLnet / NGI Assure](https://nlnet.nl/project/Peppol-Decentralised/)
![NLnet](https://nlnet.nl/image/logo_nlnet.svg)

*** UNDER CONSTRUCTION ***

# Peppol for the masses!

<img src="https://github.com/pondersource/peppol-php/blob/main/docs/pics/connectyoutbooks.png?raw=true" width="500"/>

## Summary
Peppol is an EU-backed e-Invoicing network which uses a top-down certification infrastructure to establish trust between the sender and the receiver of an invoice.
In the "Peppol for the Masses!" project, we will implement Peppol in PHP (so far only Java and C# implementations are available), and package its core components (the AS4 sender and the AS4 receiver) as a Nextcloud app, so that users of the popular Nextcloud personal cloud server can send and receive invoices over AS4 directly into their self-hosted server.

Due to the top-down nature of Peppol's trust infrastructure, it's not possible to self-host a node in the Peppol network unless you go through a reasonably heavy certification process. Therefore, we will extend our implementation with support for self-hosted identities, using the "WebID" identity pattern which was popularized by the Solid project. We will also develop a re-signing gateway which replaces the signature on an AS4-Direct invoice with a Peppol-certified signature. In a follow-up project, we will also host an instance of this re-signing gateway and make it available free of charge, similar to how the LetsEncrypt project has made TLS certificates available free of charge.

This project will lower the (cost) barrier for machine-readable cryptographically-signed e-Invoicing messages, and at the same time increase the sovereignty of end-users, towards a human-centric internet of business documents.

## How it works
The popular EU-backed e-invoicing network "Peppol" requires both the sender and the receiver to connect through a licensed gateway.

This has obvious drawbacks:
* only registered legal entities from the 39 participating governments can currently benefit from Peppol
* identity management is top-down and in the hands of the certified gateways
* these gateways often charge hundreds of euros per month for a connection
* they can see and alter the unencrypted contents of all your incoming and outgoing invoices

We propose a hybrid system, implementing all of standard Peppol, but additionally supporting self-hosted identities. If the sender and/or the receiver is a standard Peppol node, Peppol will be used as usual:

sender (c1) -> sendingGateway (c2) -> receivingGateway (c3) -> receiver (c4)

But if both the sender and the receiver are hybrid nodes, and the invoice sender is a trusted supplier of the receiver, the invoice can be sent directly over end-to-end encrypted https:

sender (c1) -(https)-> receiver (c4)

Our implementation will allow both the sender and the receiver to publish their identity at a well-known URL, under the company domain names as linked in the XML invoice.

## Running in Docker testnet

Get an Ubuntu server and install Docker. Clone this repo and `cd` into it. Then, to demonstrate Java -> PHP:

```sh
./scripts/gencerts.sh
./scripts/rebuild.sh
./scripts/transportp12.sh
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
```

To generate PHP -> Java:
```
./scripts/gencerts.sh
./scripts/rebuild.sh
docker network create testnet
export PEPPOL_PHP_DIR=`pwd`
./scripts/start-from-Nextcloud.sh
./scripts/start-to-Phase4.sh
```

To show milestone 4, prepare with:
```
./scripts/gencerts.sh
./scripts/rebuild.sh
./scripts/transportp12.sh
docker network create testnet
export PEPPOL_PHP_DIR=`pwd`
```
Then run:

```
./scripts/start-to-Phase4.sh
./scripts/start-re-signing-gateway.sh
docker run --name=client -e "AS4_END_POINT=http://re-signing-gateway.docker" --network=testnet phase4-client
docker container cp client:/root/phase4/phase4-peppol-client/phase4-dumps .
docker container cp server:/root/phase4/phase4-peppol-server-webapp/phase4-data/as4dump .
cat phase4-dumps/outgoing/*/*/*/*.as4response
# clean up for next run:
docker rm client
rm -rf phase4-dumps
```

To run c2.pondersource.net (and similar for c3.pondersource.net):
```sh
mkdir -p tls
./scripts/build-for-testbed.sh
docker network create testnet
export PEPPOL_PHP_DIR=`pwd`
./scripts/run-testbed-node-c2.sh
```
