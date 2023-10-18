FROM php:8.1-fpm-alpine

RUN apk update && apk add \
    git \
    unzip \
    libpq-dev \
    curl \
    bash \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./back /var/www/html

WORKDIR /var/www/html

RUN composer install

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

EXPOSE 3000
CMD php-fpm
