#!/bin/bash
set -e

function fetch() {
  echo fetching $1
  curl -X 'GET' \
  "https://developers.kvk.nl/test/api/v1/basisprofielen/$1/hoofdvestiging?geoData=false" \
  -H 'accept: application/hal+json' > $1.json
}


fetch 69599084
fetch 90004973
fetch 68727720
fetch 90004760
fetch 68750110
fetch 90001354
fetch 90006577
fetch 69599068
fetch 90000102
fetch 90006623
fetch 69599076
fetch 90005414
fetch 55344526
fetch 90002520
fetch 90002490
fetch 90002903
fetch 90000749
fetch 90001745
fetch 90003942
fetch 55505201
