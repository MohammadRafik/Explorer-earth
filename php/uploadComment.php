<?php

require_once '../utilities/database_setup.php';
require_once '../utilities/cookieAndsession.php';

$comment = $_POST['comment'];
$userID = $_SESSION['user']['user_ID'];
$postID = $_POST['postID'];
//save comment into database of comments
$query = "INSERT INTO comments(post_ID,user_ID,comment) VALUES(?,?,?)";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($postID,$userID,$comment));


echo '<script type="text/javascript">document.location.reload(true);</script>';
