# Usar imagen de PHP con Apache
FROM php:8.1-apache

# Instalar dependencias de Laravel
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del backend
COPY backend/ .

# Instalar dependencias de Laravel
RUN composer install

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
