# 📖 GUIDE DÉTAILLÉ - FONCTIONNEMENT DE CHAQUE PAGE MAMA ÉCOLE

## 1️⃣ PAGE D'ACCUEIL (`/mama-ecole`)
### 🎯 Objectif
Présenter le système Mama École aux visiteurs

### 📋 Ce qu'elle fait
- Affiche une présentation moderne du système
- Explique le concept (parents illettrés + téléphone)
- Montre les avantages
- Boutons d'accès rapide

### 🔧 Comment ça marche
```
Visiteur → Accède à /mama-ecole → Vue: modern.blade.php
→ Affiche page statique → Boutons vers autres pages
```

### 💡 Utilisation
- **Qui** : Tout le monde (public)
- **Quand** : Première visite
- **Action** : Cliquer "Accéder au Dashboard" ou "Tester le système"

---

## 2️⃣ DASHBOARD (`/mama-ecole/dashboard`)
### 🎯 Objectif
Centre de contrôle principal pour gérer tout le système

### 📋 Ce qu'elle fait
```
AFFICHE EN TEMPS RÉEL :
┌─────────────────────────────────────┐
│ 📊 STATISTIQUES                     │
│ • 20 Parents inscrits               │
│ • 10 Parents illettrés              │
│ • 0 Appels aujourd'hui              │
│ • 78% Taux d'engagement             │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ 🌍 LANGUES PARLÉES                  │
│ Français  ████████ 40%              │
│ Dioula    ██████ 30%                │
│ Baoulé    ████ 20%                  │
│ Bété      ██ 10%                    │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ 📞 APPELS RÉCENTS                   │
│ 14:30 | +225... | Notes | ✅        │
│ 13:45 | +225... | Absence | ✅      │
│ 12:00 | +225... | Réunion | ❌      │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ ⚡ ACTIONS RAPIDES                  │
│ [📝 Envoyer Notes]                  │
│ [🚨 Signaler Absence]               │
│ [📅 Convoquer Réunion]              │
│ [⚠️ Message Urgent]                 │
└─────────────────────────────────────┘
```

### 🔧 Comment ça marche
1. **Chargement** : Le contrôleur récupère les données de la DB
2. **Calculs** : 
   - Compte les parents totaux
   - Compte les illettrés
   - Calcule le taux d'engagement
   - Récupère les 10 derniers appels
3. **Affichage** : Graphiques et tableaux dynamiques

### 💡 Utilisation pratique
```
EXEMPLE : Envoyer les notes
1. Cliquez "Envoyer Notes"
2. Une popup apparaît
3. Sélectionnez : Classe 6ème A
4. Entrez : Maths, 15/20
5. Cliquez "Envoyer"
→ RÉSULTAT : Tous les parents illettrés de 6ème A reçoivent un appel/SMS
```

---

## 3️⃣ GESTION PARENTS (`/mama-ecole/parents`)
### 🎯 Objectif
Gérer la base de données des parents

### 📋 Ce qu'elle fait
```
TABLEAU DES PARENTS :
┌────┬──────────┬────────────┬─────────┬──────────┬─────────┐
│ ID │ Nom      │ Téléphone  │ Langue  │ Lit?     │ Actions │
├────┼──────────┼────────────┼─────────┼──────────┼─────────┤
│ 1  │ Kouassi  │ +225070... │ Baoulé  │ Non ❌   │ 📞 📱   │
│ 2  │ Traoré   │ +225050... │ Dioula  │ Non ❌   │ 📞 📱   │
│ 3  │ Dubois   │ +336123... │ Français│ Oui ✅   │ 📱      │
└────┴──────────┴────────────┴─────────┴──────────┴─────────┘

[➕ Ajouter un parent]
```

### 🔧 Comment ça marche
**AJOUTER UN PARENT :**
```
1. Cliquez "Ajouter un parent"
2. Formulaire apparaît :
   ┌─────────────────────────────┐
   │ Nom: [___________________]  │
   │ Téléphone: [+225________]   │
   │ Langue: [▼ Sélectionner]    │
   │ Peut lire?: [ ] Oui [X] Non │
   │ Enfant: [▼ Sélectionner]    │
   │ [Enregistrer]               │
   └─────────────────────────────┘
3. Cliquez "Enregistrer"
→ Parent ajouté à la base
```

