FROM phpdockerio/php:8.2-fpm

ARG TIMEZONE=Europe/Moscow
ENV TZ ${TIMEZONE}
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.2-gd \
        php8.2-intl \
        php8.2-mcrypt \
        php8.2-xdebug \
        php8.2-mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/app"