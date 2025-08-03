FROM php:8.2-fpm

ENV COMPOSER_MEMORY_LIMIT=-1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl unzip git npm libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip \
    netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Install Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app source code
COPY . /var/www/html

# Set proper ownership
RUN chown -R www-data:www-data /var/www/html

# Copy and allow execution of entrypoint script
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Default command
CMD ["php-fpm"]