**ACTIONS SUR UN PARENT :**
- 📞 **Appeler** : Lance un appel vocal dans sa langue
- 📱 **SMS** : Envoie un SMS (si peut lire) ou appel vocal (si illettré)

### 💡 Cas d'usage
```
SCÉNARIO : Parent illettré Baoulé
1. Ajoutez : Mme Kouassi, +2250707123456, Baoulé, Ne lit pas
2. Son enfant a 12/20 en maths
3. Cliquez 📞 → Appel automatique en Baoulé
4. Message vocal : "An ba, bi tia a ni point 12 mathématiques ya"
```

---

## 4️⃣ TEMPLATES MESSAGES (`/mama-ecole/templates`)
### 🎯 Objectif
Créer des modèles de messages réutilisables

### 📋 Ce qu'elle fait
```
LISTE DES TEMPLATES :
┌──────────────┬──────────┬─────────┬──────────┐
│ Nom          │ Type     │ Langue  │ Utilisé  │
├──────────────┼──────────┼─────────┼──────────┤
│ Notes        │ Grades   │ Français│ 45 fois  │
│ Absence      │ Absence  │ Français│ 23 fois  │
│ Réunion      │ Meeting  │ Français│ 12 fois  │
│ Notes Baoulé │ Grades   │ Baoulé  │ 8 fois   │
└──────────────┴──────────┴─────────┴──────────┘

[➕ Créer un template]
```

### 🔧 Comment ça marche
**CRÉER UN TEMPLATE :**
```
Formulaire :
┌─────────────────────────────────────┐
│ Nom: [Convocation réunion]         │
│ Type: [▼ Meeting]                  │
│ Langue: [▼ Français]               │
│ Message:                            │
│ [Réunion le {date} à {heure}      ]│
│ [pour discuter de {sujet}.        ]│
│                                     │
│ Variables disponibles:              │
│ {nom_parent} {nom_enfant} {classe} │
│ {date} {heure} {sujet} {note}      │
│                                     │
│ [💾 Sauvegarder]                   │
└─────────────────────────────────────┘
```

### 💡 Utilisation
```
EXEMPLE : Template "Absence"
Message : "{nom_parent}, votre enfant {nom_enfant} était absent le {date}"

Utilisation :
→ Variables remplacées : "Mme Kouassi, votre enfant Jean était absent le 13/08"
→ Envoyé en Baoulé si parent Baoulé
→ Appel vocal si parent illettré
```

---

## 5️⃣ CAMPAGNES (`/mama-ecole/campaigns`)
### 🎯 Objectif
Envoyer des messages à plusieurs parents en même temps

### 📋 Ce qu'elle fait
```
CAMPAGNES EN COURS :
┌────────────────┬──────┬─────────┬─────────┬──────────┐
│ Nom            │ Type │ Cible   │ Envoyés │ Status   │
├────────────────┼──────┼─────────┼─────────┼──────────┤
│ Rentrée 2025   │ SMS  │ 200     │ 200/200 │ ✅ Fini  │
│ Réunion parents│ Call │ 50      │ 25/50   │ ⏳ En cours│
│ Vaccination    │ SMS  │ 100     │ 0/100   │ 📅 Planifié│
└────────────────┴──────┴─────────┴─────────┴──────────┘

[🚀 Nouvelle campagne]
```

### 🔧 Comment ça marche
**CRÉER UNE CAMPAGNE :**
```
1. Configuration :
┌─────────────────────────────────────┐
│ NOUVELLE CAMPAGNE                   │
├─────────────────────────────────────┤
│ Nom: [Réunion trimestre]           │
│ Type: [▼ Appel vocal]              │
│                                     │
│ CIBLAGE:                            │
│ [ ] Tous les parents                │
│ [X] Parents illettrés seulement    │
│ [ ] Classe spécifique: [▼]         │
│ [ ] Langue: [▼ Toutes]             │
│                                     │
│ MESSAGE:                            │
│ [▼ Utiliser template: Réunion]     │
│ Date: 20/08/2025                   │
│ Heure: 14h00                       │
│                                     │
│ PLANIFICATION:                      │
│ ( ) Envoyer maintenant              │
│ (X) Planifier: [15/08 à 10h00]     │
│                                     │
│ [🚀 Lancer la campagne]            │
└─────────────────────────────────────┘

2. Traitement :
→ Système trouve 50 parents illettrés
→ Prépare 50 appels personnalisés
→ Lance les appels à l'heure programmée
→ Chaque parent reçoit l'appel dans sa langue
```

