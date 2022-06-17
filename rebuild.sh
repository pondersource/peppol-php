#!/bin/bash
set -e

# base image for nextcloud image and owncloud image:
cd docker/apache-php
cp -r ../../tls .
docker build -t apache-php .

# base image for nc1 image and nc2 image:
cd ../ncp
# docker build -t ncp --build-arg CACHEBUST=`date +%s` .
docker build -t ncp .

# image for ncp1:
cd ../ncp1
docker build -t ncp1 .

# image for ncp2:
cd ../ncp2
docker build -t ncp2 .
