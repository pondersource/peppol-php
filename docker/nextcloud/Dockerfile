FROM apache-php
RUN apt update
RUN apt install -y zip nodejs npm
RUN rm -rf /var/www/html
USER www-data
WORKDIR /var/www
RUN git clone --depth=1 --branch stable24 https://github.com/nextcloud/server --recursive --shallow-submodules
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

# See https://github.com/moby/moby/issues/1996#issuecomment-185872769 for explanation of cachebust.
ARG CACHEBUST=1

RUN cd apps/peppolnext && git pull
# Build the app
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && npm install'

# See https://github.com/pondersource/peppol-php/issues/125#issuecomment-1167329919
#RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make'
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/peppolnext && make composer'
RUN bash -c 'cd apps/peppolnext && rm -rf vendor/guzzlehttp'
RUN bash -c 'cd apps && git clone https://github.com/nextcloud/groupfolders'
RUN bash -c 'cd apps/groupfolders && git checkout stable24'
RUN bash -c 'source $HOME/.nvm/nvm.sh && nvm install 16 && nvm use 16'
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/groupfolders && nvm use 16 && npm install --save-dev webpack-cli'
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/groupfolders && nvm use 16 && make'
RUN bash -c 'source $HOME/.nvm/nvm.sh && cd apps/groupfolders && nvm use 16 && ../peppolnext/build/tools/composer.phar install'
USER root
RUN npm install -g eslint
