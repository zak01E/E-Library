#!/bin/bash

echo "========================================"
echo "Installation de E-Library"
echo "========================================"
echo ""

echo "Étape 1: Création de la base de données..."
echo "Veuillez vous assurer que MySQL est démarré."
echo ""

# Demander les informations de connexion MySQL
read -p "Entrez votre nom d'utilisateur MySQL (par défaut: root): " MYSQL_USER
MYSQL_USER=${MYSQL_USER:-root}

read -sp "Entrez votre mot de passe MySQL (appuyez sur Entrée si vide): " MYSQL_PASS
echo ""

# Créer la base de données
echo ""
echo "Création de la base de données..."
if [ -z "$MYSQL_PASS" ]; then
    mysql -u $MYSQL_USER < setup-database.sql
else
    mysql -u $MYSQL_USER -p$MYSQL_PASS < setup-database.sql
fi

if [ $? -ne 0 ]; then
    echo ""
    echo "ERREUR: Impossible de créer la base de données."
    echo "Vérifiez que MySQL est démarré et vos identifiants sont corrects."
    exit 1
fi

echo ""
echo "Base de données créée avec succès!"
echo ""

echo "Étape 2: Installation des dépendances Composer..."
echo ""
composer install

if [ $? -ne 0 ]; then
    echo ""
    echo "ERREUR: Impossible d'installer les dépendances Composer."
    echo "Vérifiez que Composer est installé correctement."
    exit 1
fi

echo ""
echo "Étape 3: Exécution des migrations..."
echo ""
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo ""
    echo "ERREUR: Impossible d'exécuter les migrations."
    exit 1
fi

echo ""
echo "Étape 4: Création du lien de stockage..."
echo ""
php artisan storage:link

echo ""
echo "Étape 5: Peuplement de la base de données..."
echo ""
php artisan db:seed

echo ""
echo "Étape 6: Installation des dépendances NPM..."
echo ""
npm install

if [ $? -ne 0 ]; then
    echo ""
    echo "ERREUR: Impossible d'installer les dépendances NPM."
    echo "Vérifiez que Node.js et NPM sont installés."
    exit 1
fi

echo ""
echo "Étape 7: Construction des assets..."
echo ""
npm run build

echo ""
echo "========================================"
echo "Installation terminée avec succès!"
echo "========================================"
echo ""
echo "Vous pouvez maintenant accéder à l'application sur:"
echo "http://localhost/E-Library/public"
echo ""
echo "Comptes de test:"
echo "- Admin: admin@elibrary.com / password"
echo "- Auteur: author@elibrary.com / password"
echo "- Utilisateur: user@elibrary.com / password"
echo ""