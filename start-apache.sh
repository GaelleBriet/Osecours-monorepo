#!/usr/bin/env bash

# Désactiver tous les MPM par défaut
a2dismod mpm_event mpm_worker mpm_prefork

# Activer mpm_prefork
a2enmod mpm_prefork

# Démarrer Apache
apache2-foreground
