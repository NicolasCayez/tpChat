<?php
    include('../models/connect.php');
    include('../models/_classes.php');
    if(!empty($_POST['form_connexion']) && isset($_POST['form_connexion'])
        && !empty($_POST['form_pseudo']) && isset($_POST['form_pseudo'])
        && !empty($_POST['form_password']) && isset($_POST['form_password'])) {
        $pseudo = htmlentities(htmlspecialchars(strip_tags($_POST['form_pseudo'])));
        $password = htmlentities(htmlspecialchars(strip_tags($_POST['form_password'])));
        $utilFound = $utilisateur->selectByPseudo($pseudo);
        if(count($utilFound) === 1){
            $user = $utilFound[0];
            // La fonction rowCount() permet de donner le nombre de lignes pour une requête
            if($user['utilisateur_pseudo'] != NULL) {
                // Permet de vérifier le hash par rapport au mot de passe saisi
                if(password_verify($password, $user['utilisateur_mdp'])) {
                    // On affecte les données de notre utilisateur dans notre super globale $_SESSION
                    $_SESSION['utilisateur'] = $user;
                    // Le header permet d'effectuer une requête HTTP, la valeur Location permet la redirection vers un autre fichier
                    // header('Location: '.$base_dir.'/index.php');
                    header('Location: ../index.php');
                }
            }
        } else {
            unset($_SESSION['utilisateur']);
            header('Location: ../index.php');
        }
    }
?>




