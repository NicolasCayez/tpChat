<?php
// Utilisation de l'espace de nom MyApp lié au composer.json
namespace MyApp;

use PDO;

class ChatMessage
{
    private $insert;
    private $select;
    private $selectByUtilId;

    public function __construct($db)
    {
        $this->insert = $db->prepare('INSERT INTO messages(message_txt, message_date, id_utilisateur) 
                                        VALUES(:message_txt, :message_date, :id_utilisateur);');
        $this->select = $db->prepare('SELECT * 
                                        FROM messages;');
        $this->selectByUtilId = $db->prepare('SELECT * 
                                            FROM messages
                                            WHERE messages.id_utilisateur = :id_utilisateur;');
    }

    public function insert($sTxt, $sdate, $sUtilId)
    {
        $r = true;
        $this->insert->execute(array(
            ':message_txt' => ucfirst(strtolower($sTxt)),
            ':message_date' => $sdate,
            ':id_utilisateur' => $sUtilId
        ));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select()
    {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectByUtilId($sIdUtilisateur)
    {
        $this->selectByUtilId->execute(array(':id_utilisateur' => $sIdUtilisateur));
        if ($this->selectByUtilId->errorCode() != 0) {
            print_r($this->selectByUtilId->errorInfo());
        }
        return $this->selectByUtilId->fetchAll(PDO::FETCH_ASSOC);
    }
}
