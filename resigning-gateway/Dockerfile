FROM apache-php
ADD . /var/www/html
WORKDIR /var/www/html
RUN make composer
ENV HOST=resigning-gateway
RUN ln -s /tls/$HOST.crt /tls/server.cert
RUN ln -s /tls/$HOST.key /tls/server.key
RUN a2enmod rewrite