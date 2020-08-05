FROM php:7.4-fpm

WORKDIR /app

RUN useradd -s /bin/bash -d /home/worker/ -m -G sudo worker \
    ## update
    && apt-get -y update \
    && apt-get -y upgrade \
    ## install soft
    && apt-get install -y \
        curl \
        git \
    ## install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    ## install symfony/cli
    && curl -sS https://get.symfony.com/cli/installer | bash -s -- --install-dir=/usr/local/bin

USER worker
