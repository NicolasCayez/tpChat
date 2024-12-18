<?php
    session_start();
    include 'config.php';
    // Cette fonction sert à démarrer une session PHP (que vous pouvez notamment retrouver dans vos cookies)
    // Nous nous en servirons un petit peu plus tard
    try {
        $db = new PDO('mysql:host='.$DB_HOST.';dbname='. $DB_NAME, $BD_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch(PDOException $e) {
        $db = NULL;
        echo ('Erreur: ' . $e->getMessage());
    }
?>