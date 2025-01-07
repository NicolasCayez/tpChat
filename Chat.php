<?php
// Utilisation de l'espace de nom MyApp lié au composer.json
namespace MyApp;

use PDO;
use PDOException;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $chatMessage;
    protected $author;
    protected $oldMsgArr;


    // Constructeur pour initialiser la liste des clients
    public function __construct($db) {
        $this->clients = new \SplObjectStorage;
        require __DIR__ ."/models/ChatMessage.php";
        $this->chatMessage = new ChatMessage($db);
        require __DIR__ ."/models/Utilisateur.php";
        $this->author = new Utilisateur($db);

    }

    // Méthode appelée lorsqu'un client se connecte
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion! ({$conn->resourceId})\n";
        //* TEST chargement messages
        $oldMsgArr = $this->getOldMsg();
        foreach ($oldMsgArr as $oneOldMsg) {
            $msgAuthor = $this->author->selectById($oneOldMsg["id_utilisateur"]);
            var_dump($msgAuthor[0]["utilisateur_pseudo"]);
            $oneOldMsgToShow = '{"message":"'.$oneOldMsg["message_txt"].'","author":"'.$msgAuthor[0]["utilisateur_pseudo"].'","authorId":"'.$oneOldMsg["id_utilisateur"].'"}';
            $conn->send($oneOldMsgToShow);
        }

    }

    // Méthode appelée lorsqu'un client envoie un message
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $msgArr = json_decode($msg, true);
        $author = strval($msgArr["author"]);
        $msgTxt = strval($msgArr["message"]);
        echo sprintf('Connexion %d "%s" envoi le message "%s" à %d client(s)' . "\n"
            , $from->resourceId, $author, $msgTxt, $numRecv);
        $this->saveMsg($msg);
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

    //méthode d'enregistrement des messages en BDD
    protected function saveMsg ($msg) {
        $msgArr = json_decode($msg, true);
        $msgTxt = strval($msgArr["message"]);
        $msgAuthorId = strval($msgArr["authorId"]);
        $r = $this->chatMessage->insert($msgTxt, date("Y-m-d H:i:s"), $msgAuthorId);
    }

    //méthode de chargement des anciens messages
    protected function getOldMsg () {
        $oldMsgArr = $this->chatMessage->select();
        return($oldMsgArr);
    }
}
?>
