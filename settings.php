
<script src="js/jquery.min.js" ></script>
<script>
$(document).ready(function(){
    $("form").submit(function(event){
        event.preventDefault();
        //this code ABSOLUTLY MURDERS whats on the cookie in the computer itself
        document.cookie = 'autologinEmail' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.cookie = 'autologinVerify' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        $(".form-logout").load("functions/logout.php");
        location.href = "index.php";
    });
});
</script>

<?php 
include 'ImportantComponents/header.php';
// things i need to add:
// 1.change password
// 2.change displayed name?
// 3.change email address?

?>

<br><br><br><br>
<form action="functions/logout.php" method="POST">
    <button id="logoutbutton" type="submit" name="submit">Log out</button>
    <p class="form-logout"></p>
</form>


<?php
include 'ImportantComponents/footer.php';

?>