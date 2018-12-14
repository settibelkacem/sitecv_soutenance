<?php
require_once 'inc/init.inc.php';

// 1- On vérifie si membre est admin :

if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php'); // si pas admin, on le redirige vers la page de connexion
    exit();
}

extract($_SESSION['t_utilisateurs']);

//-----------------mise à jour d'une experience ---------------
if (!empty($_POST)) {

    $result = executeRequete(
        " UPDATE t_realisations 
                                SET titre_real = :titre_real, stitre_real = :stitre_real, dates_real = :dates_real, description_real = :description_real, id_utilisateur = :id_utilisateur
                                WHERE id_realisation = :id_realisation",
        array(
            ':id_realisation' => $_POST['id_realisation'],
            ':titre_real' => $_POST['titre_real'],
            ':stitre_real' => $_POST['stitre_real'],
            ':dates_real' => $_POST['dates_real'],
            ':description_real' => $_POST['description_real'],
            ':id_utilisateur' => $_POST['id_utilisateur']
        )
    );

    if ($result->rowCount() == 1) { // si j'ai une ligne dans $result, j'ai modifié une competence
        $contenu .= '<div class="alert alert-success" role="alert">la realisation à bien été modifier</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la modification</div>';
    }
}

//-----------------------
$id_realisation = $_GET['id_realisation'];

$resultat = $pdo->query(" SELECT * FROM t_realisations 
                          WHERE id_realisation = '$id_realisation' ");


while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $contenu .= '<form method="post" action="realisations.php">';
        // debug($ligne);

    foreach ($ligne as $indice => $valeur) {
        $contenu .= '<div class="form-group">';

        if ($indice == 'id_realisation' || $indice == 'id_utilisateur') {
            $contenu .= '<input type="hidden" name="' . $indice . '" id="' . $indice . '" value="' . $valeur . '">';

        } else {
            $contenu .= '<label for="' . $indice . '">&nbsp;' . $indice . '</label>';
            $contenu .= '<input class="form-control"  id="' . $indice . '" value="' . $valeur . '" name="' . $indice . '">';
        }

        $contenu .= '</div>';

    }
    $contenu .= '<input type ="submit" id="' . $ligne['id_realisation'] . '" value="Modifier" class="form-control btn-success">';
    $contenu .= '<form>';
}
//--------------------------AFFICHAGE------------
require_once 'inc/haut.inc.php';
?>
    
    <div class="container mt-4" style="min-width: 180vh">
        <div class="jumbotron mt-4">
                <h1 class="text-center mt-4 mb-4">Gestion de votre  CV</h1>
                <?php echo '<h4 class="text-center mt-4 mb-4">' . $prenom . ' - ' . $nom . '</h4>'; ?>
                <h2 class="text-center"> Vous êtes un administrateur !</h2>
        </div>
    
        <div class="row d-flex justify-content-center">
            <h2 class="text-center m-5">La mise à jour d'une competen</h2>
            <div class="col-lg-6 m-3">
            
                <?php echo $contenu; ?>
            </div>
        </div>
    
    
    </div>
    
    <?php
    //le bas de page
    require_once 'inc/bas.inc.php';
