# Usa la imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Copiar el contenido de tu proyecto en el contenedor
# COPY ./html /var/www/html

# Asegurar que Apache esté habilitado
RUN a2enmod rewrite
