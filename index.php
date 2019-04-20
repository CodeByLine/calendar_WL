<?php
    require_once "pdo.php";
    session_start();

    if (isset($_SESSION['email'])){

    if (!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    // if (isset($_SESSION['email'])){

    //     echo( '<a href="add.php">'."Add New Entry".'</a>' ."&nbsp; | &nbsp; " .'<a href="logout.php">'."Logout".'</a> </p>');            

    //         if ( isset($_POST['logout']) ) {
    //             unset($_SESSION['email']);
    //             header('Location: index.php');
    //             return;
    //         }

    //         if ( isset($_SESSION['error'])) {
    //             echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    //             unset($_SESSION['error']);
    //         }

    //         if ( isset($_SESSION['success'])) {
    //             echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    //             unset($_SESSION['success']);
    //         }
        }

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
    <h1><center>Wolf Lake's Events Calendar </center></h1>
    <br>
        <h3><center>Summer 2019</center></h3>

    <!-- <br> <a href="login.php">Login</a> -->
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
 

        $stmt = $pdo->query("SELECT event_id, eventname, eventdate, eventnote FROM events");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
            if ($rows == false) {
                echo("No event found here");
            } else {
      

                foreach ( $rows as $row ) {
                    echo('<table class="table table-striped" >'."\n");
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
    ?>
    <br>
    <br>

    </div>  
</body>
</html>

