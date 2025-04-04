FROM php:8.3-apache

RUN apt-get update; apt install -y openssl zip unzip git
RUN apt clean; rm -rf /var/lib/apt/lists/*

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql bcmath opcache intl apcu imap tidy xsl zip curl odbc sqlite3

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html
WORKDIR /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el script de entrada y darle permisos
COPY entrypoint.sh /entrypoint.sh
RUN apt-get update && apt-get install -y dos2unix && dos2unix /entrypoint.sh && chmod +x /entrypoint.sh
# Definir el entrypoint
ENTRYPOINT ["/entrypoint.sh"]
