FROM php:8.5-fpm-bookworm

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip openssh-client curl ca-certificates gnupg nginx supervisor \
    jpegoptim optipng pngquant webp \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql pdo_pgsql zip gd intl mbstring xml bcmath exif pcntl redis imagick brotli

RUN mkdir -p /usr/src/php/ext/xdebug \
    && curl -fsSL https://github.com/xdebug/xdebug/archive/refs/tags/3.5.1.tar.gz | tar xvz -C /usr/src/php/ext/xdebug --strip-components=1 \
    && docker-php-ext-install xdebug

RUN curl -fsSL https://bun.sh/install | BUN_INSTALL=/usr/local bash \
    && chmod +x /usr/local/bin/bun

RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY fpm-pool.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm /etc/nginx/sites-enabled/default

RUN groupadd -g 1000 laravel && useradd -u 1000 -ms /bin/bash -g laravel laravel
RUN mkdir -p /var/run/php /var/log/supervisor /var/run/supervisor \
    && chown -R laravel:www-data /var/www/html /var/lib/nginx /var/log/nginx /var/run/php /var/run/supervisor

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
