# Studena

## Description

Studena est une plateforme de gestion d'étudiants développée avec Laravel (backend) et Angular (frontend).
Studena – Matchmaking Tuteurs / Élèves
Approche choisie
J’ai choisi une architecture Laravel + Angular :

Laravel sert de backend API :

Modélisation des tuteurs, élèves, matières, niveaux, disponibilités.

Algorithme de matchmaking côté serveur (service dédié).

Exposition de routes /api/... pour que le front récupère les données.

Angular sert de frontend :

Affiche la liste des élèves.

Permet de sélectionner un élève et d’afficher la liste des tuteurs recommandés.

Consomme l’API Laravel via HttpClient.

Pourquoi cette approche :

Séparation claire des responsabilités (API / UI).

Facile à tester et à faire évoluer (on peut remplacer le front ou le back indépendamment).

Proche d’une architecture moderne utilisée en production (SPA + API).

Critères de scoring
Pour chaque élève, l’algorithme évalue chaque tuteur et lui attribue un score de compatibilité entre 0 et 100.
Les critères pris en compte sont :

Correspondance des matières

Compatibilité du niveau scolaire

Chevauchement des disponibilités

Expérience du tuteur (bonus)

Un tuteur sans matière commune avec l’élève est automatiquement exclu (score 0).

Pondérations
Les pondérations choisies sont les suivantes :

Matières : 50%

Si au moins une matière demandée par l’élève est enseignée par le tuteur → +50 points.

Sinon → score 0 (le tuteur n’est pas retenu).

Niveau scolaire : 30%

Si le niveau de l’élève fait partie des niveaux pris en charge par le tuteur → +30 points.

Sinon → +0 point sur ce critère.

Disponibilités : 20%

On recherche au moins un créneau avec :

le même jour (day_of_week)

un chevauchement entre les plages horaires (start/end).

Si un chevauchement existe → +20 points.

Sinon → +0 point sur ce critère.

Expérience : 0 à 10 points (bonus)

+2 points par année d’expérience, plafonné à 10 points.

Le score final est borné entre 0 et 100.
Les tuteurs sont ensuite triés par score décroissant pour afficher les meilleurs matchs en premier.

Justification des pondérations :

La matière est le critère principal (inutile de proposer un tuteur qui ne fait pas la bonne matière).

Le niveau assure que le tuteur est à l’aise avec le programme.

Les disponibilités sont essentielles mais viennent après la compétence.

L’expérience permet de départager deux 

## Installation

### Backend Laravel

1. **Cloner le repository**
```bash
git clone https://github.com/MonicaRandriamialison/Studena.git
cd Studena
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

Dans le fichier `.env`, configurer SQLite :
```
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite
```

5. **Créer le fichier de base de données**
```bash
touch database/database.sqlite
```

6. **Lancer les migrations et seeds**
```bash
php artisan migrate --seed
```

7. **Démarrer le serveur Laravel**
```bash
php artisan serve
```

Le backend sera accessible sur **http://127.0.0.1:8000** (ou http://localhost:8000).

### Frontend Angular

1. **Aller dans le dossier Angular**
```bash
cd studena-frontend
```

2. **Installer les dépendances Node**
```bash
npm install
```

3. **Lancer l'application Angular**
```bash
ng serve
```

L'application sera accessible sur **http://localhost:4200**.

## Technologies utilisées

- **Backend** : Laravel, PHP, SQLite
- **Frontend** : Angular, TypeScript

## Contributeur

Monica Randriamialison
