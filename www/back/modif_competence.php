<?php
require_once 'inc/init.inc.php';

extract($_SESSION['t_utilisateurs']);

//-----------------mise à jour d'une experience ---------------
if (!empty($_POST)) {

    
    $result = executeRequete(" UPDATE t_competences SET competence = :competence, niveau = :niveau, categorie = :categorie, id_utilisateur = $id_utilisateur WHERE id_competence = :id_competence",
                                array(
                                        ':id_competence' => $_POST['id_competence'],    
                                        ':competence' => $_POST['competence'],    
                                        ':niveau' => $_POST['niveau'],
                                        ':categorie' => $_POST['categorie']
                                    ));


    if ($result -> rowCount() == 1) { // si j'ai une ligne dans $result, j'ai modifié une competence
    $contenu .= '<div class="alert alert-success" role="alert">la competence a bien été modifiée</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la modification</div>';
    }
}

//-----------------------
$id_competence = $_GET['id_competence'];

$resultat = $pdo->query(" SELECT * FROM t_competences WHERE id_competence = '$id_competence' ");

while($ligne_competences = $resultat->fetch(PDO::FETCH_ASSOC)) {
    
        // debug($ligne);
    
    $contenu .= '<form method="post" action="" enctype="multipart/form-data">';
        
        foreach($ligne_competences as $indice => $valeur){ 
            $contenu .= '<div class="form-group">';

                if ($indice == 'id_competence' || $indice =='id_utilisateur'){    
                    $contenu .= '<input type="hidden" class="form-control" name="'. $indice .'" id="'. $indice .'" value="' . $valeur . '">'; 
                }
                elseif($indice == 'icon') {

                    $contenu .= '<img src="img/' . $valeur . '" width="90" alt="">';

                } 
                elseif($indice == 'categorie')  {

                    $contenu .= '<label for="'.$indice.'">Categories :</label>';
                    $contenu .= '<select type="text" class="form-control" name="'.$indice.'"  value ="'.$indice.'">';
                        $contenu .= '<option value="'.$valeur.'">'.$valeur.'</option>';
                        $contenu .= '<option value="Back">Back</option>';
                        $contenu .= '<option value="CMS">CMS</option>';
                        $contenu .= '<option value="Frameworks">Frameworks</option>';
                        $contenu .= '<option value="Front">Front</option>';
                    $contenu .= '</select>';

                }
                else{

                    $contenu .='<label for="'.$indice.'">&nbsp;&nbsp;'.$indice.'</label>';
                    $contenu .= '<input class="form-control"  id="'. $indice .'" value="' . $valeur . '" name="'. $indice .'">';

                }
            $contenu .='</div>';
        
        }   //fin foreach($ligne_competences as $indice => $valeur)
        
            $contenu .= '<div class="container">
                <div class="row">
                    <div class="col-6">
                        <input type="submit" id="' . $ligne_competences['id_competence'] . '" value="Modifier" class="btn btn-block btn-outline-warning">
                    </div>
                    <div class="col-6">
                        <a href="competences.php" class="btn btn-block btn-outline-primary"><i class="fas fa-ban"></i>&nbsp;Revenir aux competences</a>
                    </div>
                </div>   
            </div>';
       
    $contenu .='</form>';
     
        
}// fin while($ligne_competences = $resultat->fetch(PDO::FETCH_ASSOC))
//--------------------------AFFICHAGE------------
    require_once 'inc/haut.inc.php';
    ?>
    
    <div class="container text-center mt-4 mb-5 pt-5" style="min-width: 180vh">

        <h2 class="text-dark margin pb-3">La mise à jour d'une competence :</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 m-auto bg-info pb-4">
                <?php echo  $contenu ;?>
            </div>
        </div>
    </div>
    
    <?php
    
    require_once 'inc/bas.inc.php';//le bas de page
