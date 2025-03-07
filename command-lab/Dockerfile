FROM php:8.2-apache

# Install required tools
RUN apt update && apt install -y binutils

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Create private directory and set the flag
RUN mkdir -p /var/www/private
COPY flag.txt /var/www/private/flag.txt

# Copy site files
COPY index.php /var/www/html/
COPY vuln.php /var/www/html/

# Create a fake-looking flag.txt (symbolic link)
RUN ln -s /var/www/private/flag.txt /var/www/html/flag.txt

# Secure permissions
RUN chown -R www-data:www-data /var/www/private \
    && chmod 700 /var/www/private \
    && chmod 600 /var/www/private/flag.txt

# Block direct HTTP access to /private folder
RUN echo '<Directory "/var/www/private">\n Require all denied\n</Directory>' > /etc/apache2/conf-available/block-private.conf \
    && a2enconf block-private

EXPOSE 80
CMD ["apache2-foreground"]
