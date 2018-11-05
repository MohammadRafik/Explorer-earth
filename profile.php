<?php
include 'ImportantComponents/header.php';
if (!$loggedin){
    echo "<br><br><p>You must be logged in to view your profile</p>";
}
else{
    include "html/loggedIn.php";
}


include 'ImportantComponents/footer.php';