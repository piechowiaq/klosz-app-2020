FROM php:8.0.1-fpm
RUN apt-get update && apt-get install -y \
    wget \
    nano \
    vim \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
        zip \
        pdo \
        pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY .docker/php/conf.d/php.ini $PHP_INI_DIR/conf.d/php.ini
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
COPY . /var/www
COPY --chown=www:www . /var/www
USER www
EXPOSE 9000
CMD ["php-fpm"]
