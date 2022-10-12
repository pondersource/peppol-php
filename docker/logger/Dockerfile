FROM node
RUN apt update && apt install -yq vim
ADD . /app
WORKDIR /app
CMD node index.mjs
