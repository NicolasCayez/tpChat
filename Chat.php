<?php
// Utilisation de l'espace de nom MyApp lié au composer.json
namespace MyApp;

use PDO;
use PDOException;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MyApp\ChatMessage;

class Chat implements MessageComponentInterface {
    protected $clients;


    // Constructeur pour initialiser la liste des clients
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        // include './models/config.php';

    }

    // Méthode appelée lorsqu'un client se connecte
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion! ({$conn->resourceId})\n";
    }

    // Méthode appelée lorsqu'un client envoie un message
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $msgArr = json_decode($msg, true);
        $author = strval($msgArr["author"]);
        $msgTxt = strval($msgArr["message"]);
        echo sprintf('Connexion %d "%s" envoi le message "%s" à %d client(s)' . "\n"
            , $from->resourceId, $author, $msgTxt, $numRecv);
        // $this->saveMsg($msg);
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

    // //méthode d'enregistrement des messages en BDD
    // protected function saveMsg ($msg) {
    //     // Cette fonction sert à démarrer une session PHP (que vous pouvez notamment retrouver dans vos cookies)
    //     // Nous nous en servirons un petit peu plus tard
    //     include ('./models/config.php');
    //     try {
    //         $db = new PDO('mysql:host='.$DB_HOST.';dbname='. $DB_NAME, $BD_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    //     } catch(PDOException $e) {
    //         $db = NULL;
    //         echo ('Erreur: ' . $e->getMessage());
    //     }
    //     $chatMessage = new ChatMessage($db);
    //     // include ('./models/_classes.php');
    //     $msgArr = json_decode($msg, true);
    //     $msgTxt = strval($msgArr["message"]);
    //     $msgAuthorId = strval($msgArr["authorId"]);
    //     $r = $chatMessage->insert($msgTxt, date("Y-m-d H:i:s"), $msgAuthorId);
    // }
}
?>
