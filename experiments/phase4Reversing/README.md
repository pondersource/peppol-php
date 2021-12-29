## This documents my experiments with phase4 trying to figure out curl commands and data to generate valid peppol requests.

To do this yourself, grab the non-certificate phase4 source at http://github.com/br0kk0l1/phase4, build it and then from phase4/phase4-peppol-server-webapp run src/test/java/com/helger/phase4/peppol/server/standalone/RunInJettyPHASE4PEPPOL.java, which will start a jettyserver on localhost:8080 with an as4 endpoint at localhost:8080/as4

generate a pkcs12 store via ```keytool -genkeypair -keystore test-ap-2021.p12 -storetype PKCS12 -storepass peppol -alias "openpeppol aisbl id von pop00036" -keyalg RSA -keysize 2048 -validity 99999 -dname "CN=My SSL Certificate, OU=My Team, O=My Company, L=My City, ST=My State, C=SA" -ext san=dns:nimladris,dns:localhost,ip:127.0.0.1```
and for good measure copy it into every resources folder so it will hopefully be found by whatever thing you're trying to run with ```$> for d in $(find -type d -name 'resources'); do cp test-ap-2021.p12 $d; done;```

Then in phase4/phase4-peppol/client run src/test/java/com/helger/phase4/peppol/MainPhase4PeppolSender.java in a debugger, setting a breakpoint in AbstractAS4UserMessageBuilderMIMEPayload.java on line 118 so you can change the value of m_sEndpointURL to "http://localhost:8080/as4" (this value is parsed from an xml that you get from the smp server, so you cannot change it in config or anything afaik, hence using a debugger), so it will send a request to the phase4-peppol-server-webapp.

the resulting request is then stored by the server in phase4-data and can be inpected. (see ./phase4-data/*)

the server is still returning an as4 error message, but my guess is that it's certificate related, i'm now gonna ponder over the phase4-data for a bit to make sense of it as much as i can
