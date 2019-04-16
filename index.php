<?php
    require_once "pdo.php";
    session_start();

    if (!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    if ( isset($_POST['logout']) ) {
        unset($_SESSION['email']);
        header('Location: index.php');
        return;
    }

    if ( isset($_SESSION['error'])) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }

    if ( isset($_SESSION['success'])) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }

    if ( isset($_POST['edit']) && isset($_POST['event_id']) ) {
        $stmt = $pdo->prepare("SELECT * FROM events where event_id = :xyz");
        $stmt->execute(array(":xyz" => $_GET['event_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( $row === false ) {
            $_SESSION['error'] = 'Bad value for event_id';
            header( 'Location: index.php' ) ;
            return;
        }
        $sql = "UPDATE cal SET eventname = :eventname,
                eventdate = :eventdate, eventnote = :eventnote
                WHERE event_id = :event_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':eventname' => $_POST['eventname'],
            ':eventdate' => $_POST['eventdate'],
            ':eventnote' => $_POST['eventnote']));

        $_SESSION['success'] = 'Event information updated';
        header( 'Location: index.php' ) ;
        return;
    }

    if ( isset($_POST['delete']) && isset($_POST['event_id']) ) {
        $sql = "DELETE FROM events WHERE event_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['event_id']));
        $_SESSION['success'] = 'Record deleted';

        header( 'Location: index.php' ) ;
        return;
    }

    $errors = [];
    $success = [];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events Calendar</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>

<div class="container">
    <h1><center>Welcome to Wolf Lake's Events Calendar </center></h1>
    <!-- <h1>Event Listing for <?php echo htmlentities($_SESSION["email"]); ?></h1> -->
    <br>
   <br>


   <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th, td {
        padding: 10px;
        }
        
    </style>

    <?php   
        if (isset($_SESSION['email'])){
            echo('<p style="color: green;">'."Logged in"."</p>\n");
            error_log("Login success.", 0);
            unset($_SESSION['success']);
            // `event_id`, ``, ``, ``
            $stmt = $pdo->query("SELECT event_id, eventname, eventdate, eventnote FROM events");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
            if ($rows == false) {
                echo("No event found here");
            } else {
      
                foreach ( $rows as $row ) {
                    echo('<table border="1">'."\n");
                   echo "<tr><td>";
                //    echo "&lt;b&gt;"; 
                   echo(htmlentities($row['eventdate']).("&nbsp; &nbsp;"));
                //    echo "&lt;/b&gt;"; 
                   echo("</td><td>");
                   echo(htmlentities($row['eventname']).("&nbsp; &nbsp;"));
                   echo("</td><td>");
                   echo(htmlentities($row['eventnote']).("&nbsp; &nbsp;"));
                   echo("</td><td>");
                   echo ('<a href="edit.php?event_id='.$row['event_id'].'">Edit</a>');
                   echo("</td><td>");
                //    form not needed

                echo ('<a href="delete.php?event_id='.$row['event_id'].'">Delete</a>');
 
                   echo("</td></tr>\n");

                echo('</table');
                
                } 
            }
            
            echo ('<p><a href="add.php">Add New Entry</a> &nbsp; | &nbsp; <a href="logout.php">Logout</a> </p>');
    
        } else {
            echo ('<p> <a href="login.php">Please log in</a></p>');

            $stmt = $pdo->query("SELECT * FROM events ORDER BY `events`.`eventdate`  ASC");

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
            if ($rows == false) {
                echo("No such event found.");
            } else {
               
                foreach ( $rows as $row ) {
                    echo('<table class="table table-striped" border="1" >'."\n");
                   echo "<tr><td>";
                //    echo "&lt;b&gt;"; 
                   echo(htmlentities($row['eventname']).("&nbsp; &nbsp;"));
                //    echo "&lt;/b&gt;"; 
                   echo("</td><td>");
                   echo(htmlentities($row['eventdate']).("&nbsp; &nbsp;"));
                   echo("</td><td>");
                   echo(htmlentities($row['eventnote']).("&nbsp; &nbsp;"));

                   echo("</td></tr>\n");
                echo('</table');
                
                } 
            }

        }
    ?>


            
</body>
</html>

