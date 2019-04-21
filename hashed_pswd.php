

<?php 
    try {
    $stmt = $dbh->prepare("SELECT login, password FROM users");
    $stmt->execute();
    while ( $row = $stmt->fetch() ) {
    $login_in_data = $row['login'];
    $password_in_data = $row['password'];
    $name_in_data = $row['name'];
    }
    } 
    catch (exeption $e) {            
    echo $e->getMessage();
    }
    // This code loops through all your users table, saving only the last row of your data. Don'\''t know why you'\''ll need this.

    if ( isset($login) && isset($password) ) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("SELECT * FROM users WHERE (`login`, `password`) = (:login, :hashed_password)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':hashed_password', $hashed_password);
    $row = $stmt->fetch();
    $stmt->execute();
    }
    // This code hash the password and then query the database for a matching username and hash, but password_hash() outputs a different hash every time it'\''s called (see PHP documentation). Also, you'\''re not using the $row you'\''re fetching.

    // Finally, it'\''s not a good idea to store password in both the session and the cookie.

    // The easy way to do a user authentication is :

    // Querying the database for a user matching username 
    (SELECT * from
    users WHERE login = :login)
    // See if the provided password match the database username hash with password verify 
    (password_verify($_POST[$password], $row->password))


    ?>