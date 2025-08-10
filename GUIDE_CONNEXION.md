# 🔐 GUIDE DE CONNEXION E-LIBRARY

## 📍 URLs DE CONNEXION PAR TYPE D'UTILISATEUR

### 1️⃣ **UTILISATEUR STANDARD (User)**
```
URL: http://localhost:8000/login
```
- **Vue**: `resources/views/auth/login.blade.php`
- **Accès**: Lecteurs, membres de la bibliothèque
- **Dashboard après connexion**: `/dashboard`
- **Fonctionnalités**: 
  - Emprunter des livres
  - Gérer sa bibliothèque personnelle
  - Lire en ligne
  - Favoris et listes de lecture

---

### 2️⃣ **ADMINISTRATEUR (Admin)**
```
URL: http://localhost:8000/admin/login
```
- **Vue**: `resources/views/admin/login.blade.php`
- **Accès**: Administrateurs système
- **Dashboard après connexion**: `/admin/dashboard`
- **Fonctionnalités**:
  - Gestion complète des livres
  - Gestion des utilisateurs
  - Statistiques et rapports
  - Paramètres système

#### ⚡ **Connexion rapide Admin (Test)**
```
URL: http://localhost:8000/admin/test-login
```
- Connexion automatique avec l'admin par défaut
- ⚠️ À désactiver en production

---

### 3️⃣ **AUTEUR (Author)**
```
URL: http://localhost:8000/author/login
```
- **Vue**: `resources/views/auth/author-login.blade.php`
- **Accès**: Auteurs et contributeurs
- **Dashboard après connexion**: `/author/dashboard`
- **Fonctionnalités**:
  - Publier des livres
  - Analytics et statistiques
  - Gestion des revenus
  - Outils marketing

---

## 🔑 COMPTES DE TEST

### Administrateur
```
Email: admin@elibrary.com
Mot de passe: password123
```

### Utilisateur Test
```
Email: user@example.com
Mot de passe: password
```

### Auteur Test
```
Email: author@example.com
Mot de passe: password
```

---

## 📝 CRÉATION DE NOUVEAUX COMPTES

### Créer un nouvel utilisateur
```
URL: http://localhost:8000/register
```

### Créer un administrateur (via Artisan)
```bash
php artisan create:admin
```

### Créer un auteur
```
URL: http://localhost:8000/author/register
```
*Ou depuis le panel admin : Admin > Users > Create User (sélectionner role "author")*

---

## 🛠️ COMMANDES UTILES

### Créer un administrateur via commande
```bash
php artisan tinker
```
```php
$user = new \App\Models\User();
$user->name = 'Admin Name';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->email_verified_at = now();
$user->save();
```

### Changer le rôle d'un utilisateur existant
```bash
php artisan tinker
```
```php
$user = \App\Models\User::where('email', 'user@example.com')->first();
$user->role = 'admin'; // ou 'author' ou 'user'
$user->save();
```

### Vérifier les routes disponibles
```bash
php artisan route:list | grep login
```

---

## 🔄 FLUX DE CONNEXION

### Pour les Utilisateurs
1. Accéder à `/login`
2. Entrer email et mot de passe
3. Redirection vers `/dashboard`
4. Accès complet à l'espace utilisateur

### Pour les Administrateurs
1. Accéder à `/admin/login`
2. Entrer les identifiants admin
3. Vérification du rôle admin
4. Redirection vers `/admin/dashboard`
5. Accès complet au panel d'administration

### Pour les Auteurs
1. Accéder à `/author/login`
2. Entrer les identifiants auteur
3. Vérification du rôle auteur
4. Redirection vers `/author/dashboard`
5. Accès à l'espace auteur

---

## 🚨 DÉPANNAGE

### Erreur "Route not found"
```bash
# Vider le cache des routes
php artisan route:clear
php artisan route:cache
```

### Erreur "View not found"
```bash
# Vérifier que les vues existent
ls resources/views/auth/
ls resources/views/admin/
```

### Impossible de se connecter
```bash
# Vérifier les middlewares
php artisan route:list --name=login
```

### Reset mot de passe admin
```bash
php artisan tinker
```
```php
$admin = \App\Models\User::where('email', 'admin@elibrary.com')->first();
$admin->password = bcrypt('newpassword');
$admin->save();
```

---

## 🔒 SÉCURITÉ

### En Production
1. ❌ Désactiver `/admin/test-login`
2. ✅ Activer 2FA pour les admins
3. ✅ Utiliser des mots de passe forts
4. ✅ Activer le rate limiting
5. ✅ Mettre en place HTTPS

### Middlewares de Protection
- **Guest**: Empêche l'accès si déjà connecté
- **Auth**: Requiert une authentification
- **Is-Admin**: Vérifie le rôle administrateur
- **Is-Author**: Vérifie le rôle auteur
- **Verified**: Vérifie l'email confirmé

---

## 📱 ACCÈS MOBILE

Les URLs fonctionnent aussi sur mobile :
- Utilisateur: `m.votresite.com/login`
- Admin: `m.votresite.com/admin/login`
- Auteur: `m.votresite.com/author/login`

---

## 💡 NOTES IMPORTANTES

1. **Première connexion** : Assurez-vous d'avoir exécuté les migrations et seeders
2. **Rôles** : Chaque utilisateur a UN SEUL rôle (user, author, ou admin)
3. **Sessions** : Les sessions sont indépendantes par type d'utilisateur
4. **Logout** : Chaque espace a sa propre route de déconnexion

---

## 🆘 SUPPORT

En cas de problème de connexion :
1. Vérifier les logs : `storage/logs/laravel.log`
2. Vérifier la base de données : table `users`
3. Tester avec `php artisan tinker`
4. Contacter l'équipe technique

---

*Dernière mise à jour : 10 Août 2025*