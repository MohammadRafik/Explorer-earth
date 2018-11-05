<?php

if(!isset($_SESSION)) {
    $lifetime = 60*60*24*365/2;
    session_set_cookie_params($lifetime);
    session_start();
} 


function setUpCookieForAutoLogin($email, $pass){
    $part1 = substr($pass, 1,4);
    $part2 = $email;
    $part3 = substr($pass,-2,2);
    $addStringParts = $part1.$part2.$part3;
    $hashedStringParts = password_hash($addStringParts, PASSWORD_DEFAULT);//use password_verify($password, $hashedpassword) to verify pass
    setcookie('autologinEmail', $email, time()+(60*60*24*7*26));
    setcookie('autologinVerify', $hashedStringParts, time()+(60*60*24*7*26));
    return array($addStringParts,$hashedStringParts);
}

function endAutoLoginCookie($email, $hashedStringParts){
    setcookie('autologinEmail', $email, time()-(60*60*24*7*26*2), '/');
    setcookie('autologinVerify', $hashedStringParts, time()-(60*60*24*7*26*2), '/');
}

 function CanUserAutoLogin($email,$pass,$hashedparts){
    $part1 = substr($pass, 1,4);
    $part2 = $email;
    $part3 = substr($pass,-2,2);
    $addStringParts = $part1.$part2.$part3;
    return password_verify($addStringParts,$hashedparts);
     
 }