#!/bin/bash
set -e

# Vérifier si le fichier .env existe, sinon le créer à partir des variables d'environnement
if [ ! -f ".env" ]; then
    echo "Création du fichier .env..."
    cat > .env << EOF
# MySQL Database
DB_HOST=${DB_HOST}
DB_NAME=${DB_NAME}
DB_USER=${DB_USER}
DB_PASS=${DB_PASS}
DB_CHARSET=${DB_CHARSET}

JSONBIN_ID=${JSONBIN_ID}
JSONBIN_API_KEY=${JSONBIN_API_KEY}

# SMTP (Email)
SMTP_HOST=${SMTP_HOST:-smtp.gmail.com}
SMTP_USER=${SMTP_USER:-testing.projets.siteweb@gmail.com}
SMTP_PASS=${SMTP_PASS:-sljw jlop qtyy mqae}

# reCAPTCHA
RECAPTCHA_SITE_KEY=${RECAPTCHA_SITE_KEY:-6LdAc-kqAAAAANs2nj1AU5JIpr6l8o2uTaS-X2Y5}
RECAPTCHA_SECRET_KEY=${RECAPTCHA_SECRET_KEY:-6LdAc-kqAAAAAFX0eAY41GE59Jj5zzeVwPDGuvSb}

# Debug Mode
DEBUG=${DEBUG:-true}
EOF
fi

# Si le dossier vendor n'existe pas, installer les dépendances
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "Installation des dépendances Composer..."
    composer install --no-interaction
fi

# Démarrer Apache en premier plan
exec apache2-foreground