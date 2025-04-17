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

### 1. Installer Git (si ce n’est pas déjà fait)

- Windows : https://git-scm.com/download/win
- Mac : `brew install git`
- Linux : `sudo apt install git`

---

### 2. Cloner le projet dans `htdocs`

```bash
git clone https://github.com/Foltry/ProjetCovoit.git
```

> Remplace `TON_USER` par ton nom d’utilisateur GitHub si besoin.

---

### 3. Démarrer Apache & MySQL dans XAMPP

---

### 4. Accéder à l’installation automatique

Ouvre cette URL dans ton navigateur :

```
http://localhost/ProjetCovoit/fixtures.php
```

Cela va :
- Créer la base de données
- Insérer des utilisateurs et trajets de test

Puis accède à :

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

## 📜 Licence

MIT - libre d’usage et de modification.
