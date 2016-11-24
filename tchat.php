<?php session_start(); ?>
<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>

<?php
  if(is_login()){ ?>

    <div class="container">
      <div class="row text-center">
        <h1>Tchat des peignes
           !</h1>
      </div>
      <form id="form_tchat" class="row form-group"  method="POST">

        <div class="form-group">
          <textarea id='message' class="form-control input-xs" placeholder="Ecrivez votre message..." type="text" name="message" ></textarea>
          <div class="error"><?php if (!empty($error["message"])) { echo $error["message"]; } ?> </div>

          <input id="submit_message" class="btn btn-info btn-xs" type="submit" name="submit" value="Envoyer">
        </div>

      </form> <?php

      $sql='SELECT pseudo, tchat_message.created_at AS date_message, content
            FROM tchat_message
            LEFT JOIN users
            ON users.id = tchat_message.user_id
            ORDER BY date_message DESC';

      $query = $pdo->prepare($sql);
      $query->execute();
      $messages = $query->fetchAll(); ?>

      <div id="tchat" class="col-lg-9"> <?php
        if(!empty($messages)){
          $_SESSION['last_message'] = $messages[0]['date_message'];
          foreach ($messages as $message){ ?>
            <div class="<?php
              if($message['pseudo'] === $_SESSION['user']['pseudo']){ echo 'perso text-right'; } else { echo 'old'; } ?> "> <?php
            echo '<h3><small><strong>' . ucfirst($message['pseudo']) . '</strong> a envoyé le '  . date('d/m/Y à H:i:s',strtotime($message['date_message'])) . ' : </small></h3>';
            echo '<strong>' . noAttack(ucfirst($message['content'])) . '</strong>';
            echo '</div>';
          }
        } ?>
      </div>

    </div> <?php
  }
  else{
    header("Location: connexion.php");
  }


?>




<?php include('inc/footer.php'); ?>
