#!/bin/bash
set -e
docker run -v `pwd`/p12transport:/p12transport client cp /root/phase4/phase4-peppol-server-webapp/keys/test.p12 /p12transport/
docker run -v `pwd`/p12transport:/p12transport client cp /root/sender.cer /p12transport/
