<?php
    require_once "pdo.php";
    session_start();

        if (!isset($_SESSION['email'])){
            die("ACCESS DENIED");
          }

        if ( isset($_POST['logout']) ) {
            unset($_SESSION['email']);
            header('Location: index.php');
            return; }
      
        if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }    

    $errors = [];
    $success = [];

    // Flash pattern
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }




if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])  ) {
    // if ( empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
    //     $_SESSION['message'] = "<p style='color: red'>All values are required </p>\n";
    //     error_log("All values are required.", 0);
    //     header("Location: add.php");
    // }

    // if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
         
        if (strlen($_POST['make']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Make is required.</p>\n";
            header("Location: add.php");
            return;

        }

        if (strlen($_POST['model']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Model is required.</p>\n";
            header("Location: add.php");
            return;

        }


        if (empty($_POST['year'])) {
            $_SESSION['message'] = "<p style = 'color:red'>Year is required.</p>\n";
            header("Location: add.php");
            return;

        }

        if ((!is_numeric($_POST['year']))) { 
            $_SESSION['message'] = "<p style = 'color:red'>Mileage and year must be numeric.</p>\n";
            header("Location: add.php");
            return;

        }


        if (strlen($_POST['mileage']) < 1 ) {
            $_SESSION['message'] = "<p style = 'color:red'>Mileage is required.</p>\n";
            header("Location: add.php");
            return;
            // $errors[$_POST['mileage']]= 'Mileage is required';
            // echo("<p>Mileage is required</p>\n");
        }

        if (!is_numeric($_POST['mileage'])) { 
            $_SESSION['message'] = "<p style = 'color:red'>Mileage and year must be numeric.</p>\n";
            header("Location: add.php");
            return;
            // $errors[$_POST['mileage']]= 'Mileage and year must be numeric';
            // echo("<p>Mileage and year must be numeric</p>\n");
        }
    // }

    if (!$errors) {
        
          $sql = "INSERT INTO events (eventname, eventdate, eventnote)
          VALUES (:eventname, :eventdate, :eventnote)";
          echo("<pre>\n".$sql."\n</pre>\n");
          $stmt = $pdo->prepare('INSERT INTO events (eventname, eventdate, eventnote) VALUES (:eventname, :eventdate, :eventnote)');

          $stmt->execute(array(
            ':event_id' => $_POST['event_id'],
            ':eventname' => $_POST['eventname'],
            ':eventdate' => $_POST['eventdate'],
            ':eventnote' => $_POST['eventnote']));
            $_SESSION["success"] = "Record added";
            //   $_SESSION["message"] = "Event added"; 
              error_log("Event added.", 0);
              header("Location: index.php");
              return;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wolf Lake's Add An Event Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>

<div class="container">

    <h1>Wolf Lake's Add An Event Page</h1>
    <br>
    <form method="post">
        <p>Event Name: &nbsp; &nbsp; 
        <input type="text" name="eventname" size="30"></p>
        <p>Event Date: &nbsp; 
        <input type="datetime" name="eventdate" size="30"></p>
        <p>Additional Notes: &nbsp; &nbsp; &nbsp; 
        <input type="text" name="eventnote"></p>
        
        <p><input type="submit" value="Add New Event"/> &nbsp; &nbsp; &nbsp; 
        
        <!-- <input type="submit" name="cancel" value="Cancel"> &nbsp; &nbsp; &nbsp;  -->
        <input type="submit" name="logout" value="Logout"> 
    </form>
    <a href="index.php">Cancel</a>
    <a href="view.php">View Batmobiles Logged</a>

  
</div>
</body>
</html>