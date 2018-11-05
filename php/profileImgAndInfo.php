<?php
require_once 'utilities/database_setup.php';
require_once 'utilities/cookieAndsession.php';

// 
$userID = $_SESSION['user']['user_ID'];
$displayName = $_SESSION['user']['displayed_name'];
$followernsumber=0;
$influenceNumber=0;

//get number of posts
$query = "SELECT COUNT(creator_ID) FROM Posts WHERE creator_ID=?";
$stmt=$eepdo->prepare($query); $stmt->execute(array($userID));$countTotal = $stmt->fetch();
$postsNumber= $countTotal[0];




$query = "SELECT * FROM ProfileImages WHERE creator_ID=? ORDER BY id DESC";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($userID));
//if there is an image for this profile
if($image = $stmt->fetch())
{
    echo "<table id='table_TWO'><tr><td id='td1'>";
    echo '<img id="imgFileUpload" alt="Select File" title="Select File" src="data:image/jpeg;base64,' .base64_encode($image['image']).'" style="cursor: pointer" width="125" height="140" />';
    echo '<br />';
    echo '<span id="spnFilePath"></span>';
    echo '<input type="file" id="FileUpload1" style="display: none" />';
    echo "<td id='td2'><br><p id='displayName'> " .$displayName . "</p>";
    echo "<br><br>" . $postsNumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Posts</p>";
    echo "<br>" . $influenceNumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Influence</p>";
    echo "<br>" . $followernsumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Followers</p>";
    echo "</td></tr></table>";
}

//if there is not an image for this profile
else
{
    echo "<table id='table_TWO'><tr><td id='td1'>";
    echo '<img id="imgFileUpload" alt="Select File" title="Select File" src="images/default_profile_img.png" style="cursor: pointer" width="125" height="140" />';
    echo '<br />';
    echo '<span id="spnFilePath"></span>';
    echo '<input type="file" id="FileUpload1" style="display: none" />';
    echo "<td id='td2'><br><p id='displayName'> " .$displayName . "</p>";
    echo "<br><br>" . $postsNumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Posts</p>";
    echo "<br>" . $influenceNumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Influence</p>";
    echo "<br>" . $followernsumber . "<p id='displayName2'>&nbsp;&nbsp;&nbsp;&nbsp;    Followers</p>";
    echo "</td></tr></table>";
}













?>