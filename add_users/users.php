<?php
    require_once "../pdo.php";
    session_start();

        // if (!isset($_SESSION['email'])){
        //     die("ACCESS DENIED");
        //     header("Location: ../index.php");
        //     return;

        //   }

        if ( isset($_POST['logout']) ) {
            unset($_SESSION['email']);
            header('Location: ../index.php');
            return; }
        
        if ( isset($_POST['cancel']) ) {
            // unset($_SESSION['email']);
            header('Location: users.php');
            return; }    
    
      
        if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
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
    <title>Wolf Lake's Events Edit Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="../main.css">

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

    <h1><center>View Users</center></h1>
    <br>
<?php

    echo('<table class="table table-striped" border="1" >'."\n");
    echo ("<tr> <th>User Name</th>  <th>Email</th><th>Password</th><th>Note</th><th>Edit");
    $stmt = $pdo->query("SELECT username, email, password, note, user_id FROM users");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

        echo ("<tr><td>");
        echo($row['username']);
        echo("</td><td>");
        echo($row['email']);
        echo("</td><td>");
        echo($row['password']);
        echo("</td><td>");
        echo($row['note']);
        echo("</td><td>");
        // echo("</td><td>");
        echo('<a href="../add_users/edit.php?user_id='.$row['user_id'].'">Edit</a>');
        // echo("</td><td>");
        // echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }

    ?>
</table>

<a href="../add_users/add_users.php">Add Another User</a>

</div>
</body>
</html>
