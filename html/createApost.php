



<h2 id='createApost'>Create a post!</h2>
<script>
    $(document).ready(function() {
$('#summernote').summernote({
    height:300,
    minHeight: 150,
    maxHeight: null,
    focus:true
});
$('#pic').change(function(){
        var file_data = $('#pic').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        $.ajax({
            url: "functions/upload_image_fromButton.php",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                $("#drop-area").html(data);
            }
        });
    });

                $("form").submit(function(event){
                    event.preventDefault();
                    var title = $("#-title").val();
                    var content = $("#summernote").val();
                    $(".form-message").load("php/savepostcontent.php", {
                       title: title,
                       Content: content
                    });
                });


});
</script>

<?php 
    require_once "utilities/cookieAndsession.php";
    //create empty post
    $query = "INSERT INTO Posts(creator_ID) VALUES(?)";
    $stmt = $eepdo->prepare($query);
    $diditsave = $stmt->execute(array($_SESSION['user']['user_ID']));


    $creatorID = $_SESSION['user']['user_ID'];

    //find latest post so we can
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
    //give post id to session so we can use it
    $_SESSION['postID'] = $postID;


?>

<form method="post" action="php/savepostcontent.php">
        
    <b>Title</b>
    <input id="-title" type="text" class="form-control" name="title" autocomplete="off"><br>
    <b>Content</b>
    <textarea id="summernote" name="Content"></textarea>

    <b>Thumbnail Image<br></b>
    <p>Note that this image will show up with the title of ur post to new visitors of the website</p>
    <link href='css/upload_style.css?version=1' rel='stylesheet'>
    <script type='text/javascript' src='js/upload_script.js'></script>
    <div id='wrapper'>
        <div id='drop-area'>
            <h3 class='drop-text'>Drag and drop your Thumbnail Image here</h3><input type='file' name="pic" id="pic">

        </div>
    </div>

    <p class="form-message"></p>
    <br><button type="submit">Submit</button>
</form>

