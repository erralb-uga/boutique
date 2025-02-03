# Boutique en ligne

Ce projet présente la conception de la base de données d'une boutique en ligne.

## Fonctionnalités

- Génération du code SQL DDL à partir d'un fichier DBML
- Création de la base de données dans un SGBD
- Génération de données de test
- Insertion des données de test dans la base de données

## Prérequis

- Git
- PHP 7.4 ou supérieur
- Composer
- NodeJS
- npm
- Un serveur de base de données MySQL ou MariaDB

## Installation

1. Clonez le dépôt
2. Installez les dépendances NodeJS avec `npm install`
3. Installer les dépendances PHP avec `composer install`
4. Créez un fichier `.env` à la racine du projet et ajoutez-y les informations de connexion à votre base de données
5. Créez la base de données avec `php boutique-generate.php --dbml --data`

## Diagramme ERD

![Diagramme ERD](boutique-erd.svg)