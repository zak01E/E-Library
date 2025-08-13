# 📚 GUIDE SIMPLE - COMMENT UTILISER MAMA ÉCOLE

## 🎯 QU'EST-CE QUE MAMA ÉCOLE ?

**Mama École** est un système qui permet aux **parents qui ne savent pas lire** de suivre la scolarité de leurs enfants par **téléphone**.

### Le problème résolu :
- ❌ Les parents illettrés ne peuvent pas lire les bulletins
- ❌ Ils ne peuvent pas lire les convocations 
- ❌ Ils ratent les réunions importantes
- ✅ **Solution** : On leur **téléphone** ou envoie des **SMS vocaux** dans leur langue !

---

## 🚀 COMMENT DÉMARRER

### Étape 1 : Lancer le serveur
Double-cliquez sur `start-server.bat` dans votre dossier E-Library

### Étape 2 : Ouvrir votre navigateur
Allez à : **http://localhost:8000/mama-ecole**

---

## 📱 LES 4 FONCTIONS PRINCIPALES

### 1️⃣ INSCRIRE UN PARENT ILLETTRÉ

**Où aller** : http://localhost:8000/mama-ecole/parents

**Quoi faire** :
1. Cliquez sur **"Ajouter un parent"**
2. Remplissez :
   - Nom : `Kouassi Marie`
   - Téléphone : `+2250707123456` (numéro Orange CI)
   - Langue : `Baoulé` (ou Dioula, Bété, Sénoufo)
   - Peut lire : `Non` ❌
3. Cliquez **"Enregistrer"**

**Résultat** : Le parent est inscrit et pourra recevoir des appels/SMS

---

### 2️⃣ ENVOYER LES NOTES D'UN ÉLÈVE

**Où aller** : http://localhost:8000/mama-ecole/dashboard

**Quoi faire** :
1. Cliquez sur le bouton bleu **"Envoyer Notes"**
2. Sélectionnez :
   - Classe : `6ème A`
   - Matière : `Mathématiques`
   - Note : `15/20`
3. Cliquez **"Envoyer"**

**Ce qui se passe** :
- Le système trouve tous les parents de 6ème A
- Pour ceux qui ne savent pas lire :
  - 📞 **Appel vocal** : "Bonjour, votre enfant a eu 15 sur 20 en mathématiques"
  - 🌍 Message dit dans leur langue (Baoulé, Dioula, etc.)
- Pour ceux qui savent lire :
  - 📱 **SMS classique** avec le texte

---

### 3️⃣ SIGNALER UNE ABSENCE

**Où aller** : http://localhost:8000/mama-ecole/dashboard

**Quoi faire** :
1. Cliquez sur le bouton rouge **"Signaler Absence"**
2. Sélectionnez :
   - L'élève absent
   - La date
3. Cliquez **"Notifier parents"**

**Ce qui se passe** :
- 📞 **Appel immédiat** au parent
- Message vocal : "Votre enfant n'était pas à l'école aujourd'hui"
- Le parent peut appuyer sur :
  - `1` pour répéter
  - `2` pour plus d'infos
  - `3` pour laisser un message

---

### 4️⃣ CONVOQUER À UNE RÉUNION

**Où aller** : http://localhost:8000/mama-ecole/dashboard

**Quoi faire** :
1. Cliquez sur **"Convoquer Réunion"**
2. Remplissez :
   - Date : `15 janvier 2025`
   - Heure : `14h00`
   - Objet : `Remise des bulletins`
3. Sélectionnez les classes concernées
4. Cliquez **"Envoyer convocations"**

**Ce qui se passe** :
- 📞 Chaque parent illettré reçoit un **appel**
- Message : "Réunion importante le 15 janvier à 14 heures pour la remise des bulletins"
- Ils peuvent appuyer sur `4` pour confirmer leur présence

---

## 📊 VOIR LES STATISTIQUES

**Où aller** : http://localhost:8000/mama-ecole/dashboard

