FROM php:8.1-apache-bookworm

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    nodejs \
    npm \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de Node.js y ejecutar build si es necesario
RUN npm install && npx gulp build 2>/dev/null || true

# Instalar dependencias de PHP si hay composer.json
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && chown -R www-data:www-data /var/www/html

# Copiar y configurar entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]