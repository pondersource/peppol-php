FROM apache-php
RUN apt install -y zip
RUN rm -rf /var/www/html
USER www-data
WORKDIR /var/www
RUN git clone --depth=1 --branch dynamic-shareproviders https://github.com/pondersource/server --recursive --shallow-submodules
# See https://github.com/moby/moby/issues/1996#issuecomment-185872769 for explanation of cachebust.
# If the dynamic-shareproviders of nextcloud is stable, but nc-sciencemesh is not,
# you can also move the CACHEBUST line down to that step.
ARG CACHEBUST=1
RUN cd server && git pull
RUN mv server html
WORKDIR /var/www/html
ENV PHP_MEMORY_LIMIT="512M"
ADD init.sh /init.sh
RUN git clone --depth=1 https://github.com/pondersource/nc-sciencemesh apps/sciencemesh
RUN cd apps/sciencemesh && git pull
RUN cd apps/sciencemesh && make
USER root
