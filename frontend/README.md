# EduSchedulePro

## Description
EduSchedulePro est une application web de gestion des emplois du temps pour établissements d'enseignement. Elle permet de gérer les classes, les enseignants, les matières, les salles et les emplois du temps via une interface moderne et intuitive.

## Ce qui a été réalisé

### 1. Configuration de l'environnement
- Installation et configuration de Git
- Création du compte GitHub (ahibo-rst)
- Création du dépôt eduschedulepro sur GitHub
- Configuration de WAMP (serveur local Apache + MySQL + PHP)

### 2. Base de données MySQL
- Création de la base de données eduschedulepro
- 11 tables créées :
  - classes : Licence 1, 2, 3 et Master 1, 2
  - matieres : gestion des matières avec code et libellé
  - enseignants : nom, prénom, email, spécialité, statut
  - salles : code, capacité, bâtiment
  - utilisateurs : authentification avec hash de mot de passe
  - emploi_temps : planning des cours
  - creneaux : créneaux horaires
  - pointages : suivi des présences
  - cahiers_texte : cahiers de texte des cours
  - signatures : signatures électroniques
  - vacations : gestion des vacations
- Données de démonstration insérées (5 classes, 5 matières, 5 enseignants, 4 salles, 5 utilisateurs)

### 3. Backend PHP (API REST)
- config/database.php : connexion MySQL avec PDO
- config/cors.php : gestion des headers CORS pour React
- middleware/auth.php : vérification des tokens
- api/login.php : authentification avec password_hash et token
- api/classes.php : CRUD des classes
- api/enseignants.php : CRUD des enseignants
- api/matieres.php : CRUD des matières
- api/salles.php : CRUD des salles
- api/pointages.php : gestion des pointages
- api/cahiers_texte.php : gestion des cahiers de texte
- api/utilisateurs.php : gestion des utilisateurs

### 4. Frontend React.js
- Page de connexion avec email et mot de passe
- Dashboard avec menu latéral
- Tableau de bord avec statistiques (classes, enseignants, matières, salles)
- Pages : Classes, Enseignants, Matières, Salles, Emploi du temps
- Styles CSS complets (sidebar, tableaux, formulaires)

### 5. Connexion Frontend ↔️ Backend
- API REST PHP connectée à React via fetch
- Gestion des erreurs CORS résolue
- Authentification fonctionnelle avec token

## Technologies utilisées
- *Frontend* : React.js, CSS3
- *Backend* : PHP 8
- *Base de données* : MySQL
- *Serveur local* : WAMP64
- *Versioning* : Git + GitHub

## Installation

### Prérequis
- WAMP installé et lancé (icône verte)
- Node.js installé
- Git installé
## Ce qui fonctionne

### Base de données
- Base de données MySQL eduschedulepro créée et fonctionnelle
- 11 tables créées avec données de démonstration
- 5 classes (Licence 1, 2, 3 et Master 1, 2)
- 5 enseignants, 5 matières, 4 salles, 5 utilisateurs

### Backend PHP
- Connexion MySQL avec PDO fonctionnelle
- CORS configuré et fonctionnel
- Login avec authentification par token fonctionnel
- API classes.php fonctionnelle et retourne les données
- API enseignants, matieres, salles créées

### Frontend React
- Page de connexion fonctionnelle
- Connexion réussie avec admin@isge.bf / password
- Dashboard avec menu latéral fonctionnel
- Tableau de bord avec statistiques affiché

## Technologies
- React.js, PHP 8, MySQL, WAMP64, Git/GitHub

## Identifiants
- Email : admin@isge.bf
- Mot de passe : password
### Étapes
1. Cloner le dépôt :
```bash
git clone https://github.com/ahibo-rst/eduschedulepro.git


