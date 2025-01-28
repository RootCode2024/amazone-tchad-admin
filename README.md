# Amazone Tchad Admin

Ce projet est une application Laravel pour la gestion administrative d'Amazone Tchad.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants :
- [PHP](https://www.php.net/) (version 8.1 ou supérieure)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) ou tout autre SGBD compatible
- [Git](https://git-scm.com/)
- Une copie de Laravel installé globalement ou via Composer

## Installation

### 1. Cloner le projet
Clonez le dépôt Git sur votre machine locale :
```bash
git clone https://github.com/votre-utilisateur/amazone-tchad-admin.git
```

Accédez au répertoire du projet :

```bash
cd amazone-tchad-admin
```

### 2. Configuration de l'environnement
Copiez le fichier .env.example et renommez-le en .env :

```bash
cp .env.example .env
```
Configurez les variables d'environnement dans le fichier .env (base de données, etc.).

### 3. Installer les dépendances

Installez les dépendances PHP avec Composer :

```bash
composer install
```
### 4. Générer la clé d'application

Générez une clé d'application unique :

```bash
php artisan key:generate
```

### 5. Exécuter les migrations

Créez la base de données et exécutez les migrations pour préparer les tables :

```bash
php artisan migrate
```

### 6. Lancer le serveur de développement
Démarrez le serveur de développement Laravel :

```bash
php artisan serve
```
Le projet sera accessible à l'adresse suivante : http://127.0.0.1:8000