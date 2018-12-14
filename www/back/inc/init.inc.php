<?php
/*Ce fichier sera inclus dans TOUS les scripts (hors inc eux mêmes) pour initialiser les éléments suivant :
-connexion à la BDD
- créer ou ouvrir une session
- définir le chemin absolu du site (comme dans wordpress)
-inclure le fichier fonctions.inc.php à la fin de ce fichier pour l'embarquer dans tous les scripts.
*/ 

// -connextion à la BDD :
$pdo = new PDO('mysql:host=settibeldosetti.mysql.db;dbname=settibeldosetti', 
'settibeldosetti',  
'Inessarahtiti790910', 
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') 
);

//- créer ou ouvrir une session :
session_start();


//- définir le chemin absolu du site (comme dans wordpress) :
define('RACINE_SITE', '/');  // cette constante servira à créer les chemins absolus utilisés dans haut.inc.php car ce fichier sera inclus dans des scripts qui se situent dans des dossiers différents du site. On ne peut donc pas faire de chemin relatif dans ce fichier.

// Variables d'affichage :
$contenu ='';
// $contenu_gauche = '';
// $contenu_droite = '';

// inclusion du fichier fonction.inc.php :
require_once ('fonctions.inc.php');
