<?php
// register.php:
require_once('Bcrypt.php'); 

$bcrypt = new Bcrypt(15);
$hash = $bcrypt->hash('$pass1');

//********Insert all the members's input to the database**************//
$query = mysql_query("INSERT INTO members
                      (user_name, first_name, last_name,
                       governorate, district, village,
                       birth_date, email_address,
                       specialization, password, registered_date)
                      VALUES
                      ('$username', '$firstname', '$lastname',
                       '$governorate', '$district', '$village',
                       '$bdate', '$email', '$specialization',
                       ' $hash',  now())")
                      or die("could not insert data");


$bcrypt = new Bcrypt(12);

$email = $_POST['email']; //from login email field
$pass_l = $_POST['password']; // from login password field
$hash_1= $bcrypt->hash($pass_1);

$chk_email= $dbh->prepare("SELECT password FROM table WHERE email = ?");
$chk_email -> execute(array($email));

while($row = $chk_email->fetch(PDO::FETCH_ASSOC)){
    $chk_pass = $row['password']; //inside a while loop to get the password
    $pass_isGood = $bcrypt->verify($pass_l, $chk_pass); //notice how 1st parameter of verify(is the text input and not its hashed form
    var_dump($pass_isGood); 

}

?>