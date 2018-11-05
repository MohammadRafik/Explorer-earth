<?php
include 'ImportantComponents/header.php';
?>


<body>
<div id="profile">
<!-- this is where the profile image is and those numbers for the user -->
    <?php 
    $userID = $_GET['id'];
    //get user's Name
    $query11 = "SELECT * FROM User WHERE user_ID=?";
    $stmt11= $eepdo->prepare($query11);
    $stmt11->execute(array($userID));
    $userInfo = $stmt11->fetch();
    $displayName = $userInfo['displayed_name'];
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
        echo '<img id="imgFileUpload" alt="Select File" title="Select File" src="data:image/jpeg;base64,' .base64_encode($image['image']).'" width="125" height="140" />';
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
        echo '<img id="imgFileUpload" alt="Select File" title="Select File" src="images/default_profile_img.png" width="125" height="140" />';
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


</div>



<table id="table_one" align="center">
    <tr>
        <?php


        $query = "SELECT * FROM Posts WHERE creator_ID=? ORDER BY post_ID DESC";
        $stmt = $eepdo->prepare($query);
        $stmt->execute(array($_GET['id']));
        
        
        
        
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
                    </td>';
                    
                }
                //third coloumn
                else
                {
                    //a thumbnail image exists
                    echo '<td>
                    <a href="detail.php?id='.$post['post_ID'].'">
                    <img width="230px" height="150px" class="imgprofiles" src="data:image/jpeg;base64,' .base64_encode($image['image']).'"/>
                    </a>
                    <br>
                    <a id="abc" style="clear: both;"y href="detail.php?id='.$post['post_ID'].'">'.$post['title'].'</a>
                    </td></tr><tr>';
                }
        
            }
        
        }
        else
        {
            echo "<br><p>This user does not have any posts</p>";
        }
        ?>
</table>
		    





<?php
include 'ImportantComponents/footer.php';