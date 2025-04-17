# 🚗 Projet Covoiturage (PHP + Bootstrap)

Application web de covoiturage écrite en PHP, avec gestion des trajets, réservations, comptes utilisateurs, et notifications. Interface en Bootstrap 5, base de données MySQL.

---

## 📦 Fonctionnalités

- 🔐 Authentification (inscription, connexion, déconnexion)
- 👤 Gestion de compte
- 🚗 Création et annulation de trajets
- 📅 Réservations de trajets
- 🔎 Recherche multicritères
- 🧾 Historique & notifications
- 🛠 Fichiers fixtures pour base de données

---

## 🔧 Installation locale (XAMPP)

1. Clone ce dépôt dans ton dossier `htdocs` :
   ```bash
   git clone https://github.com/TON_USER/ProjetCovoit.git
   ```

2. Démarre Apache & MySQL dans XAMPP

3. Accède à :
   ```
   http://localhost/ProjetCovoit/fixtures.php
   ```
   Cela va :
   - Créer la base de données
   - Insérer des utilisateurs et trajets de test

4. Va sur :
   ```
   http://localhost/ProjetCovoit
   ```

---

## 👤 Comptes de test

### 🔑 Admin
- Email : `testuser1@example.com`
- Mot de passe : `password1`

### 👥 Autres utilisateurs :
- `testuser2@example.com` → `password2`
- `testuser3@example.com` → `password3`
- etc.

---

## 🧪 Test automatique

Un script de test Python est fourni :
```bash
python test_projet_covoit_report.py
```

Ce script :
- se connecte
- teste les pages
- vérifie les alertes
- génère un rapport HTML (`rapport_test_covoit.html`)

---

## 💻 Dépendances (pour les tests Python)

```bash
pip install requests beautifulsoup4
```

---

## 🔒 Dépôt privé mais partageable

Tu peux inviter des collaborateurs dans **Settings > Collaborators** sur GitHub.

---

## 📜 Licence

MIT - libre d’usage et de modification.
