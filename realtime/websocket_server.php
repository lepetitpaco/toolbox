<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use WordCounter\WordCounter;

require dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables and establish a database connection
require __DIR__ . '/../../config/config.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config/');
$dotenv->load();

// db creds
$dbHost = $_ENV['DBHOST'];
$dbUser = $_ENV['DBUSER'];
$dbPass = $_ENV['DBPASS'];
$dbName = $_ENV['DBNAME'];

// Establish a database connection
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

try {
    // Pass the database connection to the WordCounter constructor
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new WordCounter($connection), // Pass the connection here
            )
        ),
        8090 // The port the WebSocket server will listen on
    );

    $server->run();
} catch (\Exception $e) {
    // Log the error or handle it appropriately
    echo 'Error starting WebSocket server: ' . $e->getMessage();
}
