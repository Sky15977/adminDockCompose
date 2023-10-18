FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./back /var/www/html

WORKDIR /var/www/html

RUN composer install

EXPOSE 8000

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

CMD ["symfony", "server:start", "--no-tls", "--port=8000"]
