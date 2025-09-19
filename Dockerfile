FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies
RUN apk update && apk add --no-cache \
    nginx \
    sqlite-dev \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    unzip \
    oniguruma-dev \
    libxml2-dev \
    linux-headers

# Install PHP extensions, including pdo_sqlite
RUN docker-php-ext-install -j$(nproc) \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    sockets

# Copy application code into the container
COPY . /var/www/html

# Copy the Composer executable and install application dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Create the SQLite database file and set permissions

# Expose port 8000 for PHP-FPM
EXPOSE 8000

# Start PHP-FPM
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
# CMD ["php", "artisan", "serve"]
