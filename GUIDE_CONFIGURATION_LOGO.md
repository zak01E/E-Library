# Guide de Configuration du Logo et de l'Icône

## 📋 Configuration depuis l'Interface Admin

### Accéder aux paramètres
1. Connectez-vous en tant qu'administrateur
2. Allez dans **Paramètres** → **Configuration du site**
3. URL directe : `http://127.0.0.1:8000/admin/settings`

### Paramètres disponibles

#### 🏷️ Nom du Site
- **Clé** : `site_name`
- **Utilisation** : Affiché dans le titre, header, footer
- **Exemple** : "E-Library Côte d'Ivoire"

#### 🖼️ Logo Principal
- **Clé** : `site_logo`
- **Format recommandé** : PNG ou SVG
- **Taille recommandée** : 200x50px (horizontal) ou 150x150px (carré)
- **Utilisation** : Navigation, page de connexion, emails

#### 🔷 Favicon
- **Clé** : `site_favicon`
- **Format recommandé** : ICO, PNG (32x32px ou 16x16px)
- **Utilisation** : Icône dans l'onglet du navigateur

#### 🛡️ Logo Admin (optionnel)
- **Clé** : `admin_logo`
- **Format recommandé** : PNG ou SVG
- **Utilisation** : Dashboard administrateur uniquement

## 🔧 Configuration via Base de Données

Si vous préférez configurer directement en base de données :

```sql
-- Définir le nom du site
INSERT INTO site_settings (key, value, type, description, created_at, updated_at) 
VALUES ('site_name', 'E-Library CI', 'text', 'Nom du site', NOW(), NOW())
ON DUPLICATE KEY UPDATE value = 'E-Library CI';

-- Définir le logo (après upload dans storage/app/public/)
INSERT INTO site_settings (key, value, type, description, created_at, updated_at) 
VALUES ('site_logo', 'logos/logo.png', 'file', 'Logo principal du site', NOW(), NOW())
ON DUPLICATE KEY UPDATE value = 'logos/logo.png';

-- Définir le favicon
INSERT INTO site_settings (key, value, type, description, created_at, updated_at) 
VALUES ('site_favicon', 'logos/favicon.ico', 'file', 'Favicon du site', NOW(), NOW())
ON DUPLICATE KEY UPDATE value = 'logos/favicon.ico';
```

## 📁 Upload des Fichiers

### Via l'interface admin
1. Utilisez le formulaire dans **Paramètres**
2. Les fichiers sont automatiquement stockés dans `storage/app/public/logos/`

### Manuellement
1. Placez vos fichiers dans : `storage/app/public/logos/`
2. Assurez-vous que le lien symbolique existe :
   ```bash
   php artisan storage:link
   ```

## 🎨 Helpers Disponibles

Les helpers suivants sont disponibles dans toutes les vues Blade :

```php
// Récupérer le nom du site
{{ site_name() }}

// Récupérer l'URL du logo principal
{{ site_logo() }}

// Récupérer l'URL du favicon
{{ site_favicon() }}

// Récupérer l'URL du logo admin
{{ site_logo('admin_logo') }}

// Récupérer n'importe quel paramètre
{{ site_setting('key_name', 'valeur_par_defaut') }}
```

## ✅ Emplacements Automatiquement Mis à Jour

Le logo et le favicon sont automatiquement appliqués dans :

- ✅ Page d'accueil (`/`)
- ✅ Navigation principale
- ✅ Footer
- ✅ Pages de connexion/inscription
- ✅ Dashboard administrateur
- ✅ Dashboard utilisateur
- ✅ Dashboard auteur
- ✅ Toutes les pages publiques
- ✅ Emails (si configuré)

## 🔍 Vérification

Pour vérifier que tout fonctionne :

1. **Vider le cache** :
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. **Tester les helpers** :
   ```bash
   php artisan tinker
   > site_name()
   > site_logo()
   > site_favicon()
   ```

3. **Vérifier visuellement** :
   - Rafraîchir la page d'accueil
   - Vérifier l'icône dans l'onglet du navigateur
   - Vérifier le logo dans la navigation

## 🚨 Résolution des Problèmes

### Le logo n'apparaît pas
1. Vérifiez que le fichier existe dans `storage/app/public/logos/`
2. Vérifiez le lien symbolique : `php artisan storage:link`
3. Vérifiez les permissions du fichier

### L'ancien logo reste affiché
1. Videz le cache du navigateur (Ctrl+F5)
2. Videz le cache Laravel : `php artisan cache:clear`

### Erreur 404 sur le logo
1. Vérifiez le chemin dans la base de données
2. Ne pas inclure `/storage/` dans le chemin sauvegardé
3. Exemple correct : `logos/mon-logo.png` (pas `/storage/logos/mon-logo.png`)

## 📝 Notes Importantes

- Les logos sont automatiquement redimensionnés selon le contexte
- Le système utilise un fallback (icône par défaut) si aucun logo n'est défini
- Les changements sont appliqués immédiatement sans redémarrage
- Formats supportés : PNG, JPG, SVG, ICO (pour favicon)