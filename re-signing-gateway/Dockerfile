FROM apache-php
ADD . /var/www/html
WORKDIR /var/www/html
RUN composer install
ENV HOST=re-signing-gateway
RUN ln -s /tls/$HOST.crt /tls/server.cert
RUN ln -s /tls/$HOST.key /tls/server.key
RUN a2enmod rewrite
RUN apt install -yq php-soap
RUN sed -i "943 iextension=soap" /etc/php/7.4/apache2/php.ini
RUN sed -i "943 iextension=soap" /etc/php/7.4/cli/php.ini
