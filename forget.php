<?php session_start(); ?>
<?php require_once __DIR__.'/vendor/autoload.php';

  $mail = new PHPMailer;

?>

<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>


<?php
$error = array();
if(!empty($_POST['submit'])){
  $email = noAttack($_POST['email']);

  $verifEmail = validationEmail($email, 120);
  if(!empty($verifEmail)){
    $error['email']= $verifEmail;
  }

  if(noError($error)){

    $emailDispo = get_email($email);
    if(empty($emailDispo)) {
      $error['email']= 'Email non trouvé';
    }

    if(noError($error)){
      $sql= "SELECT token, pseudo FROM users WHERE email = :email";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email', $email, PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetch();

      $email_url = urlencode($email);


      $mail->isMail();                                      // Set mailer to use SMTP
      // $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
      // $mail->SMTPAuth = true;                               // Enable SMTP authentication
      // $mail->Username = 'user@example.com';                 // SMTP username
      // $mail->Password = 'secret';                           // SMTP password
      // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      // $mail->Port = 587;                                    // TCP port to connect to
      $pseudo = $result['pseudo'];
      $mail->setFrom('reset@connexion.fr', 'Blog-com');
      $mail->addAddress($email, $pseudo);     // Add a recipient
      $mail->addReplyTo('web.master@cci.net', 'Répondre');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      $mail->isHTML(true);                                  // Set email format to HTML

      // $mail->Subject = 'Here is the subject';
      $mail->Subject = 'Bonjour ' . ucfirst($pseudo);
      $mail->Body = 'Bonjour ' . ucfirst($pseudo) . '<br/> Veuillez cliquer sur ce lien pour modifier votre mot de passe : <a href="http://localhost/backend/tp_connexion/reset.php?email=' . $email_url . '&token=' . $result['token'] . '">Reinitialiser votre mot passe<a>';
      $mail->AltBody = 'http://localhost/backend/tp_connexion/reset.php?email=' . $email_url . '&token=' . $result['token'];

      if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
      }
      else {
        echo '<div class="container"><p class="alert-success text-center">Email envoyé !</p></div>';
      }
    }
  }
}

?>


<div class="container">

  <form class="form-group col-lg-6 col-lg-offset-3" action="forget.php" method="POST">
    <legend>Un email avec un lien vous sera envoyé pour rénitialiser votre mot de passe</legend>
    <div class="form-group">
      <label for="email">Email<sup>*</sup> :</label>
      <input class="form-control" type="text" name="email" value="<?php if (!empty($_POST["email"])) { echo $_POST["email"]; } ?>">
      <div class="error"><?php if (!empty($error["email"])) { echo $error["email"]; } ?> </div>
    </div>

    <input class="btn btn-info btn-lg" type="submit" name="submit" value="Envoyer">
    <div>
      <p>
        <small><sup>*</sup> Champs requis.</small>
      </p>
    </div>
  </form>


</div>
