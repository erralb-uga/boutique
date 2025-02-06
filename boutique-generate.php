<?php

require_once 'vendor/autoload.php';

//get opts parameters : --dbml to regenerate SQL schema from DBML file
//get opts parameters : --data to regenerate SQL data from PHP file
$opts = getopt('', ['dbml', 'data']);

if (isset($opts['dbml'])) {
     //regenerate SQL schema from DBML file
    exec('dbml2sql boutique-schema.dbml -o boutique-schema.sql --mysql');
    //generate svg from DBML file
    exec('dbml-renderer -i boutique-schema.dbml -o boutique-erd.svg');
}

if (isset($opts['data'])) { //regenerate SQL data from PHP file
    require_once 'boutique-data.php';
}

// Get connection details data from Dotenv file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// $connection_string = $_ENV['DB_DRIVER'] . ':host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
$connection_string = $_ENV['DB_DRIVER'] . ':host=' . $_ENV['DB_HOST'];

// Create a new PDO instance
$pdo = new PDO($connection_string, $_ENV['DB_USER'], $_ENV['DB_PASS']);


//drop and recreate the database
$pdo->exec('DROP DATABASE IF EXISTS boutique');
$pdo->exec('CREATE DATABASE boutique');
$pdo->exec('USE boutique');

// Import the SQL schema
$sql = file_get_contents('boutique-schema.sql');
$pdo->exec($sql);

//Import the data from SQL file
$sql = file_get_contents('boutique-data.sql');
$pdo->exec($sql);

