FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql intl mbstring xml zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 9000
CMD ["php-fpm"]

