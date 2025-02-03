<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$clients = [];
$produits = [];
$commandes = [];
$commandes_details = [];

//On doit toujours commencer par créer les types d'entités qui n'ont pas de dépendances (ici Clients et Produits)

for ($i = 0; $i < 5; $i++) {
    $clients[] = [
        'id' => $i + 1,
        'nom' => $faker->unique()->name,
        'adresse' => $faker->address,
    ];
}
//On obtient donc un tableau de clients avec 5 clients d'id 1 à 5

for ($i = 0; $i < 10; $i++) {
    $produits[] = [
        'id' => $i + 1,
        'label' => $faker->unique()->word,
        'description' => $faker->sentence,
        'prix' => $faker->randomFloat(2, 1, 100),
    ];
}
//On obtient donc un tableau de produits avec 10 produits d'id 1 à 10

//On peut maintenant créer les commandes et les lignes de commande

//On commence par récupérer les id des produits pour les utiliser dans les lignes de commande
$produitsIds = array_column($produits, 'id');

//On crée les scénarios suivants :

// Client 1 pas de commandes
// rien à faire

// Client 2 a commandé tous les produits à travers plusieurs commandes
// On va créer 10 commandes pour le client 2, chaque commande contiendra un produit différent
for ($i = 0; $i < 10; $i++) {
    $commandeId = count($commandes) + 1; //On récupère l'id de la commande en cours (nombre de commandes + 1)
    $commandes[] = [
        'id' => $commandeId,
        'date' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
        'clientId' => 2,
    ];

    $commandes_details[] = [
        'commandeId' => $commandeId,
        'produitId' => $produitsIds[$i],
        'quantite' => $faker->numberBetween(1, 5),
    ];
}

// Client 3 a commandé 10 fois un produit
// On va créer 10 commandes pour le client 3, chaque commande contiendra le même produit, le produit 1, en quantité 1
for ($i = 0; $i < 10; $i++) {
    $commandeId = count($commandes) + 1;
    $commandes[] = [
        'id' => $commandeId,
        'date' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
        'clientId' => 3,
    ];

    $commandes_details[] = [
        'commandeId' => $commandeId,
        'produitId' => 1,
        'quantite' => 1,
    ];
}

// Client 4 a commandé tous les produits à travers une seule commande

//On crée une commande pour le client 4
$commandeId = count($commandes) + 1;
$commandes[] = [
    'id' => $commandeId,
    'date' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
    'clientId' => 4,
];

//On ajoute une ligne de commande pour chaque produit
foreach ($produitsIds as $produitId) {
    $commandes_details[] = [
        'commandeId' => $commandeId,
        'produitId' => $produitId,
        'quantite' => $faker->numberBetween(1, 5),
    ];
}

// Client 5 a commandé un seul produit à travers une seule commande
$commandeId = count($commandes) + 1;
$commandes[] = [
    'id' => $commandeId,
    'date' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
    'clientId' => 5,
];

$commandes_details[] = [
    'commandeId' => $commandeId,
    'produitId' => 1,
    'quantite' => 1,
];

//On stocke le tout dans un tableau PHP
$result = [
    'clients' => $clients,
    'produits' => $produits,
    'commandes' => $commandes,
    'commandes_details' => $commandes_details,
];

//Création des requêtes SQL pour insérer les données dans la base de données
$sql = '';

foreach ($clients as $client) {
    $sql .= "INSERT INTO Client (id, nom, adresse) VALUES ({$client['id']}, '{$client['nom']}', '{$client['adresse']}');" . PHP_EOL;
}

foreach ($produits as $produit) {
    $sql .= "INSERT INTO Produit (id, label, description, prix) VALUES ({$produit['id']}, '{$produit['label']}', '{$produit['description']}', {$produit['prix']});" . PHP_EOL;
}

foreach ($commandes as $commande) {
    $sql .= "INSERT INTO Commande (id, date, client_id) VALUES ({$commande['id']}, '{$commande['date']}', {$commande['clientId']});" . PHP_EOL;
}

foreach ($commandes_details as $ligneCommande) {
    $sql .= "INSERT INTO CommandeDetail (commande_id, produit_id, quantite) VALUES ({$ligneCommande['commandeId']}, {$ligneCommande['produitId']}, {$ligneCommande['quantite']});" . PHP_EOL;
}

//On écrit les requêtes SQL dans un fichier SQL pour sauvegarde
file_put_contents('boutique-data.sql', $sql);

echo 'Fichier SQL généré avec succès !' . PHP_EOL;

// //Optionnellement, on peut sauvegarder les données au format JSON pour sauvegarde
// file_put_contents('boutique-data.json', json_encode($result, JSON_PRETTY_PRINT));
