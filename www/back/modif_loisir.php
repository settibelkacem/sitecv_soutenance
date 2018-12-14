<?php
require_once 'inc/init.inc.php';

extract($_SESSION['t_utilisateurs']);
//debug($_POST);
//-----------------mise à jour d'une experience ---------------
if (!empty($_POST)) {
   
    // // debug($_FILES);

    $result = executeRequete(
        " UPDATE t_loisirs SET loisir = :loisir, id_utilisateur = $id_utilisateur WHERE id_loisir = :id_loisir",
        array(
            ':id_loisir' => $_POST['id_loisir'],
            ':loisir' => $_POST['loisir']
        )
    );

    if ($result->rowCount() == 1) { // si j'ai une ligne_loisirs dans $result, j'ai modifié un loisir
        $contenu .= '<div class="alert alert-success" role="alert">le loisir à bien été modifier</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la modification</div>';
    }
}

//-----------------------
$id_loisir = $_GET['id_loisir'];

$result = $pdo->query(" SELECT * FROM t_loisirs WHERE id_loisir = '$id_loisir' ");

while ($ligne_loisirs = $result->fetch(PDO::FETCH_ASSOC)) {
    // debug($ligne_loisirs);
    $contenu .= '<form method="post" action="" enctype="multipart/form-data">';

        foreach ($ligne_loisirs as $indice => $valeur) {
            $contenu .= '<div class="form-group">';

            if ($indice == 'id_loisir' || $indice == 'id_utilisateur') {
                $contenu .= '<input type="hidden" name="' . $indice . '" id="' . $indice . '" value="' . $valeur . '">';
            }
            elseif($indice == 'photo') {
                // $contenu .= '<div class="files color"><input type="file" class="form-control" name="' . $indice . '" id="'. $indice . '" value="'. $valeur . '"> <img src="img/' . $valeur . '" width="90" alt=""></div>';
                $contenu .= '<img src="img/' . $valeur . '" width="90" alt="">';
            } 
            else {
                $contenu .= '<label for="' . $indice . '">&nbsp;&nbsp;' . $indice . '</label>';
                $contenu .= '<input class="form-control"  id="' . $indice . '" value="' . $valeur . '" name="' . $indice . '">';
            }

            $contenu .= '</div>';

        }//fin foreach($ligne_loisirs as $indice => $valeur)


        $contenu .= '<div class="container">
            <div class="row">
                <div class="col-6">
                    <input type="submit" id="' . $ligne_loisirs['id_loisir'] . '" value="Modifier" class="btn btn-block btn-outline-warning">
                </div>
                <div class="col-6">
                    <a href="loisirs.php" class="btn btn-block btn-outline-primary"><i class="fas fa-ban"></i>&nbsp;Revenir aux loisirs</a></div>
                </div>
            </div>   
        </div>';
    $contenu .= '<form>';


}// fin while($ligne_loisirs = $resultat->fetch(PDO::FETCH_ASSOC))

//--------------------------AFFICHAGE------------
require_once 'inc/haut.inc.php';
?>
    
    <div class="container text-center mt-4 mb-5 pt-5" style="min-width: 180vh">

        <div class="container text-center mb-5">
        <h2 class="text-dark margin pb-3">La mise à jour d'un loisir</h2>
            <div class="row d-flex justify-content-center">
                
                <div class="col-lg-6 m-auto bg-info pb-4">
                
                    <?php echo $contenu; ?>
                </div><!-- fin div .col-lg-8 m-3 -->
            </div><!-- fin div .row d-flex justify-content-center -->
        </div><!-- fin div .container text-center mb-5 -->

    
    </div>
    
    <?php
    //le bas de page
    require_once 'inc/bas.inc.php';
