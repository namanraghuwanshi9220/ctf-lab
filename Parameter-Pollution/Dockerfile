FROM php:8.2-apache

# Copy challenge files into the container
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80
