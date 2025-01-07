<?php

use MyApp\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use MyApp\ChatMessage;

// Inclusion de l'autoloader de Composer pour charger les dépendances
require __DIR__ ."/vendor/autoload.php";
require __DIR__ ."/models/connect.php";

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat($db)
        )
    ),
    // Port d'écoute du serveur WebSocket
    8080
);

echo "Serveur WebSocket démarré sur http://127.0.0.1:8080\n";
echo "Chat sur http://127.0.0.1/tpchat\n";

$server->run();
