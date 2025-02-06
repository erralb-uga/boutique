-- SQL dump generated using DBML (dbml.dbdiagram.io)
-- Database: MySQL
-- Generated at: 2025-02-06T08:43:34.233Z

CREATE TABLE `Client` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Identifiant unique du client',
  `nom` varchar(255) UNIQUE NOT NULL COMMENT 'Nom du client',
  `adresse` text COMMENT 'Adresse du client'
);

CREATE TABLE `Commande` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Identifiant unique de la commande',
  `date` date DEFAULT (now()) COMMENT 'Date de la commande',
  `client_id` int COMMENT 'Identifiant du client'
);

CREATE TABLE `CommandeDetail` (
  `commande_id` int COMMENT 'Identifiant de la commande',
  `produit_id` int COMMENT 'Identifiant du produit',
  `quantite` int DEFAULT 1 COMMENT 'Quantité de produit',
  PRIMARY KEY (`commande_id`, `produit_id`)
);

CREATE TABLE `Produit` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Identifiant unique du produit',
  `label` varchar(255) UNIQUE NOT NULL COMMENT 'Nom du produit',
  `description` text NOT NULL COMMENT 'Description du produit',
  `prix` decimal DEFAULT 1 COMMENT 'Prix unitaire du produit'
);

ALTER TABLE `Commande` ADD FOREIGN KEY (`client_id`) REFERENCES `Client` (`id`);

ALTER TABLE `CommandeDetail` ADD FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`);

ALTER TABLE `CommandeDetail` ADD FOREIGN KEY (`produit_id`) REFERENCES `Produit` (`id`);
