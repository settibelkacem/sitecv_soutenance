<?php

//1/---------------------------fonction de debug------------------------------------

function debug($param) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}


//2/--------------------------fonction membres--------------------------------------

    // Fonction qui indique si l'internaute est connécté :
    function internauteEstConnecte() {
        if(isset($_SESSION['t_utilisateurs'])) {  // si la session "utilisateur" existe, c'est que l'internaute est passé par la page de connexion et nous avons créé cet indice dans $_SESSION
            return true;
        } else {
            return false;
        }
        
       
    }

//3/ Fonctionqui indique si l'utilisateur est admin connecté :
function internauteEstConnecteEtAdmin() {
    if(internauteEstConnecte() && $_SESSION['t_utilisateurs']['statut'] == 1){ // si membre est connecté et que son statut dans la session vaut 1, il est admin connecté
            return true;
    }else {
        return false;
    }
    // OU :
    // return (internauteEstConnecte() && $_SESSION['t_utilisateurs']['statut'] == 1);
}

//3/---------------------------------------------------------------------Fonction de Requêtte : ---------------------------------------------------------------------
function executeRequete($req, $param = array()) {   // cette fonction attend 2 valeurs : 1 requête SQL (obligatoire) et un array qui associe les marqueurs aux valeurs (non obligatoire car on a affecté au paramètre un array() vide par défaut)

    // Echappement des données reçues avec htmlspecialchars :
    if (!empty($param)) {  // si l'array $param n'est pas vide, je peux faire la boucle :

        foreach($param as $indice => $valeur) {
            $param[$indice] = htmlspecialchars($valeur, ENT_QUOTES);  // ici , on échappe les valeurs de $param que l'on remet à leur place dans $param[$indice]
            // convertit les caractères spéciaux (<, >, &, "", '') en entités HTML (exemple : le < devient &lt;) ce qui permet de rendre inoffensives les balises HTML. On parle d'échappement des données reçues.
        }
    }

    global $pdo;   // permet d'avoir accès à la variable $pdo définie dans l'espace global (c'est-à-dire hors de cette fonction) au sein de cette fonction

    $result = $pdo->prepare($req); // on prépare la requête envoyée à notre fonction
    $result->execute($param);   /// on exécute la requête en lui donnant l'array présent dans $param qui associe tous les marqueurs à leur valeur
    return $result;   // on retourne le résultat de la requête de SELECT


}// fin de function executeRequete($req, $param = array())
