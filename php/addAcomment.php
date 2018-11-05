
<h3>Add a comment</h3>

<!-- get user id and display name and profile image -->
<?php
$userID = $_SESSION['user']['user_ID'];
$displayName = $_SESSION['user']['displayed_name'];

$query = "SELECT * FROM ProfileImages WHERE creator_ID=? ORDER BY id DESC";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($userID));
$image = $stmt->fetch();
?>

<!-- setup textarea for making comments -->



<table id="makeAcommentTable">
    <tr>
        <td id="td_comment_image">
            <?php 
            if($image){
                echo '<img id="imgFileUpload4comments" alt="Select File" title="Select File" src="data:image/jpeg;base64,'
                .base64_encode($image['image']).'" width="80" height="80" />';
             }
             else{
                echo '<img id="imgFileUpload4comments" alt="Select File" title="Select File" src="images/default_profile_img.png" width="80" height="80" />';
             }
              ?>
        </td>
        <td id="td_comment_textarea">
             <form action="php/uploadComment.php" method="POST">
            <textarea placeholder="Type in your comment here" id="comment"></textarea><br>
            <button id="commentSubmit">Add Comment</button>
            <p class="form-message"></p>
            </form>
        </td>

    </table>
