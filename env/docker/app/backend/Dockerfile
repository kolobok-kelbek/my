FROM php:8.0-fpm

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
    ## install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    ## install symfony/cli
    && curl -sS https://get.symfony.com/cli/installer | bash -s -- --install-dir=/usr/local/bin

USER worker
