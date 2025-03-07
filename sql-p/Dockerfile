# Use the official PHP-Apache image
FROM php:8.2-apache

# Install required extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy source files into the container
COPY index.php /var/www/html/
COPY flag.php /var/www/html/
COPY db.php /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
