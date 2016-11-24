<?php session_start(); ?>
<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>

<?php


  $error = array();
  if(!empty($_POST['submit'])){
    $password = noAttack($_POST['password']);
    $passwordRepeated = noAttack($_POST['repeat_password']);

    $verifPassword = validation($password, 255, 6);
    if (!empty($verifPassword)) {
      $error['password'] = $verifPassword;
    }

    if ($passwordRepeated != $password) {
      $error['repeat_password'] = 'Attention ! Ce n\'est pas le même mot de passe';
    }

    if(noError($error)){
      $email = noAttack(urldecode($_GET['email']));
      $token = noAttack($_GET['token']);

      $sql= "SELECT token, email, password FROM users WHERE email = :email AND token = :token";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email', $email, PDO::PARAM_STR);
      $query->bindValue(':token', $token, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetch();

      if(password_verify($password, $results['password'])){
        $error['password']= "Mot de passe inchangé.";
      }

      if(noError($error)){

        if($email == $results['email'] && $token == $results['token']){
          $password_crypted = password_hash($password, PASSWORD_DEFAULT);
          $token = generateToken();

          $sql = 'UPDATE users SET password = :password, token = :token WHERE email = :email';
          $query = $pdo->prepare($sql);
          $query->bindValue(':password', $password_crypted, PDO::PARAM_STR);
          $query->bindValue(':token', $token, PDO::PARAM_STR);
          $query->bindValue(':email', $email, PDO::PARAM_STR);
          $query->execute();

          header('Location: connexion.php');
        }
        else{
          header('Location: index.php');
        }
      }
    }
  }

?>


<?php
  if(!empty($_GET['email']) && !empty($_GET['token'])){
    $email = noAttack(urldecode($_GET['email']));
    $token = noAttack($_GET['token']);

    $sql= "SELECT token, email, pseudo FROM users WHERE email = :email AND token = :token";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch();

    if($email == $results['email'] && $token == $results['token']){ ?>

      <div class="container">

        <form class="form-group col-lg-6 col-lg-offset-3" action="reset.php?email=<?php echo $email;?>&amp;token=<?php echo $token; ?>" method="POST">
          <legend>Modification du mot de passe pour <?php echo ucfirst($results['pseudo']); ?></legend>
          <div class="form-group">
            <label for="password">Password<sup>*</sup></label>
            <input class="form-control" type="password" name="password" value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; } ?>">
            <div class="error"><?php if (!empty($error["password"])) { echo $error["password"]; } ?> </div>
          </div>

          <div class="form-group">
            <label for="repeat_password">Reapeat password<sup>*</sup></label>
            <input class="form-control" type="password" name="repeat_password" value="<?php if (!empty($_POST["repeat_password"])) { echo $_POST["repeat_password"]; } ?>">
            <div class="error"><?php if (!empty($error["repeat_password"])) { echo $error["repeat_password"]; } ?> </div>
          </div>

          <input class="btn btn-info btn-lg" type="submit" name="submit" value=Réinitiliaser>

          <div>
            <p>
              <small><sup>*</sup> Champs requis.</small>
            </p>
          </div>
        </form>

      </div> <?php
    }
    else{
      header('Location: index.php');
    }
  }
  else{
    header('Location: index.php');
  }
?>
