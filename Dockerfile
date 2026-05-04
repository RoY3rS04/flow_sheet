FROM serversideup/php:8.5-fpm-nginx

USER root

RUN install-php-extensions exif intl

USER www-data

COPY --chown=www-data:www-data . $APP_BASE_DIR

RUN composer install --no-dev --no-scripts --optimize-autoloader
