# eLibrary - Plateforme de Bibliothèque Numérique

Une plateforme moderne de bibliothèque numérique développée avec Laravel, permettant aux auteurs de publier des livres PDF et aux utilisateurs de les consulter et télécharger.

## Fonctionnalités

- **Authentification complète** avec Laravel Breeze
- **Système de rôles** : Administrateur, Auteur, Utilisateur
- **Upload et gestion de livres PDF**
- **Approbation des livres** par les administrateurs
- **Lecteur PDF intégré** pour la lecture en ligne
- **Moteur de recherche avancé** avec filtres multiples
- **Tableaux de bord personnalisés** selon le rôle
- **Interface moderne** avec Tailwind CSS et Alpine.js
- **Tests automatisés** avec Pest

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL (via XAMPP ou autre)
- Node.js et npm

## Installation

1. **Cloner le projet**

```bash
cd /chemin/vers/votre/dossier
git clone https://github.com/zak01E/E-Library.git elibrary
cd elibrary
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Configurer l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**

- Créer une base de données MySQL nommée `elibrary`
- Modifier le fichier `.env` avec vos informations de connexion

5. **Exécuter les migrations**

```bash
php artisan migrate
```

6. **Peupler la base de données (optionnel)**

```bash
php artisan db:seed
```

7. **Installer les dépendances frontend**

```bash
npm install
npm run build
```

8. **Créer le lien de stockage**

```bash
php artisan storage:link
```

## Utilisation

1. **Démarrer le serveur de développement**

```bash
php artisan serve
```

2. **Compiler les assets en mode développement**

```bash
npm run dev
```

3. **Accéder à l'application**

- URL : http://localhost:8000
- Admin : admin@elibrary.com / password

## Structure des rôles

- **Administrateur** : Gestion complète des utilisateurs et livres
- **Auteur** : Publication et gestion de ses propres livres
- **Utilisateur** : Consultation et téléchargement des livres approuvés

## Tests

Exécuter les tests avec Pest :

```bash
php artisan test
```

## Technologies utilisées

- Laravel 10.x
- Laravel Breeze (authentification)
- Tailwind CSS (styling)
- Alpine.js (interactivité)
- Pest (tests)
- MySQL (base de données)

## Contribution

Les contributions sont les bienvenues ! Veuillez créer une branche pour vos modifications et soumettre une pull request.

## Licence

Ce projet est sous licence MIT.

## Auteur

**Zakaria K.** - [zak01E](https://github.com/zak01E)

---

⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile !
