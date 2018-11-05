<?php

include '../utilities/database_setup.php';
require_once '../utilities/cookieAndsession.php';


if(is_array($_FILES)) 
{
    $imagename=$_FILES['userImage']['name'];
    $imagetmp=$_FILES['userImage']['tmp_name'];
    $postID = $_SESSION['postID'];



    //resizing image
        if($_FILES['userImage']['size'] > 100000){
        $destination_img = 'destination .jpg';
        $d = compress($imagetmp, $destination_img, 20);
        }
        else{
            $d = $imagetmp;
        }

        if($d != ""){
        if($ActualImage = file_get_contents($d))
        {
            if(exif_imagetype($imagetmp))
            {

                $sqlquery = "INSERT INTO Images(creator_ID,post_ID,image_name,image,imageDescription) values (?,?,?,?,?)";
                $stmt = $eepdo->prepare($sqlquery);
                $didImageUploadWork = $stmt->execute(array($_SESSION['user']['user_ID'],$postID,$imagename,$ActualImage,'description'));
                
                
                $queryGetPicture = "SELECT * FROM Images WHERE image_name = ?";
                $stmt2 = $eepdo->prepare($queryGetPicture);
                $stmt2->execute(array($imagename));
                $image=$stmt2->fetch();
                echo '<img src="data:image/jpeg;base64,' .base64_encode($image['image']).'"/>';
                

            }
        else {
            echo "thats not an image";
        }
    }
    else {
        echo "error, cant access the image....";
    }
}
else{
    echo "image is too big";
}
 
}

function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}
    
    