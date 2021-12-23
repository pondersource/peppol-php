curl -X POST -H 'Content-Type: application/xml' http://localhost:8080/as4 -d "@request.xml" > response.xml && xmllint --format response.xml > return.xml && rm response.xml
