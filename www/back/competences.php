<?php
require_once 'inc/init.inc.php';

//pour le tri des colonnes par ordre croissant et decroissant
$ordre = ''; // on declare la variable 

if (isset($_GET['ordre']) && isset($_GET['colonne'])) {

    if ($_GET['colonne'] == 'competences') {
        $ordre = ' ORDER BY competence';
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
    // ICI le code de la icon à venir
     $icon_bdd ='';  // par défaut la icon est vide en BDD

    // debug($_FILES);

     if (!empty($_FILES['icon']['name'])) {  // s'il y a un nom de fichier dans la superglobale $_FILES, c"est que je suis en tyrain d'uploader un fichier. L'indice "icon" correspond au name du champ dans le formulaire.
        $nom_icon = $_FILES['icon']['name'];  

       $icon_bdd = $nom_icon;  // chemin relatif de la icon enregistré dans la BDD correspondant au fichier physique uploadé dans le dossier/icon/ du site

       copy($_FILES['icon']['tmp_name'], 'img/' . $icon_bdd);  // on enregistre le fichier icon qui est tomporairement dans $_FILES['icon']['tmp_name'] dans le répertoire "img/nom_icon.jpg"
    }

    // Insertion d'un loisir en BDD :
    executeRequete(" REPLACE INTO t_competences VALUES (NULL, :icon, :competence, :niveau, :categorie, $id_utilisateur)",
    array(
        ':icon' => $icon_bdd,
        ':competence' => $_POST['competence'],
        ':niveau' => $_POST['niveau'],
        ':categorie' => $_POST['categorie']
        )
    );
    //REPLACE INTO se comporte comme un INSERT INTO quand l'id_formation n'existe pas en BDD : c'est le cas lors de la création d'une competence pour laquelle nous avons mis un id_competence à 0 par défaut dans le formulaire. REPLACE INTO se comporte comme un UPDATE quand l'id_competence existe en BDD : c'est le cas lors de la modification d'une competence existante.
    $contenu .= '<div class="bg-success">La compétence a bien été enregistrée ! </div>';

}// fin du if (!empty($_POST))



//suppression d'un élément de la BDD
if (isset($_GET['id_competence'])) {// on récupère ce que je supprime dans l'url par son id
    $efface = $_GET['id_competence'];// je passe l'id dans une variable $efface

    $resultat = $pdo->query(" DELETE FROM t_competences WHERE id_competence = '$efface' ");

     header("location:../back/competences.php");

    $contenu .= '<div class="alert alert-success" role="alert">La competence à bien été supprimée !</div>';
} else {
    $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la suppression !</div>';

}//ferme le if isset pour la suppression



//-----------------------------------------AFFICHAGE--------------------------------------------
require_once 'inc/haut.inc.php';

//echo $contenu;
?>

<div class="container margin">
    <div class="row">
        <div class="col-xm-6 col-md-8 col-lg-12 mb-3">
            <h2 class="text-center text-dark">Mise à jour d'une compétence</h2>
        </div>
    </div>
    <div class="row">  
        <div class="col-sm-12 col-md-8 col-lg-8 mb-5">
            <?php 
                //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
            $sql = $pdo->prepare(" SELECT * FROM t_competences WHERE id_utilisateur = 1 $ordre ");
            $sql->execute();
            $nbr_competences = $sql->rowCount();
            ?>

            <div class="table-responsive color">
                <div class="card-header">
                    La liste des competences : <?php echo $nbr_competences; ?>
                </div>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>icon</th>
                            <th>Competences  <a href="competences.php?colonne=competences&ordre=asc"><i class="fas fa-sort-alpha-down"></i></a> | <a href="competences.php?colonne=competences&ordre=desc"><i class="fas fa-sort-alpha-up"></i></a></th>
                            <th>Niveau</th>
                            <th>Catégorie</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="thead-light">
                    <?php while ($ligne_competences = $sql->fetch()) {

                        echo '<tr>';

                        echo '<td><img src="img/' . $ligne_competences['icon'] . '" alt="" style="width:100px;height:100px;"></td>';

                        echo '<td>' . $ligne_competences['competence'] . '</td>';
                        echo '<td>' . $ligne_competences['niveau'] . '</td>';
                        echo '<td>' . $ligne_competences['categorie'] . '</td>';
                        echo '<td> <a href="modif_competence.php?id_competence=' . $ligne_competences['id_competence'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir modifier cette competence ?\'))"><i class="fas fa-edit"></i></a></td>';

                        echo '<td> <a href="?id_competence=' . $ligne_competences['id_competence'] . '" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer cette competence?\'))" ><i class="far fa-trash-alt"></i></a></td>';
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
                Insertion d'une nouvelle compétences :
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_competence" valeur="0">
                        <div class="form-group">
                            <label for="icon">Télécharger l'image</label>
                            <input type="file" name="icon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="competence">Compétence</label>
                            <input type="text" name="competence" class="form-control" placeholder="nouvelle compétence" required>
                        </div>
                        <div class="form-group">
                            <label for="niveau">Niveau</label>
                            <input type="text" name="niveau" class="form-control" placeholder="niveau en chiffre" required>
                        </div>
                        <div class="form-group">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" class="form-control">
                                <option value="Back">Back</option>
                                <option value="CMS">CMS</option>
                                <option value="Frameworks">Frameworks</option>
                                <option value="Front">Front</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- <button class="btn" type="submit"><i class="fas fa-plus"></i> compétence</button> -->
                            <input class="btn" type="submit" value=" Compétence">
                        </div>
                    </form>
                </div><!-- fin div .card-body -->
            </div><!-- fin div .card -->
        </div><!-- fin div .col-sm-12 col-md-4 col-lg-4 -->
        
    </div><!-- fin .row -->
            
</div><!-- fin .container-->

<?php
require_once 'inc/bas.inc.php';