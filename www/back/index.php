<?php
require_once 'inc/init.inc.php';


//1- redirection si l'internaute n'est pas connecté :
if(!internauteEstConnecte()) {  // si l'utilisateur n'est pas connecté il ne doit pas avoir accés à la page profil
    header('location:connexion.php');  // nous l'invitons à se connecter
    exit();
}


// 2- préparation du profil à afficher :
//debug($_SESSION);
extract($_SESSION['t_utilisateurs']);   // extrait tous les indices de l'array sous forme de variable auxquelles on affecte la valeur dans l'array. Exemple : $_SESSION['membre']['pseudo']  devient $pseudo = $_SESSION['membre']['pseudo'];

//-----------------------------------------------------------AFFICHAGE---------------------------------------------
require_once 'inc/haut.inc.php';
?>

<div class="container profil">
    <div class="header-img">
        <img src="img/lesfilles.jpg" alt="">
    </div>
    <div class="header-content">
        <h2><?php 
        if(internauteEstConnecteEtAdmin()) echo '<h1 class="text-info">Bonjour '.$prenom . ' '. $nom . ', vous êtes un administrateur !</h1>';
         ?></h2>
        <p><i class="fas fa-map-marker-alt text-info"></i> <?php echo $adresse; ?>&nbsp;&nbsp;<i class="fas fa-city text-info"></i>&nbsp;&nbsp;<?php echo $ville.'&nbsp;-&nbsp;' .$code_postal; ?></p>
        <p><i class="fas fa-envelope text-info"></i>&nbsp;&nbsp;<?php echo $email; ?></p>
    </div>
</div>





<?php

require_once 'inc/bas.inc.php'; // footer et fermeture des balises










