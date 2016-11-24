<?php
session_start();
include ('inc/pdo.php');
include ('inc/functions.php');
?>

<?php
if(is_login()){
  $sql = 'SELECT pseudo FROM users ORDER BY RAND() LIMIT 1';
  $query = $pdo->prepare($sql);
  $query->execute();

  echo $query->fetchColumn();
}
?>
