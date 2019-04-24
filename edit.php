<?php
    require_once "pdo.php";
    session_start();

    if (!isset($_SESSION['email'])){
            die("ACCESS DENIED");
    
    } else { 

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

    $errors = [];
    $success = [];

    
    if (isset($_POST['eventname']) && isset($_POST['event_id'])) {
    // if (isset($_POST['Save']) ) {
        if (strlen($_POST['eventname']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Even name is required.</p>\n";
            // header("Location: edit.php");
            header("Location: edit.php?event_id=".$_REQUEST['event_id']);
            return;

        }

        if (strlen($_POST['eventdate']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Date and time are required.</p>\n";
            // header("Location: edit.php");
            header("Location: edit.php?event_id=".$_REQUEST['event_id']);
            return;
        }


        if (empty($_POST['eventnote'])) {
            $_SESSION['message'] = "<p style = 'color:red'>Additional notes (such as location) are required.</p>\n";
            // header("Location: edit.php");
            header("Location: edit.php?event_id=".$_REQUEST['event_id']);
            return;
        }


        if (!$errors) {

            $sql = "UPDATE events SET eventname = :eventname,
                    eventdate = :eventdate, eventnote = :eventnote
                    WHERE event_id = :event_id"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':event_id' => $_POST['event_id'],
                ':eventname' => $_POST['eventname'],
                ':eventdate' => $_POST['eventdate'],
                ':eventnote' => $_POST['eventnote']));
            $_SESSION["success"] = "Event information updated";
            // $_SESSION["message"] = "Record added";
            error_log("Record added.", 0);
            header("Location: view.php");
            return;   
        } 
    }
    
        $stmt = $pdo->prepare("SELECT * FROM events where event_id = :xyz");
        $stmt->execute(array(":xyz" => (int)$_GET['event_id'])); 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row == false) {
            $_SESSION['error'] = 'Something is wrong here-is this the right event?';
            header('Location: view.php');
            // header("Location: edit.php?event_id=".$_REQUEST['id']);
            return;
    }
        
        $e = htmlentities($row['eventname']);
        $d = htmlentities($row['eventdate']);
        $n = htmlentities($row['eventnote']);
        $event_id = $row['event_id'];
}
           
        // Flash pattern
        // if ( isset($_SESSION['error']) ) {
        //     echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        //     unset($_SESSION['error']);
        // }
    
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

<div class="container">

    <h1>Edit Events</h1>
    <br>
    <form method="post">
    <p>Event Name:
    <input type="text" name="eventname" value="<?=htmlentities($e);?>"></p>
    <p>Event Date:
    <input type="text" name="eventdate" value="<?=htmlentities($d);?>"></p>
    <p>Additional Notes:
    <input type="integer" name="eventnote" value="<?=htmlentities($n);?>"></p>
    
    <input type="hidden" name="event_id" value="<?= ($row['event_id']) ?>"></p>
    <p><input type="submit" value="Save"></p>
    <input type="submit" name="cancel" value="Cancel">
    
    <!-- <a href="index.php">Cancel</a></p> -->
    </form>

</div>
</body>
</html>