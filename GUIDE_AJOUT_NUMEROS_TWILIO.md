# 📱 GUIDE - Ajouter d'autres numéros pour MAMA ÉCOLE

## 🔒 Mode Trial Actuel (GRATUIT)

### Pour ajouter un nouveau numéro :

1. **Connectez-vous à Twilio Console**
   - URL : https://console.twilio.com
   - Identifiants dans `.env` du projet

2. **Vérifier un nouveau numéro**
   - Allez dans : **Phone Numbers** → **Verified Caller IDs**
   - Cliquez sur **"Add a new Caller ID"**
   - Entrez le numéro (format international : +225...)
   - Twilio enverra un code de vérification par SMS
   - Entrez le code pour valider

3. **Numéros vérifiables**
   - ✅ Côte d'Ivoire : +225XXXXXXXXXX
   - ✅ France : +33XXXXXXXXX
   - ✅ Tous pays supportés par Twilio

### ⚠️ Limitations du mode Trial
- Message commence par : "Sent from your Twilio trial account" (20 secondes)
- Maximum ~10 numéros vérifiés
- Crédit gratuit limité ($15)

---

## 💳 Mode Production (PAYANT - Recommandé)

### Avantages :
- ✅ **TOUS les numéros fonctionnent** sans vérification
- ✅ **Pas de message Twilio** au début
- ✅ **Messages directs** en français
- ✅ **Volume illimité**

### Coûts estimés :
- SMS vers Côte d'Ivoire : ~0,05€/SMS
- Appel vers Côte d'Ivoire : ~0,15€/minute
- Numéro Twilio : ~1€/mois

### Pour passer en production :

1. **Upgrade du compte**
   ```
   Console Twilio → Billing → Upgrade Account
   Ajouter une carte bancaire
   ```

2. **Acheter un numéro Twilio**
   ```
   Phone Numbers → Buy a Number
   Choisir un numéro (de préférence local)
   ```

3. **Mettre à jour `.env`**
   ```env
   TWILIO_PHONE_NUMBER=+225XXXXXXXX  # Nouveau numéro acheté
   ```

---

## 🇨🇮 Alternative Orange CI (Pour la Côte d'Ivoire)

### Configuration Orange SMS API :

1. **Créer un compte Orange Developer**
   - https://developer.orange.com/apis
   - API : Orange SMS CI

2. **Obtenir les credentials**
   ```env
   ORANGE_CLIENT_ID=your_client_id
   ORANGE_CLIENT_SECRET=your_secret
   ORANGE_SMS_SENDER=ECOLE  # Nom affiché
   ```

3. **Avantages**
   - Tarifs locaux avantageux
   - Meilleure réception en CI
   - Support USSD possible

---

## 🚀 Recommandation

**Pour un déploiement réel en Côte d'Ivoire :**

1. **Court terme** : Vérifier les numéros des parents tests dans Twilio Console
2. **Moyen terme** : Passer en compte Twilio Production (~20€/mois)
3. **Long terme** : Intégrer Orange CI API pour les coûts optimaux

---

## 📞 Numéros de test disponibles

### Actuellement vérifiés :
- +33752353581 (France - Fonctionnel)

### À ajouter pour tests :
- Directeur école : +225XXXXXXXXXX
- Parent test 1 : +225XXXXXXXXXX
- Parent test 2 : +225XXXXXXXXXX

---

## 💡 Astuce

Pour tester rapidement avec plusieurs numéros SANS payer :
1. Créez plusieurs comptes Twilio Trial (emails différents)
2. Chaque compte = 1 numéro vérifié gratuit
3. Alternez les comptes selon les besoins

---

## 📧 Support

- Documentation Twilio : https://www.twilio.com/docs
- Support Orange CI : developer.orange.com/support
- Email projet : contact@elibrary.ci