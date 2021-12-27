## This documents my experiments with phase4 trying to figure out curl commands and data to generate valid peppol requests.

To do this yourself, grab the non-certificate phase4 source at http://github.com/br0kk0l1/phase4, build it and then from phase4/phase4-peppol-server-webapp run src/test/java/com/helger/phase4/peppol/server/standalone/RunInJettyPHASE4PEPPOL.java, which will start a jettyserver on localhost:8080 with an as4 endpoint at localhost:8080/as4

as of now, i'm at

```curl -X POST -H 'Content-type: application/xml' http://localhost:8080/as4 -d "@request.xml" > return.xml```

which returns return.xml, so it seems the request is at least well-formed if still not compliant. The empty header certainly seems kinda weird for now, so that's something that probably needs to be rectified. The Invoice xml should probably be correct, as it comes from the openPeppol sample files.