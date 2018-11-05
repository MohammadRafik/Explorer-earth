</body>

<head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script>
    $(function () {
        var fileupload = $("#FileUpload1");
        var image = $("#imgFileUpload");
        image.click(function () {
            fileupload.click();
        });
        fileupload.change(function () {
            var file_data = $('#FileUpload1').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            $.ajax({
                url: "functions/updateProfileImage.php",
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    $("#imgFileUpload").html(data);
                }
            });

        });
    });

    </script>
</head>

<body>
<div id="profile">
<!-- this is where the profile image is and those numbers for the user -->
    <?php include "php/profileImgAndInfo.php"; ?>


</div>



<table id="table_one" align="center">
    <tr>
        <?php include "functions/view.php"; ?>
</table>
		    

