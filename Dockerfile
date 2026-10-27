FROM php:8.2-fpm-alpine

# Pasang kelengkapan sistem & SQLite
RUN apk add --no-cache nginx sqlite-dev git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Ambil Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Salin semua fail projek (termasuk database.sqlite yang siap diisi)
COPY . /var/www/html

# Pasang dependency Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Berikan kebenaran capaian kepada direktori Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Konfigurasi Nginx
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { fastcgi_pass 127.0.0.1:9000; fastcgi_index index.php; include fastcgi_params; fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; } \
}' > /etc/nginx/http.d/default.conf

EXPOSE 80

# Jalankan PHP-FPM dan Nginx
CMD php-fpm -D && nginx -g 'daemon off;'