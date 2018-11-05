<?php
require_once '../utilities/database_setup.php';
require_once '../utilities/cookieAndsession.php';

    //Stores the filename as it was on the client computer.
    $imagename = $_FILES['file']['name'];
    //Stores the tempname as it is given by the host when uploaded.
    $imagetmp = $_FILES['file']['tmp_name'];
    //userid
    $userID = $_SESSION['user']['user_ID'];

    if($ActualImage = file_get_contents($imagetmp))
    {
        if(exif_imagetype($imagetmp)){

            //upload image into database
            $query = "INSERT INTO ProfileImages(creator_ID,image,imageDescription) VALUES (?,?,?)";
            $stmt = $eepdo->prepare($query);
            $DidItSave = $stmt->execute(array($userID,$ActualImage,$imagename));

            //refresh page so profile picture is updated
            echo "<script>window.location.reload()</script>";
            
        }
        else {
            echo "error, the uploaded file is not an image";
        }
    }
    else{
        echo "error, cant access the image";
    }


?>