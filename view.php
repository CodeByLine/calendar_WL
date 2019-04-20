<?php   
    require_once "pdo.php";
    session_start();

    $errors = [];
    $success = [];


    // if (!empty($_SESSION)){

        if (!isset($_SESSION['email'])){
            // die("ACCESS DENIED");
            header('Location: index.php');
            return;
          }

        if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }      

        if ( isset($_POST['logout']) ) {
            unset($_SESSION['email']);
            header('Location: index.php');
            return; }
    
        
        if ( isset($_POST['delete']) && isset($_POST['event_id']) ) {
            $sql = "DELETE FROM events WHERE autos_id = :zip";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':zip' => $_POST['event_id']));
            $_SESSION['success'] = 'Event deleted';
            header( 'Location: index.php' ) ;
            return;
        }
    
    

 ?>

 <!DOCTYPE html>
 <html lang="en">
     <head>
         <title>Wolf Lake's Events At A Glance– Summer 2019</title>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <h1>Wolf Lake's Events At A Glance– Summer 2019</h1>
<br>
     <?php
        if (isset($_SESSION['email'])){
            echo('<p style="color: green;">'."Logged in"."</p>\n");
            echo('<p>'."Don't forget to ".'<a href="logout.php">' ."Logout" .'</a>'."</p>\n");
            error_log("Login success.", 0);
            unset($_SESSION['success']);
            

            $sql = "SELECT * FROM events ORDER BY `events`.`eventdate`  ASC";
            $stmt = $pdo->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
            if ($rows == false) {
                echo("No such event found.");
            } else {
      
                foreach ( $rows as $row ) {
                    echo('<table class="table table-striped" border="1" >'."\n");
                   echo "<tr><td>";
                   
                   echo(htmlentities($row['eventname']).("&nbsp; &nbsp;"));
             
                   echo("</td><td>");
                   echo(htmlentities($row['eventdate']).("&nbsp; &nbsp;"));
                   echo("</td><td>");
                   echo(htmlentities($row['eventnote']).("&nbsp; &nbsp;"));
                   echo("</td><td>");
                   
                   echo ('<a href="edit.php?event_id='.$row['event_id'].'">Edit</a>');
                   echo("</td><td>");

                echo ('<a href="delete.php?event_id='.$row['event_id'].'">Delete</a>');

                   echo("</td></tr>\n");
                echo('</table');
                
                } 
            }
        }

        // else {

        //     echo("hello");
        // }

     
 
    ?>
    <br>
    <br>
        <p><a href="add.php">Add New Entry</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="index.php">Go Back</a> &nbsp; &nbsp; | &nbsp; &nbsp;
        <a href="logout.php">Logout</a> </p>

    </div>
     
     </body>
 </html>


 