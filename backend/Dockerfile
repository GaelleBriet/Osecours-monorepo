# Utilisation d'une image PHP.
FROM php:8.2-apache

# Copie du fichier de configuration Apache.
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/

# Copie du code source de l'application.
COPY ./ /var/www/html

# Mise à jour de la liste des paquets et installation des bibliothèques/logiciels nécessaires.
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    git \
    zsh \
    unzip

# Installation des extensions PHP nécessaires, y compris pdo_pgsql pour PostgreSQL.
RUN docker-php-ext-install pdo_pgsql dom xml mbstring pdo_mysql zip

# Installation de Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# Installation de Oh My Zsh.
RUN sh -c "$(curl -fsSL https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"

# Création d'un alias pour PHP Artisan.
RUN echo 'alias @="php artisan"' >> ~/.zshrc
RUN echo 'alias @="php artisan"' >> ~/.bashrc

# Activation de la réécriture d'URL pour Apache.
RUN a2enmod rewrite
WORKDIR /var/www/html
RUN composer install --optimize-autoloader
