# 📚 Gestion de Bibliothèque

Application web de gestion d'une bibliothèque développée avec **Laravel 12** en architecture **MVC**.

---

## 🖥️ Aperçu

| Interface Admin | Interface Utilisateur |
|---|---|
| Dashboard avec statistiques | Catalogue de livres |
| Gestion des livres, auteurs, catégories | Demande d'emprunt |
| Validation des emprunts | Suivi des demandes |
| Gestion des utilisateurs | Profil personnel |

---

## ✨ Fonctionnalités

### 👨‍💼 Côté Admin
- 📊 **Dashboard** — statistiques globales (livres, utilisateurs, emprunts actifs)
- 📖 **Gestion des Livres** — CRUD complet avec photo et gestion du stock
- ✍️ **Gestion des Auteurs** — CRUD complet
- 🗂️ **Gestion des Catégories** — CRUD complet
- 📋 **Gestion des Emprunts** — Approuver / Refuser / Marquer rendu
- 👥 **Gestion des Utilisateurs** — Liste, modifier rôle, supprimer

### 👤 Côté Utilisateur
- 🏠 **Catalogue public** — recherche par titre/ISBN, filtres auteur/catégorie
- 📚 **Emprunter un livre** — demande soumise à validation admin
- 📋 **Mes Emprunts** — suivi des statuts (En attente / Approuvé / Refusé / Retourné)
- 👤 **Profil** — modifier nom, email, téléphone, ville, mot de passe

---

## 🔒 Sécurité

- ✅ Protection **CSRF** sur tous les formulaires
- ✅ Protection **XSS** — échappement automatique avec `{{ }}`
- ✅ Protection **injection SQL** — Eloquent ORM + requêtes préparées
- ✅ **Middleware** de rôles (admin/user)
- ✅ **Hachage** des mots de passe (bcrypt)
- ✅ **Mass Assignment** protégé via `$fillable`

---

## 🛠️ Technologies utilisées

| Technologie | Version | Usage |
|---|---|---|
| PHP | 8.2 | Langage backend |
| Laravel | 12 | Framework MVC |
| MySQL | 8.0 | Base de données |
| phpMyAdmin | — | Gestion base de données |
| XAMPP | — | Environnement local |
| AdminLTE | 3 | Interface admin |
| Bootstrap | 4.6 | Interface publique |
| Font Awesome | 5.15 | Icônes |

---

## ⚙️ Installation

### Prérequis
- PHP >= 8.2
- Composer
- XAMPP (inclut Apache + MySQL + phpMyAdmin)
- Node.js & NPM

### Étapes

**1. Cloner le projet**
```bash
git clone https://github.com/Lilianjerahmeel/Library-Management.git
cd Library-Management
```

**2. Installer les dépendances**
```bash
composer install
npm install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Créer la base de données avec phpMyAdmin**
- Démarrer XAMPP (Apache + MySQL)
- Ouvrir phpMyAdmin → `http://localhost/phpmyadmin`
- Cliquer sur **Nouvelle base de données**
- Nommer la base : `gestion_biblio`
- Encodage : `utf8mb4_unicode_ci`
- Cliquer sur **Créer**

**5. Configurer `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_biblio
DB_USERNAME=root
DB_PASSWORD=
```

**6. Créer les tables**
```bash
php artisan migrate
```

**7. Créer le lien symbolique pour les photos**
```bash
php artisan storage:link
```

**8. Compiler les assets**
```bash
npm run dev
```

**9. Lancer le serveur**
```bash
php artisan serve
```

**10. Accéder à l'application**
```
http://127.0.0.1:8000
```

---

## 🗄️ Structure de la base de données

```
users
├── id, name, email, password
├── telephone, ville, role
└── timestamps

auteurs
└── id, nom, timestamps

categories
└── id, nom, timestamps

livres
├── id, titre, ISBN
├── quantite, photo
├── auteur_id (FK → auteurs)
├── categorie_id (FK → categories)
└── timestamps

emprunts
├── id, user_id (FK → users)
├── livre_id (FK → livres)
├── date_emprunt, date_retour
├── statut (en_attente/approuve/refuse)
└── timestamps
```

---

## 📁 Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuteurController.php
│   │   ├── CategorieController.php
│   │   ├── LivreController.php
│   │   ├── EmpruntController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── UserDashboardController.php
│   │   └── CatalogueController.php
│   └── Middleware/
│       └── AdminMiddleware.php
└── Models/
    ├── User.php
    ├── Auteur.php
    ├── Categorie.php
    ├── Livre.php
    └── Emprunt.php

resources/views/
├── layouts/
│   ├── admin.blade.php
│   └── public.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── auteurs/
│   ├── categories/
│   ├── livres/
│   ├── emprunts/
│   └── users/
├── user/
│   ├── dashboard.blade.php
│   └── emprunts.blade.php
├── catalogue.blade.php
└── profile/
    └── edit.blade.php

routes/
├── web.php
└── auth.php
```

---

## 🔑 Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@admin.com | password |
| Utilisateur | user@user.com | password |

> ⚠️ Pensez à créer ces comptes manuellement via la page d'inscription ou via phpMyAdmin.

---

## 📋 Règles métier

- ❌ Un utilisateur ne peut pas emprunter 2 fois le même livre
- ❌ Emprunt impossible si stock = 0
- ✅ Stock diminue quand emprunt **approuvé**
- ✅ Stock augmente quand livre **retourné**
- ❌ Suppression livre bloquée si emprunt actif
- ❌ Suppression auteur bloquée si livres associés
- ❌ Suppression utilisateur bloquée si emprunts actifs
- ✅ Validation admin obligatoire avant tout emprunt


---

## 📄 Licence

Ce projet est développé dans le cadre d'un projet académique.
