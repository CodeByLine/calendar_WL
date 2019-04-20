<?php
require_once "pdo.php";
session_start();

    // if (!isset($_SESSION['email'])){
    //     die("ACCESS DENIED");

    // } else { 

    if ( isset($_POST['cancel']) ) {
        header('Location: view.php');
        return; }    

    if ( isset($_POST['logout']) ) {
        unset($_SESSION['email']);
        header('Location: view.php');
        return; }

    if (!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }  
// }  

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
    <h1><center>Add Users</center></h1>
    <br>
<?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }

    // Flash pattern
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }


    echo('<table table-striped border="1">'."\n");
    $stmt = $pdo->query("SELECT username, email, password, user_id FROM users");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo(htmlentities($row['username']));
        echo("</td><td>");
        echo(htmlentities($row['email']));
        echo("</td><td>");
        echo(htmlentities($row['password']));
        echo("</td><td>");
        echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a> / ');
        echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }
    ?>
</table>
<br>
<a href="add.php">Add New</a>

</div>
</body>
</html>
