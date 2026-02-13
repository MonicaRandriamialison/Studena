1. Lancer le backend Laravel
Cloner le repo :
git clone https://github.com/MonicaRandriamialison/Studena.git
cd Studena

Installer les dépendances PHP :
composer install

Configurer l’environnement :
cp .env.example .env
php artisan key:generate

Configurer la base de données dans .env (SQLite simple) :
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite

Créer le fichier :
touch database/database.sqlite

Lancer migrations + seeds :
php artisan migrate --seed

Démarrer le serveur Laravel :
php artisan serve
Le backend sera sur http://127.0.0.1:8000 (ou http://localhost:8000).

2. Lancer le frontend Angular
Dans un autre terminal :
Aller dans le dossier Angular (exemple) :
cd Studena/frontend   # ou le chemin réel de ton app Angular

Installer les dépendances Node :
npm install

Lancer l’app Angular :
ng serve
Par défaut, Angular tourne sur http://localhost:4200.

