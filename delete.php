<?php

    require_once "pdo.php";
    session_start();

    if (!isset($_SESSION['email'])){
        die("ACCESS DENIED");
    }


    if ( isset($_POST['delete']) && isset($_POST['event_id']) ) {

        $sql = "DELETE FROM events WHERE event_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['event_id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: index.php' ) ;
        return;
    }


      // Guardian: Make sure that user_id is present
      if ( ! isset($_GET['event_id']) ) {
        $_SESSION['error'] = "Event not listed";
        header('Location: index.php');
        return;
      }

      $stmt = $pdo->prepare("SELECT eventname, event_id FROM events where event_id = :xyz");
      $stmt->execute(array(":xyz" => $_GET['event_id']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ( $row === false ) {
          $_SESSION['error'] = 'Event information entered incorrectlu';
          header( 'Location: index.php' ) ;
          return;
      }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wolf Lake's Events Delete Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>

<div class="container">

  <p class="alert-danger">Confirm: Deleting <?= htmlentities($row['event_id'])."?"; ?></p>

  <form method="post">
    <input type="hidden" name="event_id" value="<?= ($row['event_id']); ?>">
    <input type="submit" value="Delete" name="delete"> &nbsp; &nbsp; &nbsp;
    <a href="index.php" button type="button" class="btn">Cancel</button></a>

  </form>

    </div>
</body>
</html>