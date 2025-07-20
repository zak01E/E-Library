# Guide d'installation E-Library

## Prérequis

Avant de commencer l'installation, assurez-vous d'avoir :

1. **XAMPP** installé avec :
   - PHP 8.0 ou supérieur
   - MySQL/MariaDB
   - Apache

2. **Composer** installé globalement

3. **Node.js et NPM** installés (pour la compilation des assets frontend)

## Installation automatique

### Windows

1. Ouvrez XAMPP Control Panel et démarrez **Apache** et **MySQL**

2. Ouvrez une invite de commande en tant qu'administrateur

3. Naviguez vers le dossier du projet :
   ```cmd
   cd C:\Users\zakar\Downloads\Projets digitaux\E-Library
   ```

4. Exécutez le script d'installation :
   ```cmd
   install.bat
   ```

5. Suivez les instructions à l'écran

### Linux/Mac

1. Assurez-vous que MySQL est démarré

2. Ouvrez un terminal

3. Naviguez vers le dossier du projet :
   ```bash
   cd "/mnt/c/Users/zakar/Downloads/Projets digitaux/E-Library"
   ```

4. Rendez le script exécutable et lancez-le :
   ```bash
   chmod +x install.sh
   ./install.sh
   ```

## Installation manuelle

Si le script automatique ne fonctionne pas, suivez ces étapes :

### 1. Créer la base de données

Ouvrez phpMyAdmin (http://localhost/phpmyadmin) ou MySQL CLI et exécutez :

```sql
CREATE DATABASE IF NOT EXISTS elibrary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Configurer l'environnement

Vérifiez que le fichier `.env` contient les bonnes informations :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elibrary
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Installer les dépendances PHP

```cmd
composer install
```

### 4. Générer la clé d'application

```cmd
php artisan key:generate
```

### 5. Exécuter les migrations

```cmd
php artisan migrate
```

### 6. Créer le lien de stockage

```cmd
php artisan storage:link
```

### 7. Peupler la base de données

```cmd
php artisan db:seed
```

### 8. Installer les dépendances NPM

```cmd
npm install
```

### 9. Compiler les assets

```cmd
npm run build
```

## Accès à l'application

Une fois l'installation terminée, accédez à l'application :

- **URL** : http://localhost/E-Library/public

### Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@elibrary.com | password |
| Auteur | author@elibrary.com | password |
| Utilisateur | user@elibrary.com | password |

## Dépannage

### Erreur "Unknown database 'elibrary'"

1. Vérifiez que MySQL est démarré dans XAMPP
2. Créez manuellement la base de données via phpMyAdmin
3. Exécutez : `mysql -u root < setup-database.sql`

### Erreur "Class not found"

1. Supprimez le dossier `vendor` et réinstallez :
   ```cmd
   rmdir /s /q vendor
   composer install
   ```

### Erreur Vite/NPM

1. Supprimez `node_modules` et réinstallez :
   ```cmd
   rmdir /s /q node_modules
   npm install
   npm run build
   ```

### Page blanche ou erreur 500

1. Vérifiez les permissions du dossier `storage` et `bootstrap/cache`
2. Videz le cache :
   ```cmd
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

## Structure du projet

```
E-Library/
├── app/               # Code de l'application
├── config/            # Fichiers de configuration
├── database/          # Migrations et seeders
├── public/            # Point d'entrée web
├── resources/         # Vues et assets
├── routes/            # Définition des routes
├── storage/           # Fichiers uploadés et cache
├── tests/             # Tests automatisés
├── .env               # Configuration environnement
├── composer.json      # Dépendances PHP
├── package.json       # Dépendances NPM
└── install.bat        # Script d'installation Windows
```

## Support

En cas de problème :

1. Vérifiez les logs dans `storage/logs/laravel.log`
2. Consultez la documentation Laravel : https://laravel.com/docs
3. Vérifiez que toutes les extensions PHP requises sont activées dans php.ini