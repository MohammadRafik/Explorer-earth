<?php

require_once 'utilities/database_setup.php';
//    $emailaddress = $_POST['emailaddress'];
//    $fullname = $_POST['fullname'];
//    $username = $_POST['username'];
//    $password1 = $_POST['pass'];
//    $password2 = $_POST['pass2'];

if (!empty($_POST['emailaddress'])){
    $emailaddress = $_POST['emailaddress'];
    
     // check if email is valid
    if (filter_var($emailaddress, FILTER_VALIDATE_EMAIL)){

            $stmt = $eepdo->prepare("SELECT * FROM user WHERE email=?");
            $stmt->execute(array($emailaddress));
            $checkIfEmailTaken = $stmt->rowCount();
            if (!checkIfEmailTaken){
                //email not taken
                $emailstatus = true;
            }
            else {
                //email taken
                $emailstatus = false;
                
            }
    }
    else {
        //email not valid
        $emailstatus = false;
    }

    
}
?>
<script>
    

</script>
    
    