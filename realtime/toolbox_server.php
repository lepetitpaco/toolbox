<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use RealTime\App\CombinedHandler;

require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/../../config/config.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config/');
$dotenv->load();

$dbConnection = mysqli_connect($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS'], $_ENV['DBNAME']);

if (!$dbConnection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new CombinedHandler($dbConnection, $_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS'], $_ENV['DBNAME'])
        )
    ),
    8090
);

$server->run();
