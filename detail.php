
<?php
include 'ImportantComponents/header.php';
?>
<script>
$(document).ready(function(){
    $('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
    });
//
    $("form").submit(function(event){
        event.preventDefault();
        var comment = $("#comment").val();
        var postID = "<?php echo $_GET['id'] ?>";
        $(".form-message").load("php/uploadComment.php?", {
            comment: comment,
            postID: postID
        });
    });

});
</script>


<?php
$postID=$_GET['id'];
$query = "SELECT * FROM Posts WHERE post_ID=?";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($postID));
$postContent = $stmt->fetch();

//make tab title the title of the post

//post title and content of the post
echo "<br><br><br><div class='postDiv'>";
echo "<h1>" . $postContent['title']. "</h1>";
echo "<br>";
echo $postContent['content'];
echo "</div>";

//comment section
echo "<br><br>";
if($loggedin){
    include "php/addAcomment.php";
}
else{
    echo "<a href='login.html'> Log in</a> to write a comment";
}

echo "<h3>Comments</h3>";

$query = "SELECT * FROM comments WHERE post_ID=? ORDER BY comment_ID DESC";
$stmt = $eepdo->prepare($query);
$stmt->execute(array($postID));

$numOfComments = 10;
for($i=0;$i<$numOfComments;$i++)
{
$comment = $stmt->fetch();
$userID_ofCommentor = $comment['user_ID'];
//get profile image of this commentor
$query2 = "SELECT * FROM ProfileImages WHERE creator_ID=? ORDER BY id DESC";
$stmt2= $eepdo->prepare($query2);
$stmt2->execute(array($userID_ofCommentor));

//get name of user... lol
$query3 = "SELECT * FROM User WHERE user_ID=?";
$stmt3 = $eepdo->prepare($query3);
$stmt3->execute(array($userID_ofCommentor));
$user = $stmt3->fetch();

//here is the image and the comment both ready for display :D
$image = $stmt2->fetch();
$ActualComment = $comment['comment'];
$userName = $user['displayed_name'];

echo '<table id="makeAcommentTable">';
echo     '<tr>';
        echo '<td id="td_comment_image">';

            if($image){
                echo '<img id="imgFileUpload4comments" alt="Select File" title="Select File" src="data:image/jpeg;base64,'
                .base64_encode($image['image']).'" width="80" height="80" />';
             }
             else{
                echo '<img id="imgFileUpload4comments" alt="Select File" title="Select File" src="images/default_profile_img.png" width="80" height="80" />';
             }

        echo '</td>';
        echo '<td id="td_comment_textarea">';
             echo "<div id='boldText'>" .$userName . "</div><br>";
             echo $ActualComment;
        echo '</td>';

echo '</table>';




    
}


include 'ImportantComponents/footer.php';

?>