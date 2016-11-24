<?php
  session_start();
  include ('inc/pdo.php');
  include ('inc/functions.php');
?>

<?php
  if(is_login() && $_SESSION['user']['role'] == 'admin'){
    if(!empty($_GET['id'])){
      $role = noAttack($_POST['role']);
      $id = noAttack($_GET['id']);
      if(is_numeric($id)){
        $sql = 'SELECT id, role FROM users WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindValue('id', $id, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetch();

        if(!empty($results)){
          debug($results);
          if($results['role'] != $role){
            $sql = 'UPDATE users SET role = :role WHERE id = :id';
            $query = $pdo->prepare($sql);
            $query->bindValue('role', $role, PDO::PARAM_INT);
            $query->bindValue('id', $id, PDO::PARAM_STR);
            $query->execute();
            header('Location: index.php');
          }
          else{
            header('Location: index.php');
          }
        }
        else{
          header('Location: index.php');
        }
      }
      else{
        header('Location: index.php');
      }
    }
    else{
      header('Location: index.php');
    }
  }
  else{
    header('Location: index.php');
  }
?>
