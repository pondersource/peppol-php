#!/bin/bash
set -e

# base image for nextcloud image and owncloud image:
cd docker/apache-php
cp -r ../../tls .
docker build -t apache-php .

# base image for nc1 image and nc2 image:
cd ../nextcloud
# docker build -t nextcloud --build-arg CACHEBUST=`date +%s` .
docker build -t nextcloud .

# image for c2:
cd ../c2
docker build -t c2 .

# image for c3:
cd ../c3
docker build -t c3 .

cd ../..
docker pull mariadb
