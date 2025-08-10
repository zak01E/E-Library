# 🔧 CORRECTION DES ERREURS DE MIGRATION

## ❌ Erreur rencontrée
```
SQLSTATE[42000]: Syntax error or access violation: 1067 Invalid default value for 'due_date'
```

## ✅ Solutions

### Solution 1 : Utiliser la migration sécurisée (RECOMMANDÉ)

J'ai créé une nouvelle migration qui vérifie l'existence des tables avant de les créer :

```bash
php artisan migrate --path=database/migrations/2025_08_10_000003_create_professional_tables_safe.php
```

### Solution 2 : Créer uniquement la table notifications

```bash
php artisan migrate --path=database/migrations/2025_08_10_000002_create_notifications_table.php
```

### Solution 3 : Configurer MySQL pour accepter les timestamps

Si vous avez MySQL 5.7 ou plus récent, ajoutez dans votre fichier `.env` :

```env
DB_STRICT_MODE=false
```

Ou modifiez `config/database.php` :

```php
'mysql' => [
    // ...
    'strict' => false,
    'modes' => [
        'ONLY_FULL_GROUP_BY',
        'STRICT_TRANS_TABLES',
        'NO_ZERO_IN_DATE',
        'ERROR_FOR_DIVISION_BY_ZERO',
        'NO_ENGINE_SUBSTITUTION',
    ],
],
```

### Solution 4 : Réinitialiser et recréer (ATTENTION : supprime les données)

```bash
# Supprimer toutes les tables
php artisan migrate:fresh

# Créer les tables de base
php artisan migrate

# Créer les tables professionnelles sécurisées
php artisan migrate --path=database/migrations/2025_08_10_000003_create_professional_tables_safe.php

# Créer la table notifications
php artisan migrate --path=database/migrations/2025_08_10_000002_create_notifications_table.php

# Remplir avec des données de test
php artisan db:seed
```

## 📝 Tables créées par la migration sécurisée

1. **profiles** - Profils détaillés des utilisateurs
2. **authors** - Informations des auteurs
3. **borrowings** - Emprunts de livres
4. **reservations** - Réservations
5. **collections** - Collections personnalisées
6. **user_favorites** - Favoris
7. **user_reading_lists** - Listes de lecture

## 🚀 Commandes utiles

### Vérifier les tables existantes
```bash
php artisan tinker
```
```php
Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
```

### Vérifier l'état des migrations
```bash
php artisan migrate:status
```

### Annuler la dernière migration
```bash
php artisan migrate:rollback
```

### Créer manuellement les tables essentielles (SQL direct)

Si les migrations échouent, exécutez ces requêtes SQL dans phpMyAdmin :

```sql
-- Table des notifications (obligatoire)
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) NOT NULL PRIMARY KEY,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`, `notifiable_id`)
);

-- Table des emprunts (pour la bibliothèque)
CREATE TABLE IF NOT EXISTS `borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `borrowed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `extended_count` int(11) NOT NULL DEFAULT '0',
  `status` enum('active','returned','overdue','lost') NOT NULL DEFAULT 'active',
  `fine_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `fine_paid` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `borrowings_user_id_status_index` (`user_id`, `status`),
  KEY `borrowings_book_id_status_index` (`book_id`, `status`)
);

-- Table des favoris
CREATE TABLE IF NOT EXISTS `user_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `user_favorites_user_id_book_id_unique` (`user_id`, `book_id`)
);
```

## 🆘 Si le problème persiste

1. **Vérifier la version de MySQL** :
```bash
mysql --version
```

2. **Vérifier les paramètres SQL** :
```sql
SHOW VARIABLES LIKE 'sql_mode';
```

3. **Désactiver temporairement le mode strict** :
```sql
SET GLOBAL sql_mode='';
```

4. **Contacter le support** avec :
   - Version de MySQL
   - Fichier `.env` (sans les mots de passe)
   - Logs d'erreur : `storage/logs/laravel.log`

## ✨ Après correction

Le site fonctionnera avec :
- ✅ Système de notifications
- ✅ Gestion des emprunts
- ✅ Favoris et listes de lecture
- ✅ Collections personnalisées
- ✅ Profils enrichis

---

*Le problème principal est la gestion des timestamps dans MySQL. La migration sécurisée corrige ce problème.*