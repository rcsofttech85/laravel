FROM surnet/alpine-wkhtmltopdf:3.16.2-0.12.6-full AS wkhtmltopdf
FROM php:8.2-fpm-alpine3.18 AS base
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN apk add --no-cache \
        bash \
		acl \
		fcgi \
		file \
		gettext \
		git \
        yarn \
        libstdc++ \
        libx11 \
        libxrender \
        libxext \
        libssl1.1 \
        ca-certificates \
        fontconfig \
        freetype \
        ttf-droid \
        ttf-freefont \
        ttf-liberation \
        nodejs \
        npm \
	;
RUN set -eux; \
    install-php-extensions \
        	apcu \
        	intl \
    		opcache \
        	zip \
            redis \
            pdo_sqlite \
            pdo_mysql\
            amqp \
            ldap \
            xsl \
            ;
# wkhtmltopdf copy bins from ext image
COPY --from=wkhtmltopdf /bin/wkhtmltopdf /bin/libwkhtmltox.so /bin/
	    
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/var/www/.composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} rahul || true \
    && adduser -u ${UID} -G rahul -h /var/www -D rahul || true

COPY ./laravel /var/www/laravel

RUN chown -R rahul:rahul /var/www/laravel \
    && chmod -R 775 /var/www/laravel

WORKDIR /var/www/laravel

USER rahul




FROM base AS prod

ENV APP_ENV=production
RUN composer install --no-dev --no-interaction --no-scripts --optimize-autoloader

FROM base AS dev
ENV APP_ENV=local
RUN composer install --no-interaction --no-scripts && \
    npm install && \
    npm run dev