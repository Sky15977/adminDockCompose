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
        autoconf \
        $PHPIZE_DEPS \
        libstdc++ \
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
	;

RUN	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		intl \
		pgsql \
		pdo_pgsql \
		zip \
		xsl \
	; \
	pecl install \
		pcov \
        xdebug \
	; \
	pecl clear-cache;

RUN docker-php-ext-enable opcache

RUN docker-php-ext-enable xdebug

RUN runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

# XDEBUG CONFIGURATION
ARG XDEBUG_REMOTE_HOST=172.17.0.1
ARG XDEBUG_REMOTE_PORT=10010
ARG XDEBUG_REMOTE_CONNECT_BACK=0
ARG XDEBUG_START_WITH_REQUEST=on
ARG XDEBUG_INI=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /var/log/xdebug.log
RUN chmod -R 777 /var/log

RUN echo "\r\rEnabling XDEBUG ? ${XDEBUG_START_WITH_REQUEST}\r\r"

RUN echo -e "error_reporting=E_ALL\n" >> ${XDEBUG_INI} \
    "display_startup_errors=1\n" >> ${XDEBUG_INI} \
    "display_errors=1\n" >> ${XDEBUG_INI} \
    "xdebug.mode=coverage,debug,profile\n" >> ${XDEBUG_INI} \
    "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}\n" >> ${XDEBUG_INI} \
    "xdebug.discover_client_host=${XDEBUG_REMOTE_CONNECT_BACK}\n" >> ${XDEBUG_INI} \
    "xdebug.idekey=\"PHPSTORM\"\n" >> ${XDEBUG_INI} \
    "xdebug.remote_handler=dbgp\n" >> ${XDEBUG_INI} \
    "xdebug.client_port=${XDEBUG_REMOTE_PORT}\n" >> ${XDEBUG_INI} \
    "xdebug.client_host=${XDEBUG_REMOTE_HOST}\n" >> ${XDEBUG_INI} \
    "xdebug.log_level=10\n" >> ${XDEBUG_INI} \
    "xdebug.log=/var/log/xdebug.log\n" >> ${XDEBUG_INI}

# COMPOSER INSTALLATION
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE ${XDEBUG_REMOTE_PORT}

# EXORT COMPOSER GLOBAL PATH
ENV PATH="$PATH:$HOME/.composer/vendor/bin"