FROM php:8.1-fpm

# Install required extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY src/ /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

CMD ["php-fpm"]
