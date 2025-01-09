# Projet Symfony

Ce projet utilise le framework Symfony.
Ce guide vous permettra de démarrer rapidement avec l'installation, la configuration, et l'exécution du projet.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants sur votre machine :

- **PHP** (version >= 8.0)
- **Composer**
- **Symfony CLI**
- **Serveur de base de données** (MySQL)

## Étapes pour démarrer le projet

### 1. Installer les dépendances

```bash
composer install
```

### 2. Configurer l'environnement

```bash
cp .env .env.local
```

Modifiez le fichier .env.local pour configurer les paramètres de votre base de données et autres variables d'environnement :

```bash
DATABASE_URL="mysql://root:mot_de_pase@127.0.0.1:3307/nom_de_votre_base_de_donnees"
```

### 3. Préparer la base de données

Si vous n'avez pas encore cloné le projet, commencez par le faire via Git :

```bash
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

### 4. Démarrer le serveur Symfony

```bash
php bin/console server:run
```