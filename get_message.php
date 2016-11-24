<?php
  session_start();
  include ('inc/pdo.php');
  include ('inc/functions.php');
?>

<?php

  $sql='SELECT pseudo, tchat_message.created_at AS date_message, content
        FROM tchat_message
        LEFT JOIN users
        ON users.id = tchat_message.user_id
        WHERE tchat_message.created_at > "' . $_SESSION['last_message'] . '"
        ORDER BY date_message DESC';

  $query = $pdo->prepare($sql);
  $query->execute();
  $messages = $query->fetchAll();

  if(!empty($messages)){

    foreach ($messages as $message){?>
      <div class="<?php
        if($message['pseudo'] === $_SESSION['user']['pseudo']){ echo 'perso text-right'; } else { echo 'old'; } ?> news"> <?php
      echo '<h3><small><strong>' . ucfirst($message['pseudo']) . '</strong> a envoyé le '  . date('d/m/Y à H:i:s',strtotime($message['date_message'])) . ' : </small></h3>';
      echo '<strong>' . noAttack(ucfirst($message['content'])) . '</strong>';
      echo '</div>';
    }
    $_SESSION['last_message'] = $messages[0]['date_message'];
  }



?>
