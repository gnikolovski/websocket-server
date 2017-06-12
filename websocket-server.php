<?php

use Dotenv\Dotenv;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Communicator;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv(__DIR__);
$dotenv->load();
$dotenv->required('PORT');

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Communicator()
        )
    ),
    getenv('PORT')
);

$server->run();
