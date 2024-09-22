FROM php:8.3-fpm-alpine

RUN docker-php-ext-install pdo_mysql opcache

#####################################
# Install Composer
#####################################
COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache $PHPIZE_DEPS

RUN apk add --no-cache git unzip

RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && architecture=$(uname -m) \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/$architecture/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8307\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

COPY opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

# Set working directory
ENV APP_PATH=/var/www/html
WORKDIR $APP_PATH

#####################################
# Permission fix
#####################################
#RUN chsh www-data -s /usr/sbin/nologin
#RUN usermod -u $USER_ID www-data
#USER www-data

# Copy application files
COPY --chown=www-data:www-data . .

EXPOSE 9000
CMD ["php-fpm"]
