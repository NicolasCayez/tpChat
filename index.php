<?php
include('./models/connect.php');
include('./models/_classes.php');

if(empty($_SESSION['utilisateur'])) {        
    // Permet de détruire la session PHP courante ainsi que toutes les données rattachées
    session_destroy();
    header('Location: ./views/connexion.php');
} elseif (!empty($_SESSION['utilisateur'])) {
    $user = $utilisateur->selectById($_SESSION['utilisateur']['utilisateur_id']);
    $pseudo = $user[0]['utilisateur_pseudo'];
    $userId = $user[0]['utilisateur_id'];
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Chat WebSocket</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo $pseudo; ?></h1>
    <div id="chat-container">
        <div id="chat-messages"></div>
        <form id="message-form">
            <input type="hidden" id="message-user-id" value=<?php echo $userId; ?>>
            <input type="hidden" id="message-pseudo" value=<?php echo $pseudo; ?>>
            <input type="text" id="message-input" placeholder="Écrivez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <script src="./scripts/script.js"></script>
</body>
</html>
