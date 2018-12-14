<?php
require_once 'inc/init.inc.php';

//pour le tri des colonnes par ordre croissant et decroissant
$ordre = ''; // on declare la variable 

if (isset($_GET['ordre']) && isset($_GET['colonne'])) {

    if ($_GET['colonne'] == 'titre_exp') {
        $ordre = ' ORDER BY titre_exp';
    } elseif ($_GET['colonne'] == 'stitre_exp') {
        $order = ' ORDER BY stitre_exp';
    } elseif ($_GET['colonne'] == 'dates_exp') {
        $order = ' ORDER BY dates_exp';
    } elseif ($_GET['colonne'] == 'description_exp') {
        $order = ' ORDER BY descrition_exp';
    }

    if ($_GET['ordre'] == 'asc') {
        $ordre .= ' ASC';
    } elseif ($_GET['ordre'] == 'desc') {
        $ordre .= ' DESC';
    }
}

extract($_SESSION['t_utilisateurs']);

/**************************************************************** */


// 4- Traitement de $_POST : enregistrement de la competence en BDD 
//debug($_POST);

if (!empty($_POST)) {
    // Insertion de la competence en BDD :
    executeRequete(
        " REPLACE INTO t_experiences VALUES (NULL, :dates_exp, :titre_exp, :stitre_exp, :description_exp, $id_utilisateur)",
        array(
            ':dates_exp' => $_POST['dates_exp'],
            ':titre_exp' => $_POST['titre_exp'],
            ':stitre_exp' => $_POST['stitre_exp'],
            ':description_exp' => $_POST['description_exp']
        )
    );
    //REPLACE INTO se comporte comme un INSERT INTO quand l'id_experience n'existe pas en BDD : c'est le cas lors de la création d'une experience pour laquelle nous avons mis un id_experience à 0 par défaut dans le formulaire. REPLACE INTO se comporte comme un UPDATE quand l'id_experience existe en BDD : c'est le cas lors de la modification d'une experience existante.

    $contenu .= '<div class="bg-success">L\'experience a bien été enregistrée ! </div>';

}// fin du if (!empty($_POST))

//suppression d'un élément de la BDD
if (isset($_GET['id_experience'])) {// on récupère ce que je supprime dans l'url par son id
    $efface = $_GET['id_experience'];// je passe l'id dans une variable $efface

    $resultat = $pdo->query(" DELETE FROM t_experiences WHERE id_experience = '$efface' ");

    header("location: ../back/experiences.php");

    $contenu .= '<div class="alert alert-success" role="alert">L\'expaerience à bien été supprimé</div>';
} else {
    $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la suppression</div>';

}//ferme le if isset pour la suppression



//-----------------------------------------AFFICHAGE--------------------------------------------
require_once 'inc/haut.inc.php';

//echo $contenu;
?>

<div class="container margin">
    <div class="row">
        <div class="col-xm-6 col-md-8 col-lg-12 mb-3">
            <h2 class="text-center text-dark">Mise à jour d'une experience</h2>
        </div>
    </div>
    <div class="row">  
        <div class="col-sm-12 col-md-8 col-lg-8 mb-5">
            <?php 
                //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
            $sql = $pdo->prepare(" SELECT * FROM t_experiences WHERE id_utilisateur = 1 $ordre ");
            $sql->execute();
            $nbr_experiences = $sql->rowCount();
            ?>

            <div class="table-responsive color">
                <div class="card-header">
                    La liste des experiences  : <?php echo $nbr_experiences; ?>
                </div>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date d'experience</th>
                            <th><a href="experiences.php?colonne=titre_exp&ordre=asc"> Titre de l'experience <i class="fas fa-sort-alpha-down"></i></a> | <a href="experiences.php?colonne=titre_exp&ordre=desc"><i class="fas fa-sort-alpha-up"></i></a></th>
                            <th>Sous titre</th>
                            <th>Description</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="thead-light">
                    <?php while ($ligne_experience = $sql->fetch()) 
                    {

                        echo '<tr>';
                        echo '<td>' . $ligne_experience['dates_exp'] . '</td>';
                        echo '<td>' . $ligne_experience['titre_exp'] . '</td>';
                        echo '<td>' . $ligne_experience['stitre_exp'] . '</td>';
                        echo '<td>' . $ligne_experience['description_exp'] . '</td>';
                        echo '<td> <a href="modif_experience.php?id_experience=' . $ligne_experience['id_experience'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir modifier cette experience ?\'))"><i class="fas fa-edit"></i></a></td>';

                        echo '<td> <a href="?id_experience=' . $ligne_experience['id_experience'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer cette experience ?\'))" ><i class="far fa-trash-alt"></i></a></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- fin .table-resposive -->
        </div><!-- fin .col-lg-8 -->

        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card text-dark color mb-3">
                <div class="card-header">
                    Insertion d'une nouvelle experience :
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="dates_exp">Dates</label>
                            <input type="text" name="dates_exp" class="form-control" placeholder="La date de l'experience" required>
                        </div>
                        <div class="form-group">
                            <label for="titre_exp">Titre</label>
                            <input type="text" name="titre_exp" class="form-control" placeholder="nouvelle experience" required>
                        </div>
                        <div class="form-group">
                            <label for="stitre_exp">Sous titre</label>
                            <input type="text" name="stitre_exp" class="form-control" placeholder="Le sous titre de l'experience" required>
                        </div>
                        <div class="form-group">
                            <label for="description_exp">Description</label>
                            <textarea name="description_exp" id="description_exp" class="form-control" cols="30" rows="10">Description d'experience</textarea>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> experience</button>
                        </div>
                    </form>
                </div><!-- fin div .card-body -->
            </div><!-- fin div .card -->
        </div><!-- fin div .col-sm-12 col-md-4 col-lg-4 -->
        
    </div><!-- fin .row -->
            
</div><!-- fin .container-->

<?php
require_once 'inc/bas.inc.php';