<?php
require_once 'inc/init.inc.php';

//pour le tri des colonnes par ordre croissant et decroissant
$ordre = ''; // on declare la variable 

if (isset($_GET['ordre']) && isset($_GET['colonne'])) {

    if ($_GET['colonne'] == 'formations') {
      $ordre = ' ORDER BY formation'; 
  
    } 
    elseif ($_GET['colonne'] == 'dates_form') {
      $ordre = ' ORDER BY dates_form';
  
    } 
    
    if ($_GET['ordre'] == 'asc') {
      $ordre .= ' ASC';
    } elseif ($_GET['ordre'] == 'desc') {
      $ordre .= ' DESC';
    }
  }
extract($_SESSION['t_utilisateurs']);

/**************************************************************** */


// 4- Traitement de $_POST : enregistrement de la formation en BDD 
//debug($_POST);

if(!empty($_POST)) {
    // Insertion d'une formation en BDD :
        executeRequete(" REPLACE INTO t_formations VALUES (NULL, :formation, :stitre_form, :dates_form, :description_form, $id_utilisateur)",
            array(
                ':formation' => $_POST['formation'],
                ':stitre_form' => $_POST['stitre_form'],
                ':dates_form' => $_POST['dates_form'],
                ':description_form' => $_POST['description_form']
            )
        );
        //REPLACE INTO se comporte comme un INSERT INTO quand l'id_formation n'existe pas en BDD : c'est le cas lors de la création d'une formation pour laquelle nous avons mis un id_formation à 0 par défaut dans le formulaire. REPLACE INTO se comporte comme un UPDATE quand l'id_formation existe en BDD : c'est le cas lors de la modification d'une formation existante.
    
        $contenu .= '<div class="bg-success">La formation a bien été enregistrée ! </div>';
    
    }// fin du if (!empty($_POST))

//suppression d'un élément de la BDD
if (isset($_GET['id_formation'])) {// on récupère ce que je supprime dans l'url par son id
    $efface = $_GET['id_formation'];// je passe l'id dans une variable $efface

    $resultat = $pdo->query(" DELETE FROM t_formations WHERE id_formation = '$efface' ");

     header("location: ../back/formations.php");

     $contenu .= '<div class="alert alert-success" role="alert">La formation à bien été supprimée !</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la suppression !</div>';

}//ferme le if isset pour la suppression



//-----------------------------------------AFFICHAGE-------------------------------------------
require_once 'inc/haut.inc.php';
?>

<div class="container margin">
<div class="row">
            <div class="col-xm-6 col-md-8 col-lg-12 mb-3">
                <h2 class="text-center text-dark">Mise à jour d'une formation</h2>
            </div>
        </div>
    <div class="row">  
        <div class="col-sm-12 col-md-8 col-lg-8 mb-5">
            <?php 
            //requête pour compter et chercher plusieurs enregistrements, on ne peut compter que si on a un prepare

            $sql = $pdo->prepare("SELECT * FROM t_formations WHERE id_utilisateur = 1 $ordre ");
            $sql->execute();
            $nbr_formations = $sql->rowCount();
            ?>

            <div class="table-responsive color">
                <div class="card-header">
                    La liste des formations : <?php echo $nbr_formations;?>
                </div>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                        
                        <th>Formation</th><a href="formations.php?colonne=formations&ordre=asc"><i class="fas fa-sort-alpha-down"></i></a> | <a href="formations.php?colonne=formations&ordre=desc"><i class="fas fa-sort-alpha-up"></i></a></th>
                        <th>Sous-titres</th>
                        <th>Dates</th>
                        <th>Description</th>
                        <th>Modifier </th>
                        <th>Supprimer </th>
                        </tr>
                    </thead>
                    <tbody class="thead-light">
                    <?php while ($ligne_formation=$sql ->fetch()) 
                    {
                        echo '<tr>';
                            echo '<td>' . $ligne_formation['formation'] . '</td>';
                            echo '<td>' . $ligne_formation['stitre_form'] . '</td>';
                            echo '<td>' . $ligne_formation['dates_form'] . '</td>';
                            echo '<td>' . $ligne_formation['description_form'] . '</td>';
                            echo '<td> <a href="modif_formation.php?id_formation=' . $ligne_formation['id_formation'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir modifier cette formation?\'))"><i class="fas fa-edit"></i></a></td>';

                            echo '<td> <a href="?id_formation=' . $ligne_formation['id_formation'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer cette formation?\'))" ><i class="far fa-trash-alt"></i></a></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- fin .table-resposive -->
        </div><!-- fin .col-lg-8 -->

        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card text-white color mb-3">
                <div class="card-header">
                    Insertion d'une nouvelle formation :
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="id_formation" valeur="0">   
                        
                        <div class="form-group">
                            <label for="dates_form">Dates</label>
                            <input class="form-control" type="text" name="dates_form" id="dates_form" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="formation">Titre</label>
                            <input class="form-control" type="text" name="formation" id="formation" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="stitre_form">Sous-titres</label>
                            <input class="form-control" type="text" name="stitre_form" id="stitre_form" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label for="description_form">Description</label>
                            <input class="form-control" type="text" name="description_form" id="description_form" placeholder="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> formation</button>
                        </div>
                    </form>
                </div><!-- fin div .card-body -->
            </div><!-- fin div .card -->
        </div><!-- fin div .col-sm-12 col-md-4 col-lg-4 -->
        
    </div><!-- fin .row -->
            
</div><!-- fin .container-->

<?php
require_once 'inc/bas.inc.php';