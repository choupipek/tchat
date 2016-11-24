<?php session_start(); ?>
<?php include('inc/header.php'); ?>
<?php include('inc/pdo.php'); ?>



<?php
$sql = 'SELECT COUNT(id) FROM users WHERE 1 ';
$query = $pdo->prepare($sql);
$query->execute();
$number_users = $query->fetchColumn();

$sql = 'SELECT pseudo FROM users ORDER BY created_at DESC LIMIT 1 ';
$query = $pdo->prepare($sql);
$query->execute();
$last_user_registered = $query->fetchColumn();

if(!is_login()){ ?>
  <div class="container-fluid">
    <div class="col-lg-9 text-left">
      <h1>Bienvenue sur TCHAT.FR !</h1>
    </div>
    <div class="col-lg-3 text-justify">
      <p>
        Notre communauté compte actuellement <?php echo $number_users; ?> membres ! <strong><?php echo $last_user_registered; ?></strong> est notre dernier membre inscrit !
      </p>
    </div>
  </div> <?php
}
else {
  $sql = 'SELECT created_at FROM users WHERE pseudo = :pseudo ';
  $query = $pdo->prepare($sql);
  $query->bindValue(':pseudo', $_SESSION['user']['pseudo'], PDO::PARAM_STR).
  $query->execute();
  $date_register = $query->fetchColumn(); ?>

  <div class="container-fluid">
    <div class="col-lg-3 text-justify alert-success">
      <h1 class="text-center text-success">Bonjour <?php echo ucfirst($_SESSION['user']['pseudo']); ?> !</h1>
      <hr>
      <p class="text-center"><?php echo 'Vous êtes inscrit depuis le ' . date('d/m/Y', strtotime($date_register)); ?></p>
      <hr>
      <button id="user_random" class="btn btn-info btn-lg" type="button" name="button">Take username of one user</button>
    </div><?php
    if($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'Admin'){
      $sql = 'SELECT id, pseudo, email, role, created_at FROM users WHERE 1 ORDER BY created_at DESC ';
      $query = $pdo->prepare($sql);
      $query->execute();
      $results = $query->fetchAll(); ?>

      <div class="col-lg-6">
        <h1 class="text-center text-info"><u>Liste des utilisateurs inscrits</u></h1>
        <table class="table table-striped table-bordered table-hover table-condensed">

            <thead>
              <tr class="text-center">
                <td>Pseudo</td>
                <td>Email</td>
                <td>Inscrit le</td>
                <td>Role</td>
                <td>Modifier Role</td>
              </tr>
            </thead>

            <tbody> <?php
              foreach ($results as $result) {
                echo '<tr class="text-center">';

                echo '<td>';
                echo '<strong>' . $result['pseudo'] . '</strong>';
                echo '</td>';

                echo '<td>';
                echo '<em>' . $result['email'] . '</em>';
                echo '</td>';

                echo '<td>';
                echo date('d/m/Y à G\Hi', strtotime($result['created_at']));
                echo '</td>';

                echo '<td>';
                echo strtoupper($result['role']);
                echo '</td>';

                echo '<td>';
                echo '<form class="form-horizontal" action="change_role.php?id=' . $result['id'] . '" method="POST">
                  <select class="form-control" name="role">
                    <option class="form-control" value="admin">Admin</option>
                      <option class="form-control" value="user">User</option>
                  </select> <input class="btn btn-info" type="submit" name="submit" value="changer">
                </form> ';
                echo '</td>';

                echo '</tr>';
              } ?>
            </tbody>
        </table>
      </div> <?php
    } ?>
  </div> <?php
} ?>

<?php include('inc/footer.php'); ?>
