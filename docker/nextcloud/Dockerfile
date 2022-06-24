FROM apache-php
RUN apt update
RUN apt install -y zip nodejs npm
RUN rm -rf /var/www/html
USER www-data
WORKDIR /var/www
RUN git clone --depth=1 --branch dynamic-shareproviders https://github.com/pondersource/server --recursive --shallow-submodules
RUN cd server && git pull
RUN mv server html
WORKDIR /var/www/html
ENV PHP_MEMORY_LIMIT="512M"
ADD init.sh /init.sh
RUN git clone --depth=1 https://github.com/pondersource/peppol-php apps/peppol-php
RUN cd apps && ln -s peppol-php/nextcloud-app/peppolnext



# Installation of NVM, NPM and packages
RUN touch ~/.bashrc && chmod +x ~/.bashrc
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash ;
ENV NODE_VERSION=14
RUN echo 'export NVM_DIR="$HOME/.nvm"'                                       >> "$HOME/.bashrc"
RUN echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> "$HOME/.bashrc"
RUN echo '[ -s "$NVM_DIR/bash_completion" ] && . "$NVM_DIR/bash_completion" # This loads nvm bash_completion' >> "$HOME/.bashrc"
RUN bash -c 'source $HOME/.nvm/nvm.sh   && \
    nvm install $NODE_VERSION && nvm use $NODE_VERSION && nvm alias default $NODE_VERSION';
USER root
RUN npm install -g eslint
USER www-data

# See https://github.com/moby/moby/issues/1996#issuecomment-185872769 for explanation of cachebust.
ARG CACHEBUST=1

# Build the app
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make dev-setup'
# RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make lint'
# RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make build-js-production'
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make test'

RUN cd apps/peppolnext && git pull
USER root
RUN npm install -g eslint
USER www-data
RUN cd apps/peppolnext && make
USER root
