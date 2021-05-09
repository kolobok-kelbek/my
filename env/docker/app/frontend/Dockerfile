FROM node:14

WORKDIR /app

RUN useradd -s /bin/bash -d /home/worker/ -m -G sudo worker \
    ## update
    && apt-get -y update \
    ## install soft
    && apt-get install -y \
        curl \
        git \
        vim \
        htop \
    && npm install -g create-react-app \
    && touch /home/worker/.bash_aliases \
    && chown worker:worker /home/worker/.bash_aliases \
    && echo "alias react='create-react-app'" >> /home/worker/.bash_aliases

USER worker
