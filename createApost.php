<?php

include 'ImportantComponents/header.php';

if ($loggedin)
{
    
    include 'html/createApost.php';
}
else {
    echo "<br>You must be logged in to create a post";
}

include 'ImportantComponents/footer.php';



