<?php
    require_once "../pdo.php";
    session_start();

        if (!isset($_SESSION['email'])){
            die("ACCESS DENIED");
            header("Location: ../index.php");
            return;

          } 

        if ( isset($_POST['cancel']) ) {
            header('Location: users.php');
            return; }


        if ( isset($_POST['logout']) ) {
            unset($_SESSION['email']);
            header('Location: ../index.php');
            return; }
      
        if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }    

    $errors = [];
    $success = [];

    if ( isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {

         
        if (strlen($_POST['username']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>SECRET: Username is required.</p>\n";
            header("Location: add_users.php");
            return;

        }

        if (strlen($_POST['email']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>SECRET: Event date is required.</p>\n";
            header("Location: add_users.php");
            return;

        }


        if (empty($_POST['password'])) {
            $_SESSION['message'] = "<p style = 'color:red'>Password is required.</p>\n";
            header("Location: add_users.php");
            return;

         }      

    if (!$errors) {

        // $username = $_POST['username'];
        // $email = $_POST['email'];
        // $p = ($_POST['password']);
        // $password = PASSWORD_HASH($p, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET username = :username,
                    email = :email, password = :password
                    WHERE user_id = :user_id"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':user_id' => $_POST['user_id'],
                ':username' => $_POST['username'],
                ':email' => $_POST['email'],
                ':password' => $_POST['password']));

            // $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // $_SESSION["success"] = "User information updated";
            // $_SESSION["message"] = "Record added";
            error_log("Record updated.", 0);
            header("Location: users.php");
            return;   
        }
    }
    $stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
    $stmt->execute(array(":xyz" => (int)$_GET['user_id'])); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row == false) {
        $_SESSION['error'] = 'Something is wrong here';
        header('Location: users.php');
        return;
    } else {
        $un = htmlentities($row['username']);
        $em = htmlentities($row['email']);
        $pd = htmlentities($row['password']);
        $event_id = $row['user_id'];
    }


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
    <h1><center>Edit Users</center></h1>
    <br>

    <form method="post">
    <p>Edit User:
    <input type="text" name="username" value="<?=$un;?>"></p>
    <p>Event Date:
    <input type="email" name="email" value="<?=$em;?>"></p>
    <p>Additional Notes:
    <input type="password" name="password" value="<?=$pd;?>"></p>
    
    <input type="hidden" name="user_id" value="<?= ($row['user_id']) ?>">
    <p><input type="submit" value="update user"></p>
    <input type="submit" name="cancel" value="Cancel">
    

    </form>

        <br>
        <br>
        
        <a href="add_users.php">add another user</a>
        <a href="users.php">view all users</a>
        <a href="../logout.php">logout</a>
 
<br>
<br>

<br>

<h2> <center>All Users </center> </h2>
<br>
<?php
    // Flash pattern
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }


    echo('<table class="table table-striped" border="1" >'."\n");
    echo ("<tr> <th>User Name</th>  <th>Email</th>  <th>Password</th><th>Edit</th><th>Delete");
    $stmt = $pdo->query("SELECT username, email, password, user_id FROM users");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

        echo "<tr><td>";
        echo(htmlentities($row['username']));
        echo("</td><td>");
        echo(htmlentities($row['email']));
        echo("</td><td>");
        echo(htmlentities($row['password']));
        echo("</td><td>");
        echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a>');
        echo("</td><td>");
        echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }

    ?>
</table>
<br>

</div>
</body>
</html>
