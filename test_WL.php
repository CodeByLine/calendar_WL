<?php

//passwords for WL calendar access

// $newpass = password_hash("Jeopardy19!", PASSWORD_DEFAULT);

// $newpass = password_hash("Jeopardy2019!", PASSWORD_DEFAULT);


// ???!     //PASSWORD_DEFAULT  //user
$new3 = password_hash("php123!", PASSWORD_DEFAULT);


//Foreverwild!     //PASSWORD_DEFAULT  //Mike
// $new3 = password_hash("ForeverWild!", PASSWORD_DEFAULT);
//$2y$10$TAwCaetVsk.ibtZ1ROx4yuVYB6DpcezQeoOpMA.2Eo9wy.VbE5HQ2 

//Jeopardy2019!     //PASSWORD_DEFAULT  //Kevin
// $new3 = password_hash("Jeopardy2019!", PASSWORD_DEFAULT);

//$2y$10$1zKTJxuTwdK3bQDLbtzQAeRl109Tgmnba1Ls5JA8euoofcZ64KsJm 
echo $new3; 


//Jeopardy19!      //PASSWORD_DEFAULT  //Nam
// $2y$10$xk5ilHB9cuoZXyB7bLf26.j1U9r6njriiXeamFdysJIsw8xeTDpSq    
// echo $newpass; 


echo "\n";

$new2 = hash('sha512',"Jeopardy19!");
echo $new2;
//Jeopardy19!  
//  9c6012b387206f9318161dcc76aafa88f93b9d9fdc78d7c5e85d5095346db7609a51383a70afdcdcf0c9b47b8b335e47774406b439f13089f473ebecfe84b18b


echo "\n";

	


    $username = 'nam';
    $password = 'Jeopardy19!';
    $staticsalt = 'wcRwGxDzULe?';

    $salt = hash('sha256', uniqid(mt_rand(), true) .$staticsalt.strtolower($username));

    $hash = $salt . $password;
    for ( $i = 0; $i < 100000; $i ++ ) 
    {
    $hash = hash('sha256', $hash);
    }
    $hash = $salt . $hash;

    echo "\n";
    echo 'Salt: ' . PHP_EOL . $salt;
   

    echo "\n";
    echo PHP_EOL.PHP_EOL;
    echo "\n";
    echo 'Hash: ' . PHP_EOL . $hash ;




?>