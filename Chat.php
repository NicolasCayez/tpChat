<?php
// Utilisation de l'espace de nom MyApp lié au composer.json
namespace MyApp;
include('./models/connect.php');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
// use MyApp\Message;
// include('models/Message.php');
// use MyApp\Utilisateur;

class Chat implements MessageComponentInterface {
    protected $clients;

    // Constructeur pour initialiser la liste des clients
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // Méthode appelée lorsqu'un client se connecte
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion! ({$conn->resourceId})\n";
    }
    // Méthode appelée lorsqu'un client envoie un message
    public function onMessage(ConnectionInterface $from, $msg) {
        include('./models/_classes.php');

        $numRecv = count($this->clients) - 1;
        echo sprintf('Connexion %d envoi le message "%s" à %d client(s)' . "\n"
            , $from->resourceId, $msg, $numRecv);

        
        $message = new Message($db);
        $message->insert($msg, time(), 1);
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    // Méthode appelée lorsqu'un client se déconnecte
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connexion {$conn->resourceId} déconnectée\n";
    }

    // Méthode appelée lorsqu'une erreur survient
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Une erreur est survenue : {$e->getMessage()}\n";
        $conn->close();
    }
}
?>
