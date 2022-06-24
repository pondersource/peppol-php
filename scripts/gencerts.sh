#!/bin/bash
set -e

mkdir -p tls
function createCert {
  echo Generating key and CSR for $1.docker
  openssl req -new -nodes \
    -out ./tls/$1.csr \
    -keyout ./tls/$1.key \
    -subj "/C=RO/ST=Bucharest/L=Bucharest/O=IT/CN=$1.docker"
  echo Creating extfile
  echo "subjectAltName = @alt_names" > ./tls/$1.cnf
  echo "[alt_names]" >> ./tls/$1.cnf
  echo "DNS.1 = $1.docker" >> ./tls/$1.cnf

  echo Signing CSR for $1.docker, creating cert.
  openssl x509 -req -days 365 -in ./tls/$1.csr \
    -CA ./tls/ocm-ca.crt -CAkey ./tls/ocm-ca.key -CAcreateserial \
    -out ./tls/$1.crt -extfile ./tls/$1.cnf
}

echo Generating CA key
openssl genrsa -out ./tls/ocm-ca.key 2058
echo Generate CA self-signed certificate
openssl req -new -x509 -days 365 \
    -key ./tls/ocm-ca.key \
    -out ./tls/ocm-ca.crt \
    -subj "/C=RO/ST=Bucharest/L=Bucharest/O=IT/CN=ocm-ca"

createCert nc1
createCert nc2
