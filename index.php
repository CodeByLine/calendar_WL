
<?php

    require_once "pdo.php";
    session_start();

    if (!empty($_SESSION['message'])) {
        echo($_SESSION['message']);
        unset($_SESSION['message']);
    }

    $errors = [];
    $success = [];


    if ((!isset($_SESSION['user_id'])) || (!isset($_SESSION['name']))){

        echo '<p><a href="login.php">Please log in</a></p>';    

    } else {
        // echo '<a href="add.php">Add New Entry</a>';
        
        echo '&nbsp; &nbsp; &nbsp; Welcome! &nbsp; &nbsp; &nbsp; <a href="logout.php">Logout</a>' ; 

        echo('<table class="table table-striped" border="1" >'."\n");

        // profile_id, user_id, first_name, last_name, email, headline, summary

        $sql = ("SELECT * FROM Profile"); // WHERE profile_id = :pd, user_id = :ud, first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su");
        $stmt = $pdo->query($sql);
        $stmt->execute(array(

        ));

        echo "<tr><th>Profile Id</th><th>User Id</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Headline</th> <th>Summary</th> <th>Action";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo("</th><tr><td>");  
        echo(htmlentities($row['profile_id']));
        echo("</td><td>");
        echo(htmlentities($row['user_id']));    
        echo("</td><td>");
        echo(htmlentities($row['first_name']));
        echo("</td><td>");
        echo(htmlentities($row['last_name']));
        echo("</td><td>");
        echo(htmlentities($row['email']));
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo(htmlentities($row['summary']));
        echo("</td><td>");
        // echo ('<a href="view.php?profile_id='.$row['profile_id'].'">View</a>' );
        echo ('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a>  |  ' );

        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        echo("</td></tr>\n");
        echo('</table');
        echo '<p></p>';
    }
}
        // echo("</td><td>");
        // echo ('<a href="edit.php?user_id='.$row['profile_id'].'">Edit</a> |');  // GET 
        // echo ('<a href="delete.php?user_id='.$row['profile_id'].'">Delete</a> |');  // GET 
    ?>
    <!-- END: View one -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yumei Leventhal index.php</title>

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
    <h1><center> Yumei Leventhal Resume Registry</center></h1>
    <p><a href="login.php">Please log in</a></p>
<br>
   

<!-- BEGIN: View one  -->
<!-- <a href="index.php">Back to Index</a> -->


<br>
 <br>

            <p>'My name is Ozymandias, king of kings;</p>
            <p>Look on my works, ye Mighty, and despair!</p>
            <p>Nothing beside remains. Round the decay</p>
            <p>Of that colossal wreck, boundless and bare</p>
            <p>The lone and level sands stretch far away.</p>
            <!-- <a href="add.php">Add New Entry</a> -->
    <br>
    <a href="add.php">Add New Entry</a>
    </div>  
</body>
</html>