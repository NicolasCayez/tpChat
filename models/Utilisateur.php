<?php
namespace MyApp;

use PDO;

class Utilisateur
{
    private $insert;
    private $select;
    private $selectById;
    private $selectByPseudo;

    public function __construct($db)
    {
        $this->insert = $db->prepare('INSERT INTO utilisateurs(utilisateur_pseudo, utilisateur_mdp) 
                                        VALUES(:utilisateur_pseudo, :utilisateur_mdp);');
        $this->select = $db->prepare('SELECT * 
                                        FROM utilisateurs;');
        $this->selectById = $db->prepare('SELECT * 
                                            FROM utilisateurs
                                            WHERE utilisateurs.utilisateur_id = :utilisateur_id;');
        $this->selectByPseudo = $db->prepare('SELECT * 
                                                FROM utilisateurs
                                                WHERE utilisateurs.utilisateur_pseudo = :utilisateur_pseudo;');
    }

    public function insert($sPseudo, $sMdp)
    {
        $r = true;
        $this->insert->execute(array(
            ':utilisateur_pseudo' => ucfirst(strtolower($sPseudo)),
            ':utilisateur_mdp' => $sMdp
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

    public function selectById($sIdUtilisateur)
    {
        $this->selectById->execute(array(':utilisateur_id' => $sIdUtilisateur));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function selectByPseudo($sPseudoUtilisateur)
    {
        $this->selectByPseudo->execute(array(':utilisateur_pseudo' => $sPseudoUtilisateur));
        if ($this->selectByPseudo->errorCode() != 0) {
            print_r($this->selectByPseudo->errorInfo());
        }
        return $this->selectByPseudo->fetchAll(PDO::FETCH_ASSOC);
    }
}
