<?php session_start(); ?>
<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>

<div class="container">
  <p id="success" class='alert-success text-center'>

  </p>
</div>

<div class="container">

  <form id="form_inscription" class="form-group col-lg-6 col-lg-offset-3" action="inscription.php" method="POST">

    <div class="form-group">
      <label for="pseudo">Pseudo<sup>*</sup></label>
      <input class="form-control input-lg" type="text" name="pseudo" value="<?php if (!empty($_POST["pseudo"])) { echo $_POST["pseudo"]; } ?>">
      <div  id ="pseudo_error" class="error"></div>
    </div>

    <div class="form-group">
      <label for="email">Email<sup>*</sup></label>
      <input class="form-control input-lg" type="text" name="email" value="<?php if (!empty($_POST["email"])) { echo $_POST["email"]; } ?>">
      <div id ="email_error" class="error"></div>
    </div>

    <div class="form-group">
      <label for="password">Password<sup>*</sup></label>
      <input class="form-control input-lg" type="password" name="password" value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; } ?>">
      <div id ="password_error" class="error"></div>
    </div>

    <div class="form-group">
      <label for="repeat_password">Reapeat password<sup>*</sup></label>
      <input class="form-control input-lg" type="password" name="repeat_password" value="<?php if (!empty($_POST["repeat_password"])) { echo $_POST["repeat_password"]; } ?>">
      <div id ="password_repeat_error" class="error"></div>
    </div>

    <input class="btn btn-info btn-lg" type="submit" name="submit" value="S'inscrire">

  </form>

</div>

<?php include('inc/footer.php'); ?>
