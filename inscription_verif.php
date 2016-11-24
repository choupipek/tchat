<?php
  include('inc/pdo.php');
  include ('inc/functions.php');

  $error = array();
  $success = false;
    //on protège les valeurs entrées dans le formulaire grâce à la fonction "noAttack"
    $pseudo=noAttack($_POST['pseudo']);
    $email=noAttack($_POST['email']);
    $password=noAttack($_POST['password']);
    $passwordRepeated=noAttack($_POST['repeat_password']);

    //Ensuite on fait le processus des différentes vérifications
    $verifPseudo=validation($pseudo,100,5);
    if(!empty($verifPseudo)){
      $error['pseudo']= $verifPseudo;
    }

    $verifEmail=validationEmail($email,120);
    if(!empty($verifEmail)){
      $error['email']= $verifEmail;
    }

    $verifPassword = validation($password, 225, 6);
    if(!empty($verifPassword)){
      $error['password']= $verifPassword;
    }

    $verifPasswordRepeated = validation($passwordRepeated, 225, 6);
    if(!empty($verifPasswordRepeated)){
      $error['repeat_password']= $verifPasswordRepeated;
    }

    //On vérifie si Le mot de passe répété est identique
    //au premier mot de passe.
    if($passwordRepeated != $password){
      $error['repeat_password']= 'Attention ! Ce n\'est pas le même mot de passe';
    }

    //On vérifie si le tableau "error" contient
    //des erreurs grace à la fonction "noError".
    if(noError($error)){
      $emailDispo = get_email($email);

      //Si la fonction "get_email()" renvoie quelque chose
      //alors $emailDispo ne sera pas vide et contiendra
      //l'email entré par l'utilisateur et l'email
      //existe déjà.
      if(!empty($emailDispo)){
        $error['email'] = "Email déjà existante";
      }

      $pseudoDispo = get_pseudo($pseudo);

      //Si la fonction "get_pseudo()" renvoie quelque chose
      //alors $pseudolDispo ne sera pas vide et contiendra
      //le pseudo entré par l'utilisateur et le pseudo
      //existe déjà.
      if(!empty($pseudoDispo)){
        $error['pseudo'] = "Pseudo non disponible";
      }

      if(noError($error)){
        $password_crypted = password_hash($password, PASSWORD_DEFAULT);
        // echo $password_crypted;
        $token = generateToken();
          $sql = 'INSERT INTO users (pseudo, email, password, token, created_at, role)
                  VALUES ( :pseudo, :email , :password_crypted , :token , NOW(), "user")';

          $query = $pdo->prepare($sql);
          $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
          $query->bindValue(':email', $email, PDO::PARAM_STR);
          $query->bindValue(':password_crypted', $password_crypted, PDO::PARAM_STR);
          $query->bindValue(':token', $token, PDO::PARAM_STR);
          $query->execute();
          $success = true;
      }
    }

  $response = array(
    'success' => $success,
    'error' => $error
  );

  showJson($response);
?>
