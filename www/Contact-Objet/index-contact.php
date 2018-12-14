<?php
// on récupère la classe Contact
require('Contact.class.php');

// on vérifie l'envoi du formulaire
if (!empty($_POST)){
     // avec extract() on accède directement aux champs par leurs noms en variable
     //var_dump($_POST);
     extract($_POST);

     // on valide les données 
          // 1- champs renseignés et email valide
           /*  /!\ Effectuer toutes les validations de formulaire ici => strlen($nom) > 5 || strlen($nom) < 100 ....*/
     $valid = (empty($nom) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($sujet) || empty($message)) ? false : true;

          // 2- validation des champs avec un message d'erreur si besoin
     $erreurnom = (empty($nom)) ? 'Indiquez votre nom svp !' : null;
     $erreuremail = (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) ? 'Entrez un mail valide, merci.' : null;
     $erreursujet = (empty($sujet)) ? 'Indiquez l\'objet de votre mail.' : null;
     $erreurmessage = (empty($message)) ? 'Ecrivez votre message.' : null;

     // si le formulaire est validé
     if($valid) {
          // on instancie un objet de la classe Contact
          $contact = new Contact;

          // on réalise l'insertion en BDD avec la méthode insertContact()
          $contact->insertContact($nom, $email, $sujet, $message);

          // on appelle la méthode sendEmail()
          $contact->sendEmail($nom, $email, $sujet, $message); // ne fonctionne pas sur localhost sans un paramétrage spécial

          // on efface les valeurs du formulaire (évite un envoi multiple)
          unset($nom);
          unset($sujet);
          unset($email);
          unset($message);
          unset($contact);

          // on créé une variable d'affichage de succès de l'envoi du formulaire
         
          $success = '<div class="container">
          <div class="row">
              <div class="col-6 bg-success">
              Le message bien envoyé !
              </div>
              <div class="col-6">
                  <a href="../index.php" class="btn btn-block btn-outline-primary"><i class="fas fa-ban"></i>&nbsp;Revenir à la page d\'acceuil...</a>
              </div>
          </div>   
      </div>';
     }

}


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!--responsive viewport meta tag-->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Formulaire de contact</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="style-contact.css"/>
    </head>

    <body>

        <div id="content" class="container mx-auto mb-5">
            <div class="card">
                <div class="card-body">
                    <h3>Formulaire de contact</h3>
                    <h5>Réalisé en POO</h5>

                    <!-- BONUS EMAIL -->
                         <?php if (isset($success)): ?>
                              <div class="alert alert-success" role="alert"><?= $success; ?> </div>
                         <?php endif ?>
                    <!-- FIN BONUS EMAIL -->

                    <form action="index-contact.php" method="POST">
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <span class="error"><?php if (isset($erreurnom)) echo $erreurnom; ?></span>
                            <input class="form-control" type="text" name="nom" value="<?php if (isset($nom)) echo $nom; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <span class="error"><?php if (isset($erreuremail)) echo $erreuremail; ?></span>
                            <input class="form-control" type="text" name="email" value="<?php if (isset($email)) echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sujet">Sujet :</label>
                            <span class="error"><?php if (isset($erreursujet)) echo $erreursujet; ?></span>
                            <input class="form-control" type="text" name="sujet" value="<?php if (isset($sujet)) echo $sujet; ?>">
                        </div>
                        <div class="form-group">
                            <label for="message">Message :</label>
                            <span class="error"><?php if (isset($erreurmessage)) echo $erreurmessage; ?></span>
                            <textarea class="form-control" name="message" cols="30" rows="10"><?php if (isset($message)) echo $message; ?></textarea>
                        </div>

                        <input type="submit" class="submit btn btn-block btn-outline-info" value="Envoyer" />

                    </form>
                </div>
            </div>
            <hr>
        </div><!-- /.container -->

        <!-- JS for Bootstrap -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>