<?php
// namespace MyApp;
use MyApp\Utilisateur;
use MyApp\Message;

include('Utilisateur.php');
$utilisateur = new Utilisateur($db);
include('Message.php');
$message = new Message($db);
