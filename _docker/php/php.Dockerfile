FROM php:fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    zip unzip \
    git && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    pecl install redis && docker-php-ext-enable redis && \
    docker-php-ext-install zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/laravel
