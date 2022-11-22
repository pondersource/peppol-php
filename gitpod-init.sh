#!/bin/bash
set -e

./scripts/gencerts.sh
./scripts/rebuild.sh
./scripts/transportp12.sh
docker network create testnet