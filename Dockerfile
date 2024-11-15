FROM php:8.1-fpm

# Installez les extensions PHP nécessaires pour Symfony
RUN apt-get update && apt-get install -y libzip-dev libicu-dev && \
    docker-php-ext-install zip intl pdo pdo_mysql && \
    docker-php-ext-enable pdo_mysql

# Copie des fichiers de configuration PHP personnalisés
COPY ./docker/php/conf.d /usr/local/etc/php/conf.d

# Définir le répertoire de travail
WORKDIR /var/www/html