**Ce que vous voyez** :
- 👥 **Nombre de parents inscrits** : Total et illettrés
- 📞 **Appels du jour** : Combien d'appels envoyés
- 🌍 **Langues parlées** : Répartition (30% Baoulé, 25% Dioula, etc.)
- ✅ **Taux d'engagement** : Parents qui répondent aux appels

---

## 🧪 TESTER LE SYSTÈME

### Test rapide SMS :

**Où aller** : http://localhost:8000/mama-ecole/test-twilio

**Quoi faire** :
1. Entrez votre numéro : `+33752353581`
2. Tapez un message : `Test Mama École`
3. Cliquez **"Envoyer SMS"**
4. ✅ Vous recevez le SMS sur votre téléphone !

### Test rapide Appel :
1. Même page
2. Cliquez **"Tester un appel"**
3. ✅ Vous recevez l'appel avec message vocal !

---

## 💡 EXEMPLES CONCRETS D'UTILISATION

### Scénario 1 : Bulletin de notes
```
Professeur : L'élève Kouadio a eu 12/20 en Français
Action : Dashboard → Envoyer Notes → Sélectionner classe → Envoyer
Résultat : Sa maman (qui ne sait pas lire) reçoit un appel en Baoulé
Message : "An ba, bi tia Kouadio a ni point 12 français ya"
```

### Scénario 2 : Enfant malade
```
Infirmière : L'élève Aminata a de la fièvre
Action : Dashboard → Message Urgent → "Votre enfant est malade"
Résultat : Papa reçoit immédiatement un appel
Message : "Votre enfant Aminata est à l'infirmerie, venez la chercher"
```

### Scénario 3 : Réunion parents-profs
```
Directeur : Réunion vendredi pour orientation 3ème
Action : Dashboard → Convoquer Réunion → Vendredi 16h
Résultat : Tous les parents illettrés reçoivent un appel
Message : "Réunion importante vendredi à 16h pour l'orientation"
Parents : Appuient sur 4 pour confirmer présence
```

---

## ❓ QUESTIONS FRÉQUENTES

**Q : Les parents doivent-ils avoir un smartphone ?**
R : Non ! Un simple téléphone qui reçoit des appels suffit.

**Q : Ça marche avec tous les opérateurs ?**
R : Oui ! Orange, MTN, Moov, tous fonctionnent.

**Q : Combien ça coûte ?**
R : Avec Twilio Trial : Gratuit (limité)
R : Avec Twilio payant : ~0.05€ par SMS, ~0.10€ par minute d'appel

**Q : Les parents peuvent répondre ?**
R : Oui ! Ils peuvent :
- Appuyer sur des touches pour naviguer
- Laisser des messages vocaux
- Confirmer leur présence aux réunions

**Q : Dans quelles langues ?**
R : Français, Dioula, Baoulé, Bété, Sénoufo (extensible)

---

## 🎯 RÉSUMÉ SIMPLE

**Mama École permet de :**
1. 📞 **Appeler** les parents qui ne savent pas lire
2. 🗣️ **Parler** dans leur langue locale
3. 📊 **Informer** sur les notes, absences, réunions
4. ✅ **Recevoir** des confirmations

**En 3 clics :**
1. Choisir l'information à envoyer
2. Sélectionner les destinataires
3. Envoyer → Les parents sont informés !

---

## 🆘 BESOIN D'AIDE ?

### Si ça ne marche pas :
1. Vérifiez que le serveur est lancé (start-server.bat)
2. Allez sur http://localhost:8000/mama-ecole/test-twilio
3. Testez un SMS simple
4. Si erreur → Vérifiez vos crédits Twilio

### Erreurs courantes :
- ❌ "Server not found" → Lancez start-server.bat
- ❌ "SMS not sent" → Vérifiez le numéro (+33... ou +225...)
- ❌ "Trial account" → Seuls les numéros vérifiés fonctionnent

---

**C'est tout ! Mama École rend l'école accessible aux parents illettrés** 🎓📱