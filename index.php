<?php
    require_once "pdo.php";
    session_start();

    if (isset($_SESSION['email'])){

    if (!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }


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
      

                echo('<table class="table table-striped" border="1" >'."\n");
                echo "<tr><th>Event Name</th>  <th>Event Date</th> <th>Additional Notes";
                foreach ( $rows as $row ) {
                 echo("</th><tr><td>");  
                   echo(htmlentities($row['eventname']));
               
                   echo("</td><td>");
                   echo(htmlentities($row['eventdate']));
                   echo("</td><td>");
                   echo(htmlentities($row['eventnote']));

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

