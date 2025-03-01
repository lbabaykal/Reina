FROM node:lts-bookworm

# Install dependencies
RUN apt update && apt install -y \
    vim \
    zip \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/reina
