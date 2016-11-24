<?php include('pdo.php'); ?>

<?php

  function debug($tableau){
    echo "<pre>";
    print_r($tableau);
    echo "</pre>";
  }

  function noAttack($string){
    return trim(strip_tags($string));
  }

  function messageError($error, $champs){
    if (!empty($error[$champs])) {
      return $error[$champs];
    }
  }

  //On vérifie la longueur des champs du formulaire
  //et à chaque condition qui est vérifiée on met un message d'erreur
  function validation($string, $max, $min){

    $error = '';
    if(!empty($string)){
      if(strlen($string) > $max){
        $error = "Ce champs est trop grand (" . $max ." caractères maximum).";
      }
      if(strlen($string) < $min) {
        $error= "Ce champs est trop court (" . $min . " caractères minimum).";
      }
    }
    else{
      $error= "Ce champs est vide.";
    }

    return $error;

  }

  function validationEmail($email, $max){
    $error='';

    if (!empty($email)) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $error= "Adresse mail non valide.";
      }
      elseif (strlen($email) > $max){
        $error= "Votre adresse e-mail est trop longue (50 caractères maximum).";
      }
    }
    else {
      $error= "Veuillez renseigner votre e-mail.";
    }
    return $error;
  }

  function noError($errors){
    foreach ($errors as $key => $value) {
      if(!empty($value)){
        return false;
      }
    }
    return true;
  }

  //cette fonction permet de récupérer l'email
  //que l'utilisateur a rentrée dans le formulaire
  //si elle existe;
  function get_email($email){
    global $pdo;

    $sql= "SELECT email FROM users WHERE email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  //cette fonction permet de récupérer le pseudo
  //que l'utilisateur a rentré dans le formulaire
  //s'il existe;
  function get_pseudo($pseudo){
    global $pdo;

    $sql= "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $query = $pdo->prepare($sql);
    $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  //fonction qui permet de générer un token
  function generateToken(){
    $tableau = array('a', 'b', 'c', 'd', 'e' , 'f', 'g', 'h', 'i',
                    'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
                     't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3',
                     '4', '5', '6', '7', '8', '9');
    shuffle($tableau);
    $token = implode('', $tableau);
    shuffle($tableau);
    $temp = implode('', $tableau);
    $token = $token . $temp;
    return $token;
  }

  function get_password_crypted($login){
    global $pdo;

    $sql= "SELECT password FROM users WHERE pseudo = :login OR email = :login";
    $query = $pdo->prepare($sql);
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  function is_login(){
    if(!empty($_SESSION['user']) && ($_SESSION['user']['ip'] == $_SERVER['REMOTE_ADDR'])){
      return true;
    }
    else {
      return false;
    }
  }

  function showJson($data){
    header("content-type: application/json");
    $json = json_encode($data, JSON_PRETTY_PRINT);
    if($json){
      die($json);
    }
    else{
      die("error in json encoding");
    }
  }
?>
