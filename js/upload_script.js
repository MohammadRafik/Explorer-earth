$(document).ready(function()
{

 $("#drop-area").on('dragenter', function (e){
  e.preventDefault();
  $(this).css('background', '#BBD5B8');
 });

 $("#drop-area").on('dragover', function (e){
  e.preventDefault();
  $(this).css('background','light-green');
 });



 $("#drop-area").on('drop', function (e){
    e.preventDefault();
     $(this).css('background', 'white');
     $(this).css('border-color', 'white');
     $('#input-file').remove();
     var image = e.originalEvent.dataTransfer.files;
     createFormData(image);
 });
$("#drop-area").on('dragleave', function(){
    $(this).css('background', 'white');
});


});


function createFormData(image)
{

 var formImage = new FormData();
 formImage.append('userImage', image[0]);
 uploadFormData(formImage);
}

function uploadFormData(formData) 
{
 $.ajax({
 url: "functions/upload_image.php",
 type: "POST",
 data: formData,
 contentType:false,
 cache: false,
 processData: false,
 success: function(data){

  $("#drop-area").html(data);
 }
});
}