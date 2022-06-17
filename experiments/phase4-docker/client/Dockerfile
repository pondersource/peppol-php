FROM f34c616326ae

RUN /usr/lib/jvm/java-8-openjdk-amd64/bin/keytool -exportcert -alias pondersource -storepass peppol -keystore /root/phase4/phase4-peppol-server-webapp/keys/test.p12 -file /root/phase4/phase4-peppol-client/certificate.cer
RUN /usr/lib/jvm/java-8-openjdk-amd64/bin/keytool -genkeypair -keystore /root/phase4/phase4-peppol-client/test-ap-2021.p12 -storetype PKCS12 -storepass peppol -alias "openpeppol aisbl id von pop000306" -keyalg RSA -keysize 2048 -validity 99999 -dname "CN=My SSL Certificate, OU=My Team, O=My Company, L=My City, ST=My State, C=SA" -ext san=dns:nimladris,dns:localhost,ip:127.0.0.1

WORKDIR /root/phase4/phase4-peppol-client

ADD run.sh ./run.sh

CMD run.sh
