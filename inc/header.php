<?php include('inc/functions.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" media="screen" >
    <link rel="stylesheet" href="css/style.css" media="screen" >
    <title>Tchat</title>

  </head>
  <body>


    <nav class="navbar navbar-inverse">
      <ul class="nav navbar-nav col-lg-10">
        <li><a href="index.php">Accueil</a></li>
      </ul>
      <div class="col-lg-2">

        <ul class="nav navbar-nav navbar-right"> <?php
          if(is_login()){ ?>
            <li>
              <a id="load_tchat" href="tchat.php"><button class="btn btn-success" type="button" name="button">TCHAT<i class="fa fa-lock"></i></button></a>
            </li>
            <li>
              <a href="deconnexion.php"><button class="btn btn-danger" type="button" name="button">Deconnexion<i class="fa fa-lock"></i></button></a>
            </li> <?php
          }
          else{ ?>
            <li>
              <a href="connexion.php"><button class="btn btn-info" type="button" name="button">Connexion<i class="fa fa-lock"></i></button></a>
            </li>
            <li>
              <a href="inscription.php"><button class="btn btn-info" type="button" name="button">Inscription<i class="fa fa-signin"></i></button></a>
            </li> <?php
          } ?>
        </ul>
      </div>
    </nav>
