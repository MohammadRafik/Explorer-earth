<?php

require_once 'utilities/database_setup.php';
require_once 'utilities/cookieAndsession.php';

$errorMessageLogin = "";
if ($_POST['emailaddress'] != '' && $_POST['pass'] != ''){
    $email = $_POST['emailaddress'];
    $pass = $_POST['pass'];
    //fetch email
    $query = "SELECT * FROM User WHERE email=?";
    $stmt = $eepdo->prepare($query);
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'user');
    $stmt->execute(array($email));
    $user = $stmt->fetch();
    if ($user)
    {
        
        if (password_verify($pass, $user['password'])){
            echo '<p><font color="green">Login Successful</font></p>';
            //user is now logged in, take him to the home page for a logged in user
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $email;
            $_SESSION['hashedStringParts'] = setUpCookieForAutoLogin($email, $user['password']);
            echo '<script type="text/javascript">location.href = "index.php";</script>';
        }
        else {
            $errorMessageLogin = "Incorrect email or password";
        }
    }
    else {
        $errorMessageLogin = "Incorrect email or password";
    }
}  
else {
    $errorMessageLogin = "You must enter in your email address and password to login";
}

echo "<p><font color='red'>" . $errorMessageLogin . "</font></p>";