FROM node
RUN apt update && apt install -yq vim
ADD . /app
WORKDIR /app
ENV NODE_TLS_REJECT_UNAUTHORIZED=0
CMD node index.mjs
