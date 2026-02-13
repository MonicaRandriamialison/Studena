# Studena

## Description

Studena est une plateforme de gestion d'étudiants développée avec Laravel (backend) et Angular (frontend).

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
