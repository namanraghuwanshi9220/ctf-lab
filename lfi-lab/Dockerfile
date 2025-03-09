FROM php:8.2-apache

RUN apt update && apt install -y unzip curl

COPY index.php /var/www/html/
COPY pages/ /var/www/html/pages/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
