# Architecture des Espaces Utilisateurs - E-Library

## Vue d'ensemble

L'application E-Library dispose de trois espaces utilisateurs distincts, chacun avec ses propres fonctionnalités, interfaces et permissions.

## 1. ESPACE UTILISATEUR (Lecteur)

### Connexion
- **Email:** user@elibrary.com
- **Mot de passe:** password
- **URL Dashboard:** http://127.0.0.1:8000/dashboard

### Caractéristiques
- **Rôle dans la DB:** `user`
- **Layout:** `components/user-dashboard.blade.php`
- **Vue Dashboard:** `dashboard/user.blade.php`
- **Controller:** `DashboardController@userDashboard()`

### Fonctionnalités disponibles
- Parcourir la bibliothèque de livres approuvés
- Rechercher des livres
- Voir les détails des livres
- Télécharger des livres (nécessite connexion)
- Voir les auteurs
- Gérer son profil
- Créer des collections personnelles
- Voir les statistiques de lecture

### Routes principales
```
/dashboard                  # Dashboard utilisateur
/books                      # Mes livres
/library                    # Bibliothèque publique
/library/{book}             # Détails d'un livre
/library/{book}/download    # Télécharger un livre
/authors                    # Liste des auteurs
/authors/{author}           # Page d'un auteur
/profile/edit               # Éditer son profil
/collections                # Mes collections
```

## 2. ESPACE AUTEUR

### Connexion
- **Email:** author@elibrary.com
- **Mot de passe:** password
- **URL Dashboard:** http://127.0.0.1:8000/author/dashboard

### Caractéristiques
- **Rôle dans la DB:** `author`
- **Layout:** `layouts/author-dashboard.blade.php`
- **Vue Dashboard:** `dashboard/author.blade.php`
- **Controller:** `AuthorController`
- **Middleware:** `is-author`

### Fonctionnalités disponibles
- Publier de nouveaux livres
- Gérer ses livres publiés
- Voir le statut d'approbation
- Consulter les statistiques (vues, téléchargements)
- Gérer les revenus
- Créer des promotions
- Répondre aux reviews
- Créer des collections
- Accès au support

### Routes principales
```
/author/dashboard           # Dashboard auteur
/author/books               # Gérer mes livres
/author/books/create        # Publier un nouveau livre
/author/books/{book}/edit   # Éditer un livre
/author/analytics           # Statistiques
/author/revenue             # Revenus
/author/promotions          # Promotions
/author/reviews             # Reviews
/author/collections         # Collections
/author/profile             # Profil auteur
```

## 3. ESPACE ADMINISTRATEUR

### Connexion
- **Email:** admin@elibrary.com
- **Mot de passe:** password
- **URL Dashboard:** http://127.0.0.1:8000/admin/dashboard

### Caractéristiques
- **Rôle dans la DB:** `admin`
- **Layout:** `layouts/admin-dashboard.blade.php`
- **Vue Dashboard:** `dashboard/admin.blade.php`
- **Controller:** `AdminController`
- **Middleware:** `is-admin`

### Fonctionnalités disponibles
- Gérer tous les utilisateurs
- Approuver/Rejeter les livres
- Gérer les catégories
- Voir toutes les statistiques
- Gérer les paramètres du site
- Gérer les permissions
- Système de backup
- Logs d'activité
- Rapports complets

### Routes principales
```
/admin/dashboard            # Dashboard admin
/admin/users                # Gestion utilisateurs
/admin/books                # Gestion livres
/admin/books/{book}/approve # Approuver un livre
/admin/books/{book}/reject  # Rejeter un livre
/admin/categories           # Gestion catégories
/admin/settings             # Paramètres du site
/admin/permissions          # Gestion des permissions
/admin/reports              # Rapports
/admin/activity             # Logs d'activité
/admin/backup               # Sauvegardes
```

## SYSTÈME DE REDIRECTION AUTOMATIQUE

### DashboardController
Le `DashboardController::index()` affiche automatiquement le bon dashboard selon le rôle :
- **PAS DE REDIRECTION** - Affiche directement la vue appropriée
- Évite les boucles de redirection
- Vérification du rôle dans chaque méthode privée

### Middleware de protection
- `auth` : Vérifie que l'utilisateur est connecté
- `is-admin` : Vérifie que l'utilisateur est admin
- `is-author` : Vérifie que l'utilisateur est auteur
- `check-role:admin,author` : Vérifie plusieurs rôles possibles

### Flux d'authentification
1. Utilisateur se connecte via `/login`
2. Après connexion, redirection vers `/dashboard`
3. `DashboardController::index()` affiche le dashboard approprié
4. Pas de redirection supplémentaire

## RÉSOLUTION DES PROBLÈMES

### Si un utilisateur accède à la mauvaise section
- Le middleware redirige automatiquement vers le bon espace
- Un message d'erreur explique la redirection
- Exemple : Un utilisateur normal essayant d'accéder à `/author/dashboard` sera redirigé vers `/dashboard`

### Vérification du rôle d'un utilisateur
```php
// Dans tinker
$user = User::where('email', 'user@elibrary.com')->first();
echo $user->role; // Devrait afficher 'user'
```

### Changement de rôle d'un utilisateur
```php
// Dans tinker (pour tester)
$user = User::where('email', 'user@elibrary.com')->first();
$user->role = 'author'; // Changer en auteur
$user->save();
```

## IMPORTANT

- **NE PAS** utiliser de redirections dans `DashboardController::index()`
- **TOUJOURS** vérifier le rôle dans les méthodes privées
- **UTILISER** les middlewares appropriés sur les routes
- **MAINTENIR** la séparation claire entre les trois espaces

## TESTS

Pour tester chaque espace :
1. Se déconnecter complètement
2. Se connecter avec les identifiants appropriés
3. Vérifier que l'URL est `/dashboard` (pas de redirection)
4. Vérifier que le contenu affiché correspond au rôle