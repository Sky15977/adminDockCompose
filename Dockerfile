ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-fpm-alpine

# persistent / runtime deps
RUN apk add --no-cache --update linux-headers \
		acl \
		bash \
		fcgi \
		file \
		openssh-client \
		gettext \
		git \
		yarn \
		supervisor \
        libmcrypt libmcrypt-dev \
        libxml2-dev libxslt-dev freetype-dev libpng-dev libjpeg-turbo-dev \
        zip unzip \
        icu-data-full \
	;

RUN apk update && apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		libzip-dev \
		postgresql-client \
		postgresql-dev \
		zlib-dev \
	; \
	\
	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		intl \
		pgsql \
		pdo_pgsql \
		zip \
		xsl \
	; \
	pecl install \
		pcov \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
		opcache \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

# COMPOSER INSTALLATION
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#EXPOSE ${XDEBUG_REMOTE_PORT}

# EXORT COMPOSER GLOBAL PATH
ENV PATH="$PATH:$HOME/.composer/vendor/bin"