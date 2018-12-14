<?php

// Contact.class.php 

class Contact{
     private $nom;
     private $email;
     private $sujet;
     private $message;

     // bonus email
     private $to;
     private $headers;

     // fonction d'insertion en BDD :
     public function insertContact($nom, $email, $sujet, $message){
          // 1- on récupère les saisies de l'utilisateur
          // 2- on se connecte à la BDD
          // 3- on créé une requête d'insertion en 2 temps (prepare / execute)
          // 4- on ferme la requête (protection contre les injections malveillantes)

          // 1- on récupère les saisies de l'utilisateur
          $this->nom = strip_tags($nom);
          $this->email = strip_tags($email);
          $this->sujet = strip_tags($sujet);
          $this->message = strip_tags($message);

          // 2- on se connecte à la BDD
          require('connexion-contact.php');

          // 3- on créé une requête d'insertion en 2 temps (prepare / execute)
          $req = $bdd->prepare('INSERT INTO t_contact (nom, email, sujet, message) VALUES (:nom, :email,:sujet, :message)');

          // dans mon execute() je vais affecter à la propriété nom, le nom de l'auteur qui vient de poster un message
          $req->execute([
               ':nom' => $this->nom,
               ':email' => $this->email,
               ':sujet' => $this->sujet,
               ':message' => $this->message
          ]);

          // $req->execute(array(
          //      ':nom' => $this->nom,
          // );

          // 4- on ferme la requête (protection contre les injections malveillantes)
          $req->closeCursor();
     }

     // bonus : envoi email
     public function sendEmail($sujet, $email, $message) {
          $this->to = 'setti.belkacem@lepoles.com';
          $this->email = strip_tags($email);
          $this->sujet = strip_tags($sujet);
          $this->message = strip_tags($message);
          $this->headers = 'De : ' . $this->email . "\r\n"; // retours à la ligne
          $this->headers .= 'MIME-version: 1.0' . "\r\n";
          $this->headers .= 'Content-type : text/html; charset=utf-8' . "\r\n";

          // enfin, on utilise la fonction prédéfinie mail() de PHP
          mail($this->to, $this->sujet, $this->message, $this->headers);
     }
}