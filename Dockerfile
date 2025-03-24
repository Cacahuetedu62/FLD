FROM php:8.0-apache

# Installation des dépendances et extensions PHP
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql zip \
    && a2enmod rewrite headers

# Configuration PHP - Nous allons créer le fichier directement ici au lieu de le copier
RUN echo '; Paramètres généraux\n\
max_execution_time = 60\n\
memory_limit = 256M\n\
upload_max_filesize = 20M\n\
post_max_size = 20M\n\
date.timezone = Europe/Paris\n\
\n\
; Sécurité\n\
display_errors = On\n\
display_startup_errors = On\n\
log_errors = On\n\
error_reporting = E_ALL' > /usr/local/etc/php/conf.d/app.ini

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de dépendances
COPY composer.json composer.lock ./

# Permet d'installer les dépendances sans les scripts
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

# Copie de tous les fichiers du projet
COPY . .

# Finalisation de l'installation Composer
RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data /var/www/html

# Création du script de démarrage directement dans le conteneur
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Vérifier si le fichier .env existe, sinon le créer à partir des variables d\'environnement\n\
if [ ! -f ".env" ]; then\n\
    echo "Création du fichier .env..."\n\
    cat > .env << EOF\n\
# MySQL Database\n\
DB_HOST=${DB_HOST:-localhost}\n\
DB_NAME=${DB_NAME:-u301331392_fld_agencement}\n\
DB_USER=${DB_USER:-u301331392_Aurore}\n\
DB_PASS=${DB_PASS:-BDDfld2024}\n\
DB_CHARSET=${DB_CHARSET:-utf8mb4}\n\
\n\
JSONBIN_ID=${JSONBIN_ID:-67cad7ebad19ca34f8181587}\n\
JSONBIN_API_KEY=${JSONBIN_API_KEY:-\\$2a\\$10\\$3LK.3X/MjuBXf3HH9BguX.lHI82bVxI.lBubn0438cAAWxnfzCydq}\n\
\n\
# SMTP (Email)\n\
SMTP_HOST=${SMTP_HOST:-smtp.gmail.com}\n\
SMTP_USER=${SMTP_USER:-testing.projets.siteweb@gmail.com}\n\
SMTP_PASS=${SMTP_PASS:-sljw jlop qtyy mqae}\n\
\n\
# reCAPTCHA\n\
RECAPTCHA_SITE_KEY=${RECAPTCHA_SITE_KEY:-6LdAc-kqAAAAANs2nj1AU5JIpr6l8o2uTaS-X2Y5}\n\
RECAPTCHA_SECRET_KEY=${RECAPTCHA_SECRET_KEY:-6LdAc-kqAAAAAFX0eAY41GE59Jj5zzeVwPDGuvSb}\n\
\n\
# Debug Mode\n\
DEBUG=${DEBUG:-true}\n\
EOF\n\
fi\n\
\n\
# Si le dossier vendor n\'existe pas, installer les dépendances\n\
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then\n\
    echo "Installation des dépendances Composer..."\n\
    composer install --no-interaction\n\
fi\n\
\n\
# Démarrer Apache en premier plan\n\
exec apache2-foreground' > /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Exposition du port 80
EXPOSE 80

# Définition du point d'entrée
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]