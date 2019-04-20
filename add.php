<?php
    require_once "pdo.php";
    session_start();

        if (!isset($_SESSION['email'])){
            die("ACCESS DENIED");
            header("Location: index.php");
            return;

          }

        if ( isset($_POST['logout']) ) {
            unset($_SESSION['email']);
            header('Location: index.php');
            return; }
      
        if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }    

    $errors = [];
    $success = [];

    
    // Flash pattern
    // if ( isset($_SESSION['error']) ) {
    //     echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    //     unset($_SESSION['error']);
    // }


    if ( isset($_POST['eventname']) && isset($_POST['eventdate']) && isset($_POST['eventnote'])) {

         
        if (strlen($_POST['eventname']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Event name is required.</p>\n";
            header("Location: add.php");
            return;

        }

        if (strlen($_POST['eventdate']) < 1) {
            $_SESSION['message'] = "<p style = 'color:red'>Event date is required.</p>\n";
            header("Location: add.php");
            return;

        }


        if (empty($_POST['eventnote'])) {
            $_SESSION['message'] = "<p style = 'color:red'>Event note is required.</p>\n";
            header("Location: add.php");
            return;

         }

        //  if (!checkdate($_POST['eventdate'])) {
        //     if (date_format($_POST[
        //         'eventdate'], 'Y-m-d H:i'.' ') == false) {
        //     $_SESSION['message'] = "<p style = 'color:red'>Date and time must be in the specific format (see note).</p>\n";
        //     header("Location: add.php");
        //     return;
        //  }

        // $sql = "SELECT `eventdate` FROM `events`";
        // $stmt = $pdo->prepare($sql);
        // $row = $stmt ->execute(array());
        $dt = ($_POST['eventdate']);
        function validateDate($dt, $format = 'Y-m-d H:i:s')
        {
            $d = DateTime::createFromFormat($format, $dt);
            return $d && $d->format($format) == $dt;
        }
        
        // var_dump(validateDate('2012-02-28 12:12:12')); # true
        // var_dump(validateDate('2012-02-30 12:12:12')); # false
            $val = validateDate($dt);
            if ($val==false) {
            //     if (date_format($_POST[
            //         'eventdate'], 'Y-m-d H:i'.' ') == false) {
                $_SESSION['message'] = "<p style = 'color:red'>Date and time must be in the specific format (see note).</p>\n";
                header("Location: add.php");
                return;
             }
            

    if (!$errors) {
        
          $sql = "INSERT INTO events (eventname, eventdate, eventnote)
          VALUES (:eventname, :eventdate, :eventnote)";

        //   echo("<pre>\n".$sql."\n</pre>\n");

          $stmt = $pdo->prepare('INSERT INTO events (eventname, eventdate, eventnote) VALUES (:eventname, :eventdate, :eventnote)');

        //   $stmt = $pdo->prepare($sql);
          $stmt->execute(array(
            // ':event_id' => $_POST['event_id'],
            ':eventname' => $_POST['eventname'],
            ':eventdate' => $_POST['eventdate'],
            ':eventnote' => $_POST['eventnote']));
            $_SESSION["success"] = "Record added";
            //   $_SESSION["message"] = "Event added"; 
              error_log("Event added.", 0);
              header("Location: view.php");
              return;
    }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wolf Lake's Add An Event Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">


</head>
<body>

<div class="container">

    <h1>Wolf Lake's Add An Event Page</h1>
    <br>
    <form method="post">
        <p>Event Name: &nbsp; &nbsp; 
        <input type="text" name="eventname" size="30" value="<?=htmlentities('');?>"></p>
        <p>Event Date: &nbsp; 
      
        <input type="datetime" name="eventdate"  id="datetime" size="30" value="<?=htmlentities('');?>"></p>
        
        <p>Additional Notes: &nbsp; &nbsp; &nbsp; 
        <input type="text" name="eventnote" value="<?=htmlentities('');?>"></p>
        
        <p><input type="submit" value="Add New Event"/> &nbsp; &nbsp; &nbsp; 
        
        <!-- <input type="submit" name="cancel" value="Cancel"> &nbsp; &nbsp; &nbsp;  -->
        <input type="submit" name="logout" value="Logout"> 
    </form>
    <a href="index.php">Cancel</a> 
    &nbsp; &nbsp; &nbsp;  | &nbsp; &nbsp; &nbsp;
    <a href="view.php">View Event List</a>



  <br><br>
  <p> Note: The date/time must be entered as <span style='color: red'> 2019-08-30 00:18:00  </span> (YYYY-MM-DD HH-MM-SS). Don't forget entering "00" for seconds. </p>

</div>
</body>
</html>