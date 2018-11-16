<?php
require_once '../utilities/database_setup.php';
require_once '../utilities/cookieAndsession.php';

$title = $_POST['title'];
$content = $_POST['content'];
$creatorID = $_SESSION['user']['user_ID'];

$queryGetPicture = "SELECT * FROM Images WHERE post_ID = ?";
$stmt2 = $eepdo->prepare($queryGetPicture);
$stmt2->execute(array($_SESSION['postID']));
$image=$stmt2->fetch();
// $Timage =$image['image'];


if (!empty($title) && !empty($content) && !empty($image)){
//find latest post so we can update it
$query = "SELECT post_ID FROM Posts WHERE creator_ID=?";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($creatorID));
$sortArray=[];
$i=0;
while($ranQuery = $stmt->fetch()){
    $sortArray[$i++] = $ranQuery['post_ID'];
}
rsort($sortArray);
$postID = $sortArray[0];

//update latest post with the content
$query = "UPDATE Posts SET title=?, content=? WHERE post_ID=?";
$stmt = $eepdo->prepare($query);
if (!$stmt->execute(array($title,$content,$postID))) {
    print_r($stmt->errorInfo());
}
echo '<script type="text/javascript">location.href = "index.php";</script>';
}
else {
    echo '<br><br><p><font color="red">You must fill in all 3 sections to create the post (title, content, and thumbnail Image)</font></p>';
}

