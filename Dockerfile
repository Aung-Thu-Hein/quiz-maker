FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmagickwand-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev

RUN docker-php-source extract

RUN docker-php-ext-install -j "$(nproc)" \ 
    pdo \
    pdo_mysql \
    mysqli \
    bcmath \
    exif \
    gd \
    intl \
    zip

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-source delete

COPY ./ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
