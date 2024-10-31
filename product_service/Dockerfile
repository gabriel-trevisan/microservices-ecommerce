# Use a imagem oficial do PHP com FPM
FROM php:8.1-fpm

# Instale as extensões necessárias para o Lumen
RUN docker-php-ext-install pdo pdo_mysql

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie o código do projeto para o container
COPY . /var/www

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instale as dependências do Lumen
RUN composer install --no-dev

# Conceda permissões apropriadas à pasta de cache e logs (se necessário)
RUN chown -R www-data:www-data /var/www/storage

# Exponha a porta padrão do PHP-FPM
EXPOSE 9000

CMD [ "php", "-S", "0.0.0.0:9000", "-t", "public" ]
