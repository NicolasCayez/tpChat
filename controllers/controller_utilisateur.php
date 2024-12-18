<?php 
include($base_dir.'/models/connect.php');
include($base_dir.'/models/_classes.php');
   
if(!empty($_POST['form_inscription'])) { // test empty + isset sur chaque élément du formulaire
    $utilisateur->insert($_POST['form_nom'], $_POST['form_prenom'], $_POST['form_pseudo'], $_POST['form_mdp'], $_POST['form_role']);
    header('Location: <?php $base_dir?>/views/index.php');
}

?>