### 💡 Exemple concret
```
CAMPAGNE "Bulletins disponibles" :
- Cible : 200 parents (100 illettrés)
- Action système :
  • 100 SMS → Parents qui lisent
  • 100 Appels → Parents illettrés
    - 40 en Français
    - 30 en Dioula  
    - 20 en Baoulé
    - 10 en Bété
- Résultat : Tous informés en 5 minutes
```

---

## 6️⃣ TEST SMS (`/mama-ecole/test-simple`)
### 🎯 Objectif
Tester l'envoi de SMS/Appels

### 📋 Ce qu'elle fait
```
INTERFACE DE TEST :
┌─────────────────────────────────────┐
│ TEST ENVOI SMS                      │
├─────────────────────────────────────┤
│ Numéro: [+33752353581_____]        │
│                                     │
│ Message:                            │
│ [MAMA ÉCOLE: Test message______]   │
│ [_______________________________]  │
│                                     │
│ [📤 Envoyer SMS]                   │
├─────────────────────────────────────┤
│ 📊 Statistiques                    │
│ SMS aujourd'hui: 2                 │
│ Dernier: 14:46 - delivered ✅      │
└─────────────────────────────────────┘
```

### 🔧 Comment ça marche
```
1. Entrez numéro
2. Tapez message
3. Cliquez "Envoyer"
4. Backend :
   → Twilio API
   → Envoi SMS
   → Sauvegarde en DB
   → Retour status
5. Affichage résultat
```

### 💡 Utilisation
- **Test initial** : Vérifier que Twilio fonctionne
- **Debug** : Tester des messages spécifiques
- **Démo** : Montrer le système à quelqu'un

---

## 🔄 FLUX GLOBAL DU SYSTÈME

```
SCÉNARIO COMPLET : Note d'un élève

1. PROFESSEUR entre note
   └→ Dashboard → "Envoyer Notes"

2. SYSTÈME identifie parents
   └→ DB : Trouve parents de la classe
   └→ Filtre : Sépare lettrés/illettrés

3. ENVOI personnalisé
   ├→ Parents lettrés : SMS texte
   └→ Parents illettrés : Appel vocal
       └→ Chaque langue (Baoulé, Dioula, etc.)

4. PARENT illettré reçoit
   └→ Téléphone sonne
   └→ Décroche
   └→ Entend : "Votre enfant a eu 15/20 en maths"
   └→ Dans SA langue

5. SUIVI
   └→ Dashboard : Statistiques mises à jour
   └→ Logs : Interaction enregistrée
   └→ Rapport : Taux de succès
```

---

## 💡 CONSEILS D'UTILISATION

### Pour commencer :
1. **Ajoutez des parents** dans `/parents`
2. **Créez des templates** dans `/templates`
3. **Testez un SMS** dans `/test-simple`
4. **Lancez une campagne** dans `/campaigns`

### Ordre recommandé :
```
1. Test-simple → Vérifier que ça marche
2. Parents → Ajouter quelques parents test
3. Templates → Créer messages types
4. Dashboard → Envoyer notifications
5. Campaigns → Communications groupées
```

---

## 🎯 RÉSUMÉ PAR PAGE

| Page | Rôle | Action principale |
|------|------|------------------|
| **Accueil** | Présentation | Informer sur le système |
| **Dashboard** | Centre de contrôle | Gérer tout depuis un endroit |
| **Parents** | Base de données | Ajouter/gérer les parents |
| **Templates** | Modèles | Créer messages réutilisables |
| **Campaigns** | Communication masse | Envoyer à plusieurs parents |
| **Test-Simple** | Test/Debug | Vérifier que tout fonctionne |

Chaque page a un rôle spécifique dans le système global d'inclusion des parents illettrés !