FROM php:8.5-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd pdo pdo_pgsql pgsql intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite headers
COPY Apache.conf /etc/apache2/sites-available/000-default.conf

RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY composer.json composer.lock /var/www/html/

RUN cd /var/www/html && composer install \
    --no-dev \
    --no-progress \
    --no-interaction \
    --optimize-autoloader

COPY . /var/www/html/
RUN rm -f /var/www/html/public/.env \
    && rm -f /var/www/html/public/.gitignore
RUN chown -R www-data:www-data /var/www/html/writable /var/www/html/public
RUN chmod -R 775 /var/www/html/writable
RUN chmod 640 /var/www/html/.env 2>/dev/null || true
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]