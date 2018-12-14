<?php require_once 'inc/init.inc.php';

// 2 - Déconnexion de l'internaute :

if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {  // si l'internaute a cliqué sur "se déconnecter"
    session_destroy();  // on supprime toute la session du l'utilisateur.
                        // Rappel : cette instruction ne s'exécute qu'en fin de script
}


// 3 -  On vérifie si l'internaute est déjà connecté :

if (internauteEstConnecte()) {  // s'il est connecté, on le renvoie vers son index :
        header('location:index.php');
        exit();  // pour quitter le script
    }

// debug($_POST);

// 1- traitement du formulaire :
    if (!empty($_POST)) {  // si le formulaire est soumis 
        // Validation des champs du formulaire :
    if (!isset($_POST['email']) || empty($_POST['email'])) $contenu .= '<div class="text-danger">Entrez un email valide !</div>';
    if (!isset($_POST['mdp']) || empty($_POST['mdp'])) $contenu .= '<div class="text-danger">Veuillez entrer votre mot de passe !</div>';
    if (empty($contenu)) {  // s'il n'a pas d'erreur sur le formulaire

        // Vérification du pseudo :

            $t_utilisateurs = executeRequete("SELECT * FROM t_utilisateurs WHERE email = :email AND mdp = :mdp", array(':email' => $_POST['email'], ':mdp' => $_POST['mdp']));  // on sélectionne en base les éventuels membres dont le pseudo correspond au pseudo donné par l'internaute lors de l'inscription

    if ($t_utilisateurs->rowCount() > 0) {  // si le nombre de ligne est supérieur à 0, alors le login et le mot de passe existent ensemble en BDD
            // on crée une session avec les informations du membre :

            $informations = $t_utilisateurs->fetch(PDO::FETCH_ASSOC);  // on fait un fetch pour transformer l'objet $membre en un array associatif qui contient en indices le nom de tous les champs de la requête

            debug($informations);

            $_SESSION['t_utilisateurs'] = $informations;  // nous créons une session avec les infos du membre qui proviennent de la BDD​
            header('location:index.php');
            exit();  // on redirige l'internaute vers sa page de index, et on quitte ce script avec la fonction exit()

        } else {
            // sinon c'est qu'il y a une erreur sur les identifiants (ils n'existent pas ou pas pour le même membre)
            $contenu.= '<div class="text-danger">Identifiants incorrects</div>';
        }
    }  // fin du if (empty($contenu))
}  // fin du if (!empty($_POST))

//------------------------------ AFFICHAGE -----------------------
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        

        <!-- My CSS style -->
        <link rel="stylesheet" href="css/styleAdmin.css">
    </head>

    <body>
        <section class="login-block">
            <div class="container connex">
                <div class="row">
                    <div class="col-md-4 login-sec">
                        <h2 class="text-center">Connexion</h2>
                        <form class="login-form" method="post" action="connexion.php">
                            <div class="form-group">
                                <label for="email" class="text-uppercase" value="<?php if (isset($email)) echo $email; ?>"></i></label>
                                <!-- value=""><i class="fa fa-envelope icon" -->
                                <input type="text" class="form-control" placeholder="Votre Email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="mdp" class="text-uppercase"><i class="fa fa-key icon"></i></label>
                                <input type="password" class="form-control" placeholder="Mot de passe"  name="mdp" id="mdp" required>
                                <div id="voirMdp" style="cursor: pointer" class="text-right"><i class="far fa-eye text-primary"></i></div>
                            </div>
                            <div class="form-check">
                                <button type="submit" class="btn btn-login float-right">Connexion</button>
                            </div> 
        
                        </form>
                        <div class="copy-text">
                        <p><a href="http://settibelkacem.com">settibelkacem.com</a></p>
                        <!-- La marque -->
                        <a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php' ?>"><i class="fas fa-home text-dark"></i></a>
                    </div>
                    </div>
                    <div class="col-md-8 banner-sec">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <img class="d-block img-fluid" src="img/connex1.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="banner-text">
                                            <h2>Bonjour Setti !</h2>
                                            <p><i class="fas fa-briefcase"></i>&nbsp;&nbsp; Bien venue dans votre Admin !</p>
                                        </div>	
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="img/connex2.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="banner-text">
                                            
                                        </div>	
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="img/connex3.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="banner-text">
                                            
                                        </div>
                                    </div><!-- fin div .row -->	
                                </div><!-- fin div .row -->
                            </div><!-- fin div .carousel-inner-->
                        </div><!-- fin div #carouselExampleIndicators -->	   
                
                    </div><!-- fin div .banner-sec -->
                </div><!-- fin div .row -->
            </div><!-- fin div .container -->
        </section>
        
        <script>
            $(function(){
                $('#voirMdp').mousedown(function(){  // au click sur la souris, #voirmdp la fonction #mdp va redevenir de type text
                        $('#mdp').attr('type', 'text');
                    });

                    $('#voirMdp').mouseup(function(){  // en levant le doigt de #voirmdp la fonction #mdp va redevenir de type password "hidden"
                        $('#mdp').attr('type', 'password');
                    });
            });
        </script>


        
    <?php include 'inc/bas.inc.php'; ?>


    
    
    

    

    


    









    



