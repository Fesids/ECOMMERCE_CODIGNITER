FROM php:7.4-fpm



RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip



RUN mkdir -p /var/www/html/application/sessions \
    && chown -R www-data:www-data /var/www/html/application/sessions \
    && chmod -R 755 /var/www/html/application/sessions


RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/custom.ini /usr/local/etc/php/conf.d/


WORKDIR /var/www/html

COPY . .


RUN chown -R www-data:www-data /var/www/html