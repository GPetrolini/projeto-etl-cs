# Usar a imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache


RUN docker-php-ext-install pdo pdo_mysql

# Habilitar o mod_rewrite do Apache para URLs amigáveis (boa prática)
RUN a2enmod rewrite

# Copiar o código da aplicação para o diretório do Apache
COPY ./src /var/www/html/