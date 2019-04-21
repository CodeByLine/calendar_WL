
<?php // Do not put any HTML above this line
    session_start();
    require_once "pdo.php";
    
    
    if (!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
   
    $errors = [];
    $success = [];

    // If the user requested logout go back to index.php
    // if ( isset($_POST['logout']) ) {
    //      header('Location: index.php');
    //     return;
    // }

    if ( isset($_POST['email']) && isset($_POST['password']) ) {
        
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);
        
        
        if ( strlen($email) < 1 || strlen($password) < 1 ) {
            
            $_SESSION['message'] = "<p style = 'color:red'>username and password are required.</p>\n";
            error_log("Username and password are required.", 0);
            header("Location: login.php");
            return;    
        } 
        
        $atsign = strpos($email, '@');
        if ($atsign == false) {

            $_SESSION['message'] = "<p style = 'color:red'>SECRET: Did you enter the correct email address?</p>\n";
            // error_log("Username must have an at-sign (@).", 0);
            error_log("Did you enter the correct email address?");
            header("Location: login.php");
            return;

            } else {      

            $newpass = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("SELECT  `password` FROM `users` WHERE email = :uvw");

            $stmt->execute(array(

                ":uvw" => $email));
    
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $results = $row ['password'];
 
                echo($results);
                echo($password);
                echo($newpass);

                if (password_verify($password, $results)) {
 
                $_SESSION['message'] = "<p style = 'color:green'>Login success.</p>\n";
                header("Location: view.php" );
                return;

            } else {
   
                echo 'Invalid password.';
                $_SESSION['message'] = "<p style = 'color:red'> SECRET: Password incorrect.</p>\n";
                header("Location: login.php" );
                return;       
            }   
        }

}

// Fall through into the View
?>
<!-- login page -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wolf Lake's Events Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">

    <!-- <script src="main.js"></script> -->
</head>
<body>
<div class="container">
    <h1>Wolf Lake's Events Calendar – Summer 2019</h1>
    <br>
    <br>
    <h3>
    <label for="login">Admins: Please Log In</label></h3>

    <br>

    <form method="POST">  
        <label for="email">User Name</label>
        <input type="text" name="email" id="email" size="20" value="<?=htmlentities('');?>" > <br>
        <label for="id_1723">Password</label>
        <input type="password" name="password" id="id_1723" value="<?=htmlentities('');?>">
        <input type="submit" value="Log In" >
        <input type="submit" name="cancel" value="Cancel">
        <br>
        <br>

        <h5>Contact Wolf Lake Office directly if you need help.</h5>
 
    </form>
</div>
</body>
</html>