FROM composer
WORKDIR /app
RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo pdo_mysql
#ENTRYPOINT "composer dump-autoload -o" && /bin/bash
ENTRYPOINT "composer install" && /bin/bash