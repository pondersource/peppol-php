FROM ubuntu

RUN apt update
RUN apt install git openjdk-8-jdk maven -y
RUN cd /root && git clone https://github.com/pondersource/phase4.git
RUN mkdir /root/phase4/phase4-peppol-server-webapp/keys
RUN /usr/lib/jvm/java-8-openjdk-amd64/bin/keytool -genkeypair -keystore /root/phase4/phase4-peppol-server-webapp/keys/test.p12 -storetype PKCS12 -storepass peppol -alias "pondersource" -keyalg RSA -keysize 2048 -validity 99999 -dname "CN=My SSL Certificate, OU=My Team, O=My Company, L=My City, ST=My State, C=SA" -ext san=dns:nimladris,dns:localhost,ip:127.0.0.1
RUN cd /root/phase4 && mvn install
