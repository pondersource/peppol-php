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

# image for nc1:
cd ../nc1
docker build -t nc1 .

# image for nc2:
cd ../nc2
docker build -t nc2 .
