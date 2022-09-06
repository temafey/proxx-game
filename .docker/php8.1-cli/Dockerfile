ARG PHP_VER

FROM php:${PHP_VER}-cli-alpine
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk update && \
    apk add --no-cache bash && \
    apk add --no-cache build-base && \
    apk add --no-cache autoconf && \
    apk add --no-cache automake && \
    apk add --no-cache openssl && \
    apk add --no-cache openssl-dev && \
    apk add --no-cache curl && \
    apk add --no-cache git && \
    apk add --no-cache libmcrypt-dev && \
    apk add --no-cache curl

# php settings
ADD conf.ini /usr/local/etc/php/conf.d/
RUN chmod +r /usr/local/etc/php/conf.d/conf.ini

##################
# section PHP Extensions
##################

RUN pear list-upgrades && pear update-channels && \
    install-php-extensions bcmath intl opcache zip uuid yaml pdo_pgsql

##################
## endsection
##################

# php settings
ADD conf.ini /usr/local/etc/php/conf.d/
RUN chmod +r /usr/local/etc/php/conf.d/conf.ini

