<?php

if(!isset($_SESSION)){
    session_start();
}

//this code kills browser cookie that is on the browser not computer
$name = session_name();
$expire = time()- 60*60*24*365*3;
$params = session_get_cookie_params();
$path = $params['path'];
$domain = $params['domain'];
$secure = $params['secure'];
$httponly = $params['httponly'];
setcookie($name, '', $expire, $path, $domain, $secure, $httponly);

//delete other 2 cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}



//this code kills whats in the session then ends the session
if (isset($_SESSION)){
$_SESSION = array();
session_destroy();
}

echo "You have been logged out of the website (T.T) pls come back!";
echo '<script type="text/javascript">location.href = "index.php";</script>';






