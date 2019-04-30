<?php

    require_once "../pdo.php";
    session_start();

    if (!isset($_SESSION['email'])){
        die("ACCESS DENIED");
        header( 'Location: index.php' ) ;
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: users.php');
        return; }

    if ( isset($_POST['logout']) ) {
      unset($_SESSION['email']);
      header('Location: ../index.php');
      return; }




    if ( isset($_POST['delete']) && isset($_POST['user_id']) ) {

        $sql = "DELETE FROM users WHERE user_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['user_id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: ../add_users/users.php' ) ;
        return;
    }


      // Guardian: Make sure that user_id is present
      if ( ! isset($_GET['user_id']) ) {
        $_SESSION['error'] = "User not listed";
        header('Location: ../add_users/users.php');
        return;
      }

      $stmt = $pdo->prepare("SELECT username, user_id FROM users where user_id = :xyz");
      $stmt->execute(array(":xyz" => $_GET['user_id']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ( $row === false ) {
          $_SESSION['error'] = 'User information incorrect';
          header( 'Location: ../view.php' ) ;
          return;
      }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wolf Lake's User Management Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
     </head>
     <body>
     <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th, td {
        padding: 10px;
        }
        
    </style>

<div class="container">

<br><br><br>

  <p class="alert-danger">Confirm: Deleting user "<?= htmlentities($row['username'])."?"; ?>"</p>

  <form method="post">
    <input type="hidden" name="user_id" value="<?= ($row['user_id']); ?>">
    <input type="submit" value="Delete" name="delete"> &nbsp; &nbsp; &nbsp;
    <a href="../add_users/users.php" button type="button" class="btn">Cancel</button></a>

  </form>

    </div>
</body>
</html>