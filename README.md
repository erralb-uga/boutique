# Boutique en ligne

Ce projet présente la conception de la base de données d'une boutique en ligne.

## Fonctionnalités

- Génération du code SQL DDL à partir d'un fichier DBML
- Création de la base de données dans un SGBD
- Génération de données de test
- Insertion des données de test dans la base de données

## Prérequis

Les logiciels suivants sont nécessaires pour exécuter ce projet :

- Git
- PHP 7.4 ou supérieur
- Composer
- NodeJS
- npm
- Un serveur de base de données MySQL ou MariaDB

## Installation

1. Cloner le dépôt
2. Installer les dépendances NodeJS avec `npm install`
3. Installer les dépendances PHP avec `composer install`
4. Dupliquer le fichier `.env.example` en `.env` à la racine du projet et ajoutez-y les informations de connexion à votre base de données
5. Initialiser la base de données avec la génération des données `php boutique-generate.php --dbml --data`

Par défaut, le projet est configuré pour utiliser MySQL. Si vous utilisez PostgreSQL, vous devez modifier le fichier `boutique-generate.php` et retirer l'option `--mysql` de la commande `exec('dbml2sql boutique-schema.dbml -o boutique-schema.sql --mysql');`

## Diagramme ERD

![Diagramme ERD](boutique-erd.svg)