<?php
require_once 'inc/init.inc.php';

//pour le tri des colonnes par ordre croissant et decroissant
$ordre = ''; // on declare la variable 

if (isset($_GET['ordre']) && isset($_GET['colonne'])) {

    if ($_GET['colonne'] == 'loisirs') {
        $ordre = ' ORDER BY loisir';
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

    // ICI le code de la photo à venir
     $photo_bdd ='';  // par défaut la photo est vide en BDD

    // debug($_FILES);

     if (!empty($_FILES['photo']['name'])) {  // s'il y a un nom de fichier dans la superglobale $_FILES, c"est que je suis en tyrain d'uploader un fichier. L'indice "photo" correspond au name du champ dans le formulaire.
        $nom_photo = $_FILES['photo']['name'];  

       $photo_bdd = $nom_photo;  // chemin relatif de la photo enregistré dans la BDD correspondant au fichier physique uploadé dans le dossier/photo/ du site

       copy($_FILES['photo']['tmp_name'], 'img/' . $photo_bdd);  // on enregistre le fichier photo qui est tomporairement dans $_FILES['photo']['tmp_name'] dans le répertoire "img/nom_photo.jpg"

    }

    // Insertion d'un loisir en BDD :
    executeRequete(" REPLACE INTO t_loisirs VALUES (NULL, :photo, :loisir,  $id_utilisateur)",
        array(
            ':photo' => $photo_bdd,
            ':loisir' => $_POST['loisir']
        )
    );
    //REPLACE INTO se comporte comme un INSERT INTO quand l'id_loisir n'existe pas en BDD : c'est le cas lors de la création d'un loisir pour laquelle nous avons mis un id_loisir à 0 par défaut dans le formulaire. REPLACE INTO se comporte comme un UPDATE quand l'id_loisir existe en BDD : c'est le cas lors de la modification d'une loisir existante.

    $contenu .= '<div class="bg-success">Le loisir a bien été enregistrée ! </div>';

}// fin du if (!empty($_POST))



//suppression d'un élément de la BDD
if (isset($_GET['id_loisir'])) {// on récupère ce que je supprime dans l'url par son id
    $efface = $_GET['id_loisir'];// je passe l'id dans une variable $efface

    $resultat = $pdo->query(" DELETE FROM t_loisirs WHERE id_loisir = '$efface' ");

    header("location:../back/loisirs.php");

    $contenu .= '<div class="alert alert-success" role="alert">Le loisir à bien été supprimé</div>';
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
                <h2 class="text-center text-dark">Mise à jour d'un loisir</h2>
            </div>
        </div>
    <div class="row">  
        <div class="col-sm-12 col-md-8 col-lg-8 mb-5">
            <?php 
                //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
            $sql = $pdo->prepare(" SELECT * FROM t_loisirs WHERE id_utilisateur = 1 $ordre ");
            $sql->execute();
            $nbr_loisirs = $sql->rowCount();
            ?>

            <div class="table-responsive color">
                <div class="card-header">
                    La liste des loisirs : <?php echo $nbr_loisirs; ?>
                </div>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Photo</th>
                            <th>Loisir  <a href="loisirs.php?colonne=loisirs&ordre=asc"><i class="fas fa-sort-alpha-down"></i></a> | <a href="loisirs.php?colonne=loisirs&ordre=desc"><i class="fas fa-sort-alpha-up"></i></a></th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="thead-light">
                    <?php while ($ligne_loisir = $sql->fetch()) 
                    {

                        echo '<tr>';
                        echo '<td>' . $ligne_loisir['loisir'] . '</td>';
                        echo '<td><img src="img/' . $ligne_loisir['photo'] . '" alt="" style="width:100px;height:100px;"></td>';
                        echo '<td> <a href="modif_loisir.php?id_loisir=' . $ligne_loisir['id_loisir'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir modifier ce loisir ?\'))"><i class="fas fa-edit"></i></a></td>';

                        echo '<td> <a href="?id_loisir=' . $ligne_loisir['id_loisir'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce loisir ?\'))" ><i class="far fa-trash-alt"></i></a></td>';
                        echo '</tr>';
                    }
                    ?>
                    
                    </tbody>
                </table>
            </div><!-- fin resposive -->
        </div><!-- fin .col-lg-8 -->

        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card text-dark color mb-3">
                <div class="card-header">
                    Insertion d'un nouveau loisir :
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_competence" valeur="0">
                        <div class="form-group files color">
                            <label for="photo">Télécharger votre photo</label>
                            <input type="file" name="photo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="loisir">Loisir</label>
                            <input type="text" name="loisir" class="form-control" placeholder="nouveau loisir" required>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> loisir</button>
                        </div>
                    </form>
                </div><!-- fin div .card-body -->
            </div><!-- fin div .card -->
        </div><!-- fin div .col-sm-12 col-md-4 col-lg-4 -->
        
    </div><!-- fin .row -->
            
</div><!-- fin .container-->

<?php
require_once 'inc/bas.inc.php';