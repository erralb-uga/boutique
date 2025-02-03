<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$sql = 'INSERT INTO Client (nom, adresse) VALUES '. PHP_EOL;

for ($i = 0; $i < 10; $i++) {
$nom = $faker->name;
$adresse = $faker->address;

$sql .= "('$nom', '$adresse'), ". PHP_EOL;
}

$sql = rtrim($sql, ', '); // Remove the last comma
$sql .= ';'; // Add a semicolon at the end

echo $sql;
?>