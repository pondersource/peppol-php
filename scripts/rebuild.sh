#!/bin/bash
set -e

cd docker/phase4-mutual
docker build -t phase4-mutual .

cd ../phase4-client
docker build -t phase4-client .

cd ../phase4-server
docker build -t phase4-server .

# base image for nextcloud image and owncloud image:
cd ../apache-php
cp -r ../../tls .
docker build -t apache-php .

# base image for nc1 image and nc2 image:
cd ../nextcloud
# docker build -t nextcloud --build-arg CACHEBUST=`date +%s` .
docker build -t nextcloud .

# image for nc1:
cd ../nc1
docker build -t nc1 .

# image for nc2:
cd ../nc2
docker build -t nc2 .

# image for resigning-gateway, which lives outside the docker/folder:
cd ../../resigning-gateway
docker build -t resigning-gateway .

# back to th repo root:
cd ..

# will use this as-is:
docker pull mariadb
