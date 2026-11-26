
FROM php:8.3-apache

# Install PHP extensions required by EduCore
RUN apt-get update && apt-get install -y --no-install-recommends libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring \
    && a2enmod rewrite \
    && sed -ri 's/Listen 80/Listen 3000/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:3000>/' /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

# Allow PHP to write uploaded ID-card photos
RUN chown -R www-data:www-data /var/www/html/assets/student-id-photos

EXPOSE 3000

CMD ["apache2-foreground"]
