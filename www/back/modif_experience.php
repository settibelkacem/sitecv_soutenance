<?php
require_once 'inc/init.inc.php';

extract($_SESSION['t_utilisateurs']);

//-----------------mise à jour d'une experience ---------------
if (!empty($_POST)) {

    $result = executeRequete(
        " UPDATE t_experiences SET titre_exp = :titre_exp, stitre_exp = :stitre_exp, dates_exp = :dates_exp, description_exp = :description_exp, id_utilisateur = $id_utilisateur WHERE id_experience = :id_experience",
        array(
            ':id_experience' => $_POST['id_experience'],
            ':titre_exp' => $_POST['titre_exp'],
            ':stitre_exp' => $_POST['stitre_exp'],
            ':dates_exp' => $_POST['dates_exp'],
            ':description_exp' => $_POST['description_exp']
           
        )
    );

    if ($result->rowCount() == 1) { // si j'ai une ligne dans $result, j'ai modifié une experience
        $contenu .= '<div class="alert alert-success" role="alert">l\'experience à bien été modifier</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la modification</div>';
    }
}

//-----------------------
$id_experience = $_GET['id_experience'];

$resultat = $pdo->query(" SELECT * FROM t_experiences WHERE id_experience = '$id_experience' ");

while ($ligne_exp = $resultat->fetch(PDO::FETCH_ASSOC)) {
    
    $contenu .= '<form method="post" action="">';
        // debug($ligne);

        foreach ($ligne_exp as $indice => $valeur) {
            $contenu .= '<div class="form-group">';

                if ($indice == 'id_experience' || $indice == 'id_utilisateur') {
                    $contenu .= '<input type="hidden" name="' . $indice . '" id="' . $indice . '" value="' . $valeur . '">';

                } 
                elseif ($indice == 'description') {
                    $contenu .= '<label for="' . $indice . '">&nbsp;' . $indice . '</label>';
                    $contenu .= '<textarea name="' . $indice . '" id="' . $indice . '" class="form-control" cols="30" rows="10"></textarea>';   
                }
                else {
                    $contenu .= '<label for="' . $indice . '">&nbsp;' . $indice . '</label>';
                    $contenu .= '<input class="form-control"  id="' . $indice . '" value="' . $valeur . '" name="' . $indice . '">';
                }
            $contenu .= '</div>';/* fin div .form-group */

        } // fin foreach ($ligne_exp as $indice => $valeur) {

        // $contenu .= '<input type ="submit" id="' . $ligne_exp['id_experience'] . '" value="Modifier" class="form-control btn-success">';
            $contenu .= '<div class="container">
                <div class="row">
                    <div class="col-6">
                        <input type="submit" id="' . $ligne_exp['id_experience'] . '" value="Modifier" class="btn btn-block btn-outline-warning">
                    </div>
                    <div class="col-6">
                        <a href="experiences.php" class="btn btn-block btn-outline-primary"><i class="fas fa-ban"></i>&nbsp;Revenir aux experiences</a>
                    </div>
                </div>   
            </div>';

    $contenu .= '<form>';
   
} //fin while ($ligne_exp = $resultat->fetch(PDO::FETCH_ASSOC))
//--------------------------AFFICHAGE------------
require_once 'inc/haut.inc.php';
?>
    
    <div class="container text-center mt-4 mb-5 pt-5" style="min-width: 180vh">
       
        <h2 class="text-center text-dark margin pb-3">La mise à jour d'une experience</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 m-auto pb-4 bg-info">
                <?php echo $contenu; ?>
            </div>
        </div>
    
    </div>
    
    <?php
    
    require_once 'inc/bas.inc.php';//le bas de page
