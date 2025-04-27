FROM php:fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libavif-dev \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap

# Конфигурация GD
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-avif && docker-php-ext-install gd

# Установка Redis
RUN pecl install redis && docker-php-ext-enable redis

# Установка Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Очистка
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/reina
