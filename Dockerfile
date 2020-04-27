FROM composer
WORKDIR /app
COPY . /app
RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo pdo_mysql
CMD bash -c "composer install && php -S [::]:80 -t /app/public"