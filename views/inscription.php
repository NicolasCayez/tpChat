<?php
    // On inclut notre connecteur à la base de données
    include('../models/connect.php');
    include('../models/_classes.php');

    // On entre dans la boucle seulement lors de l’envoi du formulaire
    if(!empty($_POST['form_inscription']) && isset($_POST['form_inscription'])
        && !empty($_POST['form_pseudo']) && isset($_POST['form_pseudo'])
        && !empty($_POST['form_password']) && isset($_POST['form_password'])) {
        // Nettoyage des entrées
        $pseudo = htmlentities(htmlspecialchars(strip_tags($_POST['form_pseudo'])));
        $password = htmlentities(htmlspecialchars(strip_tags($_POST['form_password'])));

        // On recherche si l'adresse email existe déjà en BDD
        if(empty($utilisateur->selectByPseudo($pseudo))) {
            // Si ce n'est pas le cas, on vient l'insérer
            // Insertion, true si réussi, false si raté
            if($utilisateur->insert($pseudo, password_hash($password, PASSWORD_BCRYPT, array('cost' => 12)))) {
                // Si aucune erreur ne se produit, on propose de se connecter
                die('<p style=”color: green;”>Inscription réussie.</p><a href="../views/connexion.php">Se connecter.</a>');
            }
            die('<p style=”color: red;”>Inscription échouée.</p><a href="../views/inscription.php">Réessayer.</a>');
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" />
    <title>Inscription</title>
</head>
<body class="body_custom">
    <div class="custom_card">
        <h1>Inscription</h1>
        <form method="post">
            <input type="hidden" name="form_inscription" value="1">
            <label for="form_pseudo">Pseudonyme:</label>
            <input type="text" name="form_pseudo" placeholder="votre pseudonyme" class="margin-top-5">
            <br>
            <label for="form_password">Mot de passe:</label>
            <input type="password" name="form_password" placeholder="1234" class="margin-top-5">
            <br>
            <input type="submit" value="S'inscrire" class="margin-top-5">
        </form>
    </div>
</body>
</html>
