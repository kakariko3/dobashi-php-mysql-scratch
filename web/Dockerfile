FROM php:8.1-apache-buster

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
    libicu-dev libonig-dev libzip-dev unzip nodejs && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    # PHP拡張パッケージ
    docker-php-ext-install pdo_mysql mysqli intl zip && \
    # Node.jsパッケージ
    npm install -g npm@latest && \
    npm install -g yarn && \
    npm cache clean --force && \
    # Apache rewriteモジュール有効化
    a2enmod rewrite

COPY ./php.ini /usr/local/etc/php/
COPY ./*.conf /etc/apache2/sites-available/

WORKDIR /var/www/html
