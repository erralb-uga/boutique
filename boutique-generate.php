<?php

require_once 'vendor/autoload.php'; // Load the Composer autoloader to use Dotenv

/**
 * DOTENV and PHP Constants
 */

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define PHP constants from .env file
define('DB_DRIVER', $_ENV['DB_DRIVER']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DBML_FILE', $_ENV['DBML_FILE']);
define('SVG_FILE', $_ENV['SVG_FILE']);
define('DDL_FILE', $_ENV['DDL_FILE']);
define('FAKER_FILE', $_ENV['FAKER_FILE']);
define('DML_FILE', $_ENV['DML_FILE']);

/**
 * Get command line options
 */

//get command line options parameters ( https://www.php.net/manual/en/function.getopt.php )
// --dbml to regenerate SQL schema from DBML file
// --generate to generate SQL data from PHP file with Faker
// --data to import SQL data from SQL file : Will drop and recreate the database
$opts = getopt('', ['dbml', 'generate', 'data']);

/**
 * Manage DBML conversion
 */

//generate SQL and SVG schema from DBML file if the option is provided and the file exists
if (isset($opts['dbml'])) {
    if (!file_exists(DBML_FILE)) {
        echo 'Please provide the DBML file';
        exit(1);
    }
    shell_exec('npx dbml2sql ' . DBML_FILE . ' -o ' . DDL_FILE . ' --' . DB_DRIVER); //generate SQL schema
    shell_exec('npx dbml-renderer -i ' . DBML_FILE . ' -o ' . SVG_FILE); //generate SVG schema
}

/**
 * Manage SQL data generation with Faker
 */

// Call Faker script if the option is provided
if (isset($opts['generate'])) {
    require_once FAKER_FILE;
}

/**
 * Manage SQL schema and data import
 */

if (isset($opts['data'])) {

    if (!file_exists(DML_FILE) or !file_exists(DDL_FILE)) {
        echo 'Please provide the DDL and DML files';
        exit(1);
    }

    // Create a new PDO instance to connect to the database
    $pdo = new PDO(DB_DRIVER . ':host=' . DB_HOST, DB_USER, DB_PASS);

    // Drop and recreate the database
    $pdo->exec('DROP DATABASE IF EXISTS ' . DB_NAME);
    $pdo->exec('CREATE DATABASE ' . DB_NAME);
    $pdo->exec('USE ' . DB_NAME);

    // Import the SQL schema
    $sql = file_get_contents(DDL_FILE);
    $pdo->exec($sql);

    //Import the data from SQL file
    $sql = file_get_contents(DML_FILE);
    $pdo->exec($sql);
}
