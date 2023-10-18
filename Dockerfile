# Utilisez une image de base PHP adaptée à vos besoins.
# Pour cet exemple, nous utiliserons une image PHP avec Apache.
FROM php:8.1-apache

# Installez les extensions PHP requises et autres outils nécessaires.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Installez Composer globalement dans l'image.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiez les fichiers de votre projet Symfony dans le conteneur.
COPY ./back /var/www/html

# Définissez le répertoire de travail.
WORKDIR /var/www/html

# Installez les dépendances de votre projet Symfony avec Composer.
RUN composer install

# Exposez le port 80.
EXPOSE 80

# Utilisez le serveur web intégré de Symfony pour lancer votre application.
CMD ["symfony", "server:start", "--no-tls", "--port=80"]
