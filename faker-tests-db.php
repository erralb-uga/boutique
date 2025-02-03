<?php
require_once 'vendor/autoload.php';

//On récupère les variables d'environnement grâce à DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// On se connecte à la base de données
$pdo_connection = sprintf('%s:host=%s;dbname=%s', $_ENV['DB_DRIVER'], $_ENV['DB_HOST'], $_ENV['DB_NAME']);
$pdo = new PDO($pdo_connection, $_ENV['DB_USER'], $_ENV['DB_PASS']);


// On supprime la base de données si elle existe
$pdo->exec('DROP DATABASE IF EXISTS ' . $_ENV['DB_NAME']);
// On crée la base de données
$pdo->exec('CREATE DATABASE ' . $_ENV['DB_NAME']);
// On sélectionne la base de données
$pdo->exec('USE ' . $_ENV['DB_NAME']);

// On crée la table Client
$pdo->exec('CREATE TABLE Client (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(30) NOT NULL,
  adresse VARCHAR(50) NOT NULL
)');


//On crée un objet Faker
$faker = Faker\Factory::create('fr_FR');

// On insère des données dans la table Client
for ($i = 0; $i < 10; $i++) {
  $nom = $faker->name;
  $adresse = $faker->address;

  $stmt = $pdo->prepare('INSERT INTO Client (nom, adresse) VALUES (:nom, :adresse)'); // Prepare SQL statement
  $stmt->execute(['nom' => $nom, 'adresse' => $adresse]); // Execute SQL statement
}

echo 'Données insérées avec succès !' . PHP_EOL;

$select = $pdo->query('SELECT * FROM Client'); // Select all records from the Client table
$clients = $select->fetchAll(PDO::FETCH_ASSOC); // Fetch all records as an associative array
foreach ($clients as $client) {
  echo $client['nom'] . ' - ' . $client['adresse'] . PHP_EOL;
}

$pdo = null; // Close the connection

?>