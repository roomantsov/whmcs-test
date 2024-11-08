FROM php:8.3

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .
RUN composer install --no-interaction
RUN mkdir -p var/data

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "index.php"]