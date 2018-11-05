<?php
require_once '../utilities/database_setup.php';
require_once '../utilities/cookieAndsession.php';

    //Stores the filename as it was on the client computer.
    $imagename = $_FILES['file']['name'];
    //Stores the tempname as it is given by the host when uploaded.
    $imagetmp = $_FILES['file']['tmp_name'];

    $postID = $_SESSION['postID'];

    //resizing image
    if($_FILES['file']['size'] > 100000){
    $destination_img = 'destination .jpg';
    $d = compress($imagetmp, $destination_img, 20);
    }
    else{
        $d = $imagetmp;
    }
    if($d != ""){
    if($ActualImage = file_get_contents($d))
    {
        if(exif_imagetype($imagetmp)){

            //upload image into database
            $sqlquery = "INSERT INTO Images(creator_ID,post_ID,image_name,image,imageDescription) values (?,?,?,?,?)";
            $stmt = $eepdo->prepare($sqlquery);
            $didImageUploadWork = $stmt->execute(array($_SESSION['user']['user_ID'],$postID,$imagename,$ActualImage,'description'));
            
            //post the image into the page
            $queryGetPicture = "SELECT * FROM Images WHERE image_name = ?";
            $stmt2 = $eepdo->prepare($queryGetPicture);
            $stmt2->execute(array($imagename));
            $image=$stmt2->fetch();
            echo '<img src="data:image/jpeg;base64,' .base64_encode($image['image']).'"/>';
            
        }
        else {
            echo "error, the uploaded file is not an image";
        }
    }
    else{
        echo "error, cant access the image";
    }
}
else{
    echo "image is too big m8";
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

?>