<?php
session_start();
include ('inc/pdo.php');
include ('inc/functions.php');
?>

<?php
$error = array();

    $message = noAttack($_POST['message']);

    $verifMessage = validation($message, 500, 1);
    if(!empty($verifMessage)){
      $error['message'] = $verifMessage;
    }

    if(noError($error)){
      $user_id = $_SESSION['user']['id'];
      $sql = 'INSERT INTO tchat_message (user_id, content, created_at)
              VALUES ( :user_id, :content, NOW() )';
      $query = $pdo->prepare($sql);
      $query->bindValue('user_id', $user_id, PDO::PARAM_INT);
      $query->bindValue('content', $message, PDO::PARAM_STR);
      $query->execute();

  }
?>
