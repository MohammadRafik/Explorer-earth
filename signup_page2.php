

<?php
require_once 'utilities/database_setup.php';
require_once 'utilities/cookieAndsession.php';
$errorMessage = '';

//----------check if all the fields have been entered
if (($_POST['emailaddress']) != '' && ($_POST['fullname']) != '' && ($_POST['username']) != '' && ($_POST['pass']) != '' && ($_POST['pass2']) != ''){
    $emailaddress = $_POST['emailaddress'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password1 = $_POST['pass'];
    $password2 = $_POST['pass2'];
    // check if email is valid
    if (filter_var($emailaddress, FILTER_VALIDATE_EMAIL)){
        //check if full name is valid
        if (preg_match('/^[a-zA-Z ]{2,}.*$/', $fullname)){
            // check if username is valid
            if (preg_match('/^[a-zA-Z0-9\_ ]*$/', $username)){
                //check if username is longer than 5 caracters
                if(strlen($username) >= 4){
                    //check if password is longer than 8
                    if(strlen($password1) >= 8){
                        //check if passwords match
                        if( $password1 == $password2 ){
                            //check if email taken
                            $stmt = $eepdo->prepare("SELECT * FROM User WHERE email=?");
                            $stmt->execute(array($emailaddress));
                            $checkIfEmailTaken = $stmt->rowCount();
                            if (!$checkIfEmailTaken){
                                //check if displayed name taken
                                $stmt = $eepdo->prepare("SELECT* FROM User WHERE displayed_name=?");
                                $stmt->execute(array($username));
                                $checkIfUsernameTaken = $stmt->rowCount();
                                if (!$checkIfUsernameTaken){
                                    //insert new user into table user
                                    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);//use password_verify($password, $hashedpassword) to verify pass
                                    $insertQuery = "INSERT INTO User(user_type, email, displayed_name,full_name,password) VALUES(?,?, ?, ?, ?)";
                                    $stmt = $eepdo->prepare($insertQuery);
                                    $checkIfQueryWorked = $stmt->execute(array(1,$emailaddress, $username, $fullname, $hashedPassword));
                                    if ($checkIfQueryWorked){
                                        //user created, take him to the next step in this if statment
                                                $email = $emailaddress;
                                                $query = "SELECT * FROM User WHERE email=?";
                                                $stmt2 = $eepdo->prepare($query);
                                                $stmt2->setFetchMode(PDO::FETCH_CLASS, 'User');
                                                $stmt2->execute(array($email));
                                                $user = $stmt2->fetch();
                                                
                                        $_SESSION['user'] = $user;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['hashedStringParts'] = setUpCookieForAutoLogin($email, $user['password']);
                                        echo '<script type="text/javascript">location.href = "index.php";</script>';
                                        echo '<p><font color="green">Your account has been successfuly created!</font></p>';
                                    }
                                    else {
                                        $errorMessage = "Unable to create user, please contact support for help";
                                    }
                                }
                                else {
                                    $errorMessage = "Someone else is already using that username please try another one";
                                }

                            }
                            else {
                                $errorMessage = "That email address is already being used";
                            }

                        }
                        else {
                            $errorMessage = "The passwords do not match";
                        }
                    }
                    else {
                        $errorMessage = "The password must be 8 characters or longer";
                    }
                }
                else {
                    $errorMessage = "The username must be 4 characters or longer";
                }

            }
            else {
                $errorMessage = "The username can only contain english letters, numbers, space's and the underscore";
            }
        }
        else {
            $errorMessage = 'your name can only contain english letters and must have at least 2 letters in it';
        }
    }
    else {
        $errorMessage = 'That email address is not valid';
    }
}
else {
    $errorMessage = 'You must fill in all the required fields to register';
}
echo "<p><font color='red'>" . $errorMessage . "</font></p>";

