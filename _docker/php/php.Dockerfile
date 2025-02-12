FROM php:fpm-bookworm

# Добавление репозитория Sury для PHP и GPG ключа
RUN apt-get update && apt-get install -y \
    apt-utils \
    lsb-release \
    ca-certificates \
    curl \
    gnupg2 \
    && curl -fsSL https://packages.sury.org/php/apt.gpg | tee /etc/apt/trusted.gpg.d/php.asc \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -cs) main" | tee /etc/apt/sources.list.d/php.list \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys B188E2B695BD4743 \
    && apt-get update

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libavif-dev \
    libzip-dev \
    zip unzip \
    git

# Пытаемся установить расширения
RUN docker-php-ext-install bcmath pdo_pgsql

# Конфигурация GD
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-avif && docker-php-ext-install gd

# Установка Redis
RUN pecl install redis && docker-php-ext-enable redis

# Установка Zip
RUN docker-php-ext-install zip

# Очистка
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Копирование конфигурации PHP
COPY ./_docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/laravel
