<?php

echo '<table id="table_one" align="center">';
echo     '<tr>';


require_once "../utilities/cookieAndsession.php";
require_once "../utilities/database_setup.php";



$query = "SELECT * FROM Posts ORDER BY post_ID DESC";
$stmt = $eepdo->prepare($query);
$stmt->execute(array());




if($stmt->rowCount()>0){
    $counter = 0;
    while ($post = $stmt->fetch())
    {

        //get thumbnail image of post
        $query2 = "SELECT * FROM Images WHERE post_ID =?";
        $stmt2=$eepdo->prepare($query2);
        $stmt2->execute(array($post['post_ID']));
        $image = $stmt2->fetch();

        if(empty($post['title']) || empty($post['content']) || empty($image['image'])){
            continue;
        }

        $counter++;
        if($counter%3 != 0)
        {
            //get name of person who created this post
            $query3 = "SELECT * FROM User WHERE user_ID=?";
            $stmt3 = $eepdo->prepare($query3);
            $stmt3->execute(array($post['creator_ID']));
            $postuser = $stmt3->fetch();
            $PostCreatorName = $postuser['displayed_name'];
            
            //a thumbnail image exists
            echo '<td>
            <a href="detail.php?id='.$post['post_ID'].'">
            <img width="230px" height="150px" class="imgprofiles" src="data:image/jpeg;base64,' .base64_encode($image['image']).'"/>
            </a>
            <br>
            <a id="abc" style="clear: both;" href="detail.php?id='.$post['post_ID'].'">'.$post['title'].'</a>
            <br><a id="abcCreator" style="clear:both;" href="UserProfile.php?id=' . $postuser['user_ID']. '">By ' .$PostCreatorName.'</a>
            </td>';
            
        }
        //third coloumn
        else
        {

            //get name of person who created this post
            $query3 = "SELECT * FROM User WHERE user_ID=?";
            $stmt3 = $eepdo->prepare($query3);
            $stmt3->execute(array($post['creator_ID']));
            $postuser = $stmt3->fetch();
            $PostCreatorName = $postuser['displayed_name'];


            //a thumbnail image exists
            echo '<td>
            <a href="detail.php?id='.$post['post_ID'].'">
            <img width="230px" height="150px" class="imgprofiles" src="data:image/jpeg;base64,' .base64_encode($image['image']).'"/>
            </a>
            <br>
            <a id="abc" style="clear: both;"y href="detail.php?id='.$post['post_ID'].'">'.$post['title'].'</a>
            <br><a id="abcCreator" style="clear:both;" href="UserProfile.php?id=' . $postuser['user_ID']. '">By ' .$PostCreatorName.'</a>
            </td></tr><tr>';
        }

    }

}
else
{
    echo "<br><p>This user does not have any posts</p>";
}



echo '</table>';
