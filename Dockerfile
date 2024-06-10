FROM php:8.3-fpm

# Install system dependencies
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

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql intl mbstring xml zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install application dependencies
RUN composer install --prefer-dist --no-progress --no-suggest

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

