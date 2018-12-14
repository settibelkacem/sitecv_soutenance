<?php require_once 'back/inc/init.inc.php';
  //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
  $sql = $pdo->prepare(" SELECT * FROM t_competences WHERE id_utilisateur = 1 ");
  $sql->execute(); 
  
  
  //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
  $sql = $pdo->query(" SELECT * FROM t_utilisateurs WHERE id_utilisateur =1 ");
  // $sql->execute(); 
  // $u=$sql->fetchAll();
  while($info = $sql->fetch(PDO::FETCH_ASSOC)){
     
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Setti Belkacem">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- cdn bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- cdn fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  

   
    <title>Site CVportfolio Setti Belkacem</title>
    <!-- CSS maison -->
    <link rel="stylesheet" href="back/css/style.css">
    <link rel="stylesheet" href="back/css/media.css">
    <link rel="stylesheet" href="back/css/animate.css">
   
    
   
  </head>

  <body id="page-top"> <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><?php echo $info['prenom']; ?>&nbsp;<?php echo $info['nom']; ?> <br><span>Créative et impliquée</span></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Apropos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#skills">Compétences</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#exp">Experiences</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#form">Formations</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#loisir">loisir</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="Contact-Objet/index-contact.php">Contact</a>
            </li>
          </ul>
        </div><!-- fin div #navbarResponsive -->
      </div><!-- fin div .container --> 
    </nav><!-- fin navigation -->

    <header class="masthead"><!-- Header -->
      <div class="container d-flex h-100 align-items-center">
        <div class="bg-image"></div>
        <div class="mx-auto text-center bg-text1">
          <h1 class="mx-auto my-0 text-uppercase "><?php echo $info['prenom']; ?>&nbsp;<?php echo $info['nom']; ?></h1>
          <h2 class="text-white-50 mx-auto mt-2 mb-5">Développeur Web Intégrateur Junior, à la recherche d'un stage.</h2>
          <p><a class="btn btn-primary btn-sm" href="back/doc/cvbelkacem.pdf" download="cvbelkacem.pdf"><i class="fa fa-file-pdf-o"></i> Télécharger mon CV</a></p>
        </div><!-- fin div .mx-auto text-center bg-text -->
      </div><!-- fin div .container d-flex h-100 align-items-center -->
    </header><!-- fin Header -->

    <section id="about" class="about-section text-center"><!-- Section #about-->
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-white mb-4">A propos de moi </h2>
            <p class="text-white"><?php echo $info['commentaire']; ?>
          </div><!-- fin div .col-lg-8 mx-auto-->
        </div><!-- fin div .row -->
        <img src="back/img/profil.jpg" class="img-fluid rounded-circle mb-5" width="250" heigth="250" alt="profil">
      </div><!-- fin div .container -->
    </section><!-- fin section #about-->
    
    <section id="skills" class="projects-section bg-skills"><!-- Section #skills-->
      <?php
      //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
      $sql = $pdo->prepare(" SELECT * FROM t_competences WHERE id_utilisateur = 1 ");
      $sql->execute();
      ?>
      <h1 class="text-center">Competences</h1>
	    <div class="container">
	      <div class="row">
          <?php
            while ($ligne_competence = $sql->fetch()) { 
                if ($ligne_competence['id_competence'] % 2 == 1) {
            ?>
              <!--team-1-->
            <?php   
            echo '<div class="col-lg-4">';
              echo '<div class="our-team-main">';  
                echo '<div class="team-front bg-info">';
                  echo '<img src="http://placehold.it/110x110/336699/fff?text=' . $ligne_competence['competence'] . ' " class="img-fluid" style="width:250;height:250"/>';
                  echo '<h3>' . $ligne_competence['categorie'] . '</h3>';
                  echo '<div class="progress-outer">';
                    echo '<div class="progress">';
                      echo '<div class="progress-bar progress-bar-info progress-bar-striped active" style="width:' . $ligne_competence['niveau'] . '; box-shadow:-1px 10px 10px rgba(91, 192, 222, 0.7);"></div>';/* fin div .progress-bar progress-bar-info progress-bar-striped active */
                      echo '<div class="progress-value">' . $ligne_competence['niveau'] . '</div>';/* fin div .progress-value*/
                    echo '</div>';/* fin div .progress */
                  echo '</div>';/* fin div .progress-outer */
                echo '</div><!-- fin div .team-front -->';
                echo '<div class="team-back">';
                  echo '<img src="back/img/' . $ligne_competence['icon'] . '" alt="' . $ligne_competence['competence'] . '" style="width:100%;max-width:100%;height:auto;" >';          
                echo '</div><!-- fin div .team-back -->';
              echo '</div><!-- fin div .our-team-main -->';
            echo '</div><!-- fin div .col-lg-4 -->';
          } /* fin if($ligne_competence['id_competence'] % 2 == 1) */
          else {
          ?><!--fin team-1-->

          <!--team-2-->
          <?php 
            echo '<div class="col-lg-4">';
              echo '<div class="our-team-main">';
                echo '<div class="team-front bg-warning">';
                  echo '<img src="http://placehold.it/110x110/9c27b0/fff?text=' . $ligne_competence['competence'] . ' " class="img-fluid" style="width:250;height:250"/>';
                  echo '<h3>' . $ligne_competence['categorie'] . '</h3>';
                  echo '<div class="progress-outer">';
                    echo '<div class="progress">';
                        echo '<div class="progress-bar progress-bar-success progress-bar-striped active" style="width:' . $ligne_competence['niveau'] . '; box-shadow:-1px 10px 10px rgba(116, 195, 116,0.7);"></div>';/* fin div .progress-bar progress-bar-success progress-bar-striped active */
                        echo '<div class="progress-value">' . $ligne_competence['niveau'] . '</div>';/* fin div .progress-value */
                    echo '</div>';/* fin div .progress-outer */
                  echo '</div>';/* fin div .progress-outer */
                echo '</div>'; /* fin div .team-front */
                echo '<div class="team-back">';
                  echo '<img src="back/img/' . $ligne_competence['icon'] . '" alt="' . $ligne_competence['competence'] . '" style="width:100%;max-width:100%;height:auto;">';
                echo '</div><!-- fin div .team-back -->';
              echo '</div><!-- fin div .our-team-main -->';
            echo '</div><!-- fin div .col-lg-4 -->';
              }
            }/* fin  while ($ligne_competence = $sql->fetch()) */
          ?><!--fin team-2-->
	      </div><!-- fin div .row -->
	    </div><!-- fin div .container -->
    </section> <!-- fin section #skills -->

    
    <?php
    //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
    $sql = $pdo->prepare(" SELECT * FROM t_experiences WHERE id_utilisateur =1 ");
    $sql->execute();
    ?>

    <div class="container-fluid">
	    <div class="row">
	      <div id="timeline">
		    	<div class="row timeline-movement timeline-movement-top">
            <div class="timeline-badge timeline-future-movement">
                <p id="margin_l">Experiences</p>
            </div>
          </div>
          
          <?php
          while ($ligne_experience = $sql->fetch()) 
          { 
            if ($ligne_experience['id_experience'] % 2 == 1) 
            {
          

			echo '<div class="row timeline-movement">';
				echo '<div class="timeline-badge center-left">';
				echo '</div>';
			  echo '<div class="col-sm-6  timeline-item">';
					echo '<div class="row">';
						echo '<div class="col-sm-11">';
							echo '<div class="timeline-panel credits  anim animate fadeInLeft">';
								echo '<ul class="timeline-panel-ul">';
										echo '<li><em class="importo">'.$ligne_experience['titre_exp'] .'</em></li>';
										echo '<li><span class="causale" style="color:#000; font-weight: 600;">'.$ligne_experience['stitre_exp'] .' </span> </li>';
										echo '<li><span class="causale">'.$ligne_experience['description_exp'] .'</span> </li>';
										echo '<li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> '.$ligne_experience['dates_exp'] .'</small></p> </li>';
									echo '<div class="clear"></div>';
								echo '</ul>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
        echo '</div>';
      ?>
      </div><!-- fin 1er div .row -->
      <?php
      } 
      else {
      
			echo '<div class="row timeline-movement">';
				echo '<div class="timeline-badge center-right">';
				echo '</div>';
				echo '<div class="offset-sm-6 col-sm-6  timeline-item">';
					echo '<div class="row">';
						echo '<div class="offset-sm-1 col-sm-11">';
							echo '<div class="timeline-panel debits  anim animate  fadeInRight">';
								echo '<ul class="timeline-panel-ul">';
										echo '<li><em class="importo">'.$ligne_experience['titre_exp'] .'</em></li>';
										echo '<li><span class="causale" style="color:#000; font-weight: 600;">'.$ligne_experience['stitre_exp'] .'</span> </li>';
										echo '<li><span class="causale">'.$ligne_experience['description_exp'] .' </span> </li>';
										echo '<li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> '.$ligne_experience['dates_exp'] .'</small></p> </li>';
									echo '<div class="clear"></div>';
								echo '</ul>';
							echo '</div>';

						echo '</div>';
					echo '</div>';
				echo '</div>';
      echo '</div>';
      
        } 
      } 
			?>
			
			<div class="row timeline-movement timeline-movement-top">
				<div class="timeline-badge timeline-future-movement">
						<p id="margin_l">Formations</p>
				</div>
			</div>
			
      <!-- 2 - formations -->
      <?php
      //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
      $sql = $pdo->prepare(" SELECT * FROM t_formations WHERE id_utilisateur =1 ");
      $sql->execute();
      
      while ($ligne_formation = $sql->fetch()) 
      { 
        if ($ligne_formation['id_formation'] % 2 == 1) 
        {

      

			echo '<div class="row timeline-movement">';
				echo '<div class="timeline-badge center-right">';
				echo '</div>';
				echo '<div class="offset-sm-6 col-sm-6  timeline-item">';
					echo '<div class="row">';
						echo '<div class="offset-sm-1 col-sm-11">';
							echo '<div class="timeline-panel debits  anim animate  fadeInRight">';
								echo '<ul class="timeline-panel-ul">';
										echo '<li><em class="importo">'.$ligne_formation['formation'] .'</em></li>';
										echo '<li><span class="causale" style="color:#000; font-weight: 600;">'.$ligne_formation['stitre_form'] .' </span> </li>';
										echo '<li><span class="causale">'.$ligne_formation['description_form'] .'</span> </li>';
										echo '<li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> '.$ligne_formation['dates_form'] .'</small></p> </li>';
									echo '<div class="clear"></div>';
								echo '</ul>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			
    } 
    else {
   
			echo '<div class="row timeline-movement">';
				echo '<div class="timeline-badge center-left">';	
				echo '</div>';
				echo '<div class="col-sm-6  timeline-item">';
					echo '<div class="row">';
						echo '<div class="col-sm-11">';
							echo '<div class="timeline-panel credits  anim animate  fadeInLeft">';
								echo '<ul class="timeline-panel-ul">';
										echo '<li><em class="importo">'.$ligne_formation['formation'] .'</em></li>';
										echo '<li><span class="causale" style="color:#000; font-weight: 600;">'.$ligne_formation['stitre_form'] .'</span> </li>';
										echo '<li><span class="causale">'.$ligne_formation['description_form'] .'</span> </li>';
										echo '<li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> '.$ligne_formation['dates_form'] .'</small></p> </li>';
									echo '<div class="clear"></div>';
								echo '</ul>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
      echo '</div>';
    } 
  } 
  ?>
		</div>
	</div>
</div>

   
   
    <section id="loisir" class="projects-section">  <!-- 3 - loisirs -->
      <div class="container bg-transparent">
        <?php
        //requête pour compter et chercher plusieurs enregistrements on ne peut compter que si on a un prépare
        $sql = $pdo->prepare(" SELECT * FROM t_loisirs WHERE id_utilisateur =1 ");
        $sql->execute(); 
        ?>
        <div id="hobby" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ul class="carousel-indicators mb-0 pb-0">
            <li data-target="#hobby" data-slide-to="0" class="active"></li>
            <li data-target="#hobby" data-slide-to="1"></li>
          </ul>
          <?php
          $ligne_loisir = $sql->fetchAll(); 
          ?>
          <!-- The slideshow -->
          <div class="carousel-inner no-padding my-5">
            <div class="carousel-item active">
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top" src="back/img/<?php echo $ligne_loisir[0]['photo']; ?>">
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[0]['loisir']; ?></p>
              </div><!-- fin div .col-xs-4 col-sm-4 col-md-4 -->
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top rounded-bottom" src="back/img/<?php echo $ligne_loisir[1]['photo']; ?>">
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[1]['loisir']; ?></p>
              </div><!--fin div .col-xs-4 col-sm-4 col-md-4 -->
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top rounded-bottom" src="back/img/<?php echo $ligne_loisir[2]['photo']; ?>">
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[2]['loisir']; ?></p>
              </div>
            </div><!-- fin div .carousel-item active -->     <!-- carousel-inner no-padding my-5 -->
            <div class="carousel-item">
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top" src="back/img/<?php echo $ligne_loisir[3]['photo']; ?>">
                  <!-- <div class="card-img-overlay t_img">
                    <span class="float-left text-uppercase">article</span>
                    <span class="float-right text-uppercase">2345 views</span>
                  </div> -->
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[3]['loisir']; ?></p>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top" src="back/img/<?php echo $ligne_loisir[4]['photo']; ?>">
                  <!-- <div class="card-img-overlay t_img">
                    <span class="float-left text-uppercase">article</span>
                    <span class="float-right text-uppercase">2345 views</span>
                  </div> -->
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[4]['loisir']; ?></p>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="#" onclick=abc(this) class="slider_info">
                  <img class="img-fluid card-img-top" src="back/img/<?php echo $ligne_loisir[5]['photo']; ?>">
                  <!-- <div class="card-img-overlay t_img">
                    <span class="float-left text-uppercase">article</span>
                    <span class="float-right text-uppercase">2345 views</span>
                  </div> -->
                </a>
                <p class="text-center bg-text"><?php echo $ligne_loisir[5]['loisir']; ?></p>
              </div>
            </div><!-- fin div .carousel-item -->
          </div><!-- fin div .carousel-inner no-padding my-5-->
          <a class="carousel-control-prev" href="#hobby" data-slide="prev"><!-- Left and right controls -->
            <span class="carousel-control-prev-icon sp"></span>
          </a>
          <a class="carousel-control-next" href="#hobby" data-slide="next">
            <span class="carousel-control-next-icon sp"></span>
          </a>
        </div><!-- fin div #hobby -->
      </div><!-- fin div .container bg-info -->    
    </section><!-- fin section #loisir -->

    <section class="contact-section" id="contact"><!--Section .contact-section-->
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">localisation :</h4>
                <hr class="mx-auto">
                <div class="small text-black-50"><?php echo $info['adresse']; ?></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-envelope text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">Email</h4>
                <hr class="mx-auto">
                <div class="small text-black-50">
                  <a href="Contact-Objet/index-contact.php">Contact</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">téléphone :</h4>
                <hr class="mx-auto">
                <div class="small text-black-50">+33<?php echo $info['tel']; ?> </div>
              </div>
            </div>
          </div>
        </div>
       
        <!-- Affichage de mes reseaux -->
        <?php
        }
        $sql = $pdo->prepare(" SELECT * FROM t_reseaux WHERE id_utilisateur = 1 ");
        $sql->execute();          
        $ligne_reseau = $sql->fetchAll(); 
        ?>

        <div class="social d-flex justify-content-center">
          <?php echo $ligne_reseau[0]['url']; ?>
          
          <?php echo $ligne_reseau[1]['url']; ?>
        </div>
      </div><!-- fin div .container -->
    </section><!--fin section .contact-section-->

    <footer class="bg-black small text-center text-white-50"><!-- Footer -->
      <div class="container">
        <p class="text-white">Copyright &copy; Setti BELKACEM Site-CV 2018</p>
      </div>
    </footer><!-- fin Footer -->
    
    <script src="back/js/script.js"></script>
    <!-- loisirs -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
  </body>
</html>
