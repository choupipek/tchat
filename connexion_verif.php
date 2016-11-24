<?php session_start(); ?>
<?php include('inc/pdo.php'); ?>
<?php include('inc/functions.php'); ?>

<?php

  $error = array();
  $success = false;
    $login = noAttack($_POST['login']);
    $password = noAttack($_POST['password']);

    $verifLogin = validation($login, 100, 5);
    if(!empty($verifLogin)){
      $error['login']= $verifLogin;
    }

    $verifPassword = validation($password, 255, 6);
    if(!empty($verifPassword)){
      $error['password']= $verifPassword;
    }

    if(noError($error)){

      $loginDispo = get_pseudo($login);
      if(empty($loginDispo)) {
        $error['login']= 'Identifiant non trouvé';
      }

      if(empty($loginDispo)) {

        $loginDispo = get_email($login);

        if(empty($loginDispo)) {
          $error['login']= 'Identifiant non trouvé';
        }
        else{
            $error['login']=null;
        }

      }

      if(empty($error['login'])){

        $password_hashed = get_password_crypted($login);
        $password_crypted = $password_hashed['password'];

        if(!password_verify($password, $password_crypted)){
          $error['password']= 'Mot de passe incorrect';
        }
        else{
          $sql= "SELECT * FROM users WHERE pseudo = :login OR email = :login";
          $query = $pdo->prepare($sql);
          $query->bindValue(':login', $login, PDO::PARAM_STR);
          $query->execute();
          $result = $query->fetchAll();

          $_SESSION['user'] = array(
            'pseudo' => $result[0]['pseudo'],
            'id' => $result[0]['id'],
            'role' => $result[0]['role'],
            'ip' => $_SERVER['REMOTE_ADDR']
          );
          $success= true;
        }
      }
    }

  $response = array( 'success' => $success, 'error' => $error);
  showJson($response);
?>
