<?php
include('./models/connect.php');
include('./models/_classes.php');

$utilisateurs = $utilisateur->select();

if(empty($_SESSION['utilisateur'])) {        
    // Permet de détruire la session PHP courante ainsi que toutes les données rattachées
    session_destroy();
    header('Location: ./views/connexion.php');
} elseif (!empty($_SESSION['utilisateur'])) {
    $user = $utilisateur->selectById($_SESSION['utilisateur']['utilisateur_id']);
    $pseudo = $user[0]['utilisateur_pseudo'];
}
include('./base_dir.php');
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php $base_dir?>/css/style.css" />
    <title>Index</title>
</head>
<body>
    <header>
        <?php include($base_dir."/views/header.php"); ?>
    </header>
    <h1>index.php</h1>
    <!-- <?php if (isset($pseudo)) {echo '<p>Connecté avec l\'identifiant<strong> '.$pseudo.'</strong></p>';} ?>
    <p><a href="<?php $base_dir?>/controllers/deconnexion.php">Se déconnecter</a></p> -->
    <div id="chat-container">
        <div id="chat-messages"></div>
        <form id="message-form">
            <input type="text" id="message-input" placeholder="Écrivez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <script src="./scripts/script.js"></script>
</body>
</html>
