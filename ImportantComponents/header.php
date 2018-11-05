<?php
require_once 'utilities/database_setup.php';
require_once 'utilities/cookieAndsession.php';

$loggedin = false;
$_SESSION['loggedin'] = false;
if (isset($_SESSION['email'])){
    $loggedin=true;
    $_SESSION['loggedin'] = true;
}
else 
{
    if(isset($_COOKIE['autologinEmail']) && isset($_COOKIE['autologinVerify'])){
        $email = $_COOKIE['autologinEmail'];
        $cookieVerify = $_COOKIE['autologinVerify'];
        
        $query = "SELECT * FROM User WHERE email=?";
        $stmt = $eepdo->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute(array($email));
        $user = $stmt->fetch();
        $hashedpass = $user['password'];
        
        if (CanUserAutoLogin($email, $hashedpass, $cookieVerify)){
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $email;
            $loggedin=true;
            $_SESSION['loggedin'] = true;
        }
        else
        {
            $loggedin=false;
            $_SESSION['loggedin'] = false;
        }
        
        
        
    }
    else
    {
       $loggedin = false;
       $_SESSION['loggedin'] = false;
    }
}

echo <<<_END

<!DOCTYPE html>
<html>
    <head>
_END;

if(isset($_GET['id']))
{
    $postID=$_GET['id'];
    $query = "SELECT * FROM Posts WHERE post_ID=?";
    $stmt = $eepdo->prepare($query);
    $stmt->execute(array($postID));
    $postContent = $stmt->fetch();
    $title = $postContent['title'];

}
else
{
    $title = "Explorer Earth";
}
echo "<title>" . $title . "</title>";

if ($loggedin){
    include 'html/headerloggedin.html';
}
if (!$loggedin){
    include 'html/headerNOTloggedin.html';
}

?>

