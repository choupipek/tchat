<?php session_start(); ?>
<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>

<?php
  if(is_login()){
    header('Location: index.php');
  }
?>


<div class="container">

  <form id="form_connexion" class="form-group col-lg-6 col-lg-offset-3" action="connexion.php" method="POST">

    <div class="form-group">
      <label for="login">Identifiant<sup>*</sup> : (Pseudo ou Email)</label>
      <input class="form-control" type="text" name="login" value="<?php if (!empty($_POST["login"])) { echo $_POST["login"]; } ?>">
      <div id="login_error" class="error"></div>
    </div>

    <div class="form-group">
      <label for="password">Password<sup>*</sup></label>
      <input class="form-control" type="password" name="password" value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; } ?>">
      <div id="password_error" class="error"></div>
    </div>

    <div class="form-group">
      <input class="box-control" type="checkbox" name="remember">
      <label for="remember">Se souvenir de moi ?</label>
    </div>

    <input class="btn btn-info btn-lg" type="submit" name="submit" value="Connexion">
    <div>
      <a href="forget.php">Mot de passe oublié ?</a>
    </div>

    <div>
      <p>
        <small><sup>*</sup> Champs requis.</small>
      </p>
    </div>
  </form>

</div>













<?php include('inc/footer.php'); ?>
