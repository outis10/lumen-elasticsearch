FROM php:7.3-fpm

RUN apt-get update
RUN apt-get install -y libssl-dev \
    libcurl4-openssl-dev \
    git \
    libpq-dev \
    zip \
    unzip \
    libzip-dev \
    libzip4


RUN pecl install xdebug

RUN docker-php-ext-enable xdebug
RUN docker-php-ext-install -j$(nproc) zip

RUN rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer
