FROM php:8.0-rc-fpm

RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            libzip-dev \
            zip \
            git \
            unzip; \
    rm -rf /var/lib/apt/lists/*

#####################################
# Composer:
#####################################

# Install composer and add its bin to the PATH.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer --version=2.0.0-RC1

###########################################################################
# xDebug:
###########################################################################

ARG INSTALL_XDEBUG=false

RUN mkdir -p /opt/php-libs
# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /opt/php-libs
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    cd /opt/php-libs \
    && git clone https://github.com/xdebug/xdebug \
    && cd xdebug \
    && phpize \
    && ./configure \
    && make all \
    && cp /opt/php-libs/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini \
;fi

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000

USER www-data