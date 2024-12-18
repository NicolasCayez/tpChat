<nav>
    <div id="nav-start">
        <img src="<?php $base_dir ?>/img/bedflix-logo.png" alt="Logo" id="logo">
    </div>
    <div id="nav-center">
        <a href="<?php $base_dir?>/index.php">Accueil</a>
        <a href="<?php $base_dir?>/views/lien1.php">Lien1</a>
        <a href="<?php $base_dir?>/views/lien2.php">Lien2</a>
        <a href="<?php $base_dir?>/views/lien3.php">Lien3</a>
    </div>
    <div id="nav-end">
        <?php if (!empty($_SESSION['utilisateur'])) {
            $user = $utilisateur->selectById($_SESSION['utilisateur']['utilisateur_id']);
            echo '<p>Connecté avec l\'identifiant<strong> '.$user[0]['utilisateur_pseudo'].'</strong></p>';
            }?>
        <a href="<?php $base_dir?>/controllers/deconnexion.php">Se déconnecter</a>
    </div>
</nav>