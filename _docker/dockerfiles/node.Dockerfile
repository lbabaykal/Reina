FROM node:22-alpine

# Install dependencies
RUN apk update && apk add --no-cache \
    vim \
    zip \
    unzip \
    curl

WORKDIR /var/www/laravel
