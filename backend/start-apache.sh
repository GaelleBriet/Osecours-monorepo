#!/usr/bin/env bash

# Remplacer le port par la variable d'environnement $PORT définie par Heroku
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
#sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/apache2.conf
#sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf

# Démarrer Apache
apache2-foreground
