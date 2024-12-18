<?php
namespace MyApp;

use PDO;

class Message
{
    private $insert;
    private $select;
    private $selectById;
    private $selectByIdUtilisateur;

    public function __construct($db)
    {
        $this->insert = $db->prepare('INSERT INTO messages(message_txt, message_date, id_utilisateur) 
                                        VALUES(:message_txt, :message_date, :id_utilisateur);');
        $this->select = $db->prepare('SELECT * 
                                        FROM messages;');
        $this->selectById = $db->prepare('SELECT * 
                                            FROM messages
                                            WHERE messages.message_id = :message_id;');
        $this->selectByIdUtilisateur = $db->prepare('SELECT * 
                                                FROM messages
                                                WHERE messages.utilisateur_id = :utilisateur_id;');
    }

    public function insert($sMsgTxt, $sMsgDate, $sIdUtil)
    {
        $r = true;
        $this->insert->execute(array(
            ':message_txt' => $sMsgTxt,
            ':message_date' => $sMsgDate,
            ':id_utilisateur' => $sIdUtil
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

    public function selectById($sIdMsg)
    {
        $this->selectById->execute(array(':utilisateur_id' => $sIdMsg));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function selectByIdUtilisateur($sIdUtil)
    {
        $this->selectByIdUtilisateur->execute(array(':utilisateur_id' => $sIdUtil));
        if ($this->selectByIdUtilisateur->errorCode() != 0) {
            print_r($this->selectByIdUtilisateur->errorInfo());
        }
        return $this->selectByIdUtilisateur->fetchAll(PDO::FETCH_ASSOC);
    }
}
