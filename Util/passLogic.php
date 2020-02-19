<?php
require "dbconn.php";
session_start();
if(!isset($_GET['psswd']) || !isset($_GET['new_psswd'])) {
$_SESSION["error_pssd"] = "Fill in the Form";
header("Location:new_password.php?token=".$_GET["tokenValue"]);
exit();

}else
{
    $message="Did not update password try again";
    //might need some revising
    $token = $_GET["tokenValue"];
    $passGood=true;
    $pass=$_GET["psswd"];
    $confirm_pass=$_GET["new_psswd"];
    if(strlen($pass) > 35 || strlen($pass) < 8)
    {
        $passGood=false;
        $_SESSION["error_pssd"] = "The password length must be betwwen 8 to 35";
    }
    if(!(preg_match('/^[a-zA-Z0-9_.%^&*$#@!()=+-]*$/',$pass)))
    {
        $passGood=false;
        $_SESSION["error_pssd"] = "The password must contain a Capital Letter,numbers and invalid characters";
    }

    if(strcmp($pass,$confirm_pass) !== 0)
    {
        //password doesn't match
        $passGood=false;
        $_SESSION["error_pssd"] = "The passwords do not match";
    }

    if($passGood) {

        $sql = "SELECT reset_email,reset_isActive FROM reset_password WHERE reset_token ='$token'";
        $res=$conn->query($sql);

            $email = '';
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    if ($row['reset_isActive']) {
                        $email = $row['reset_email'];
                    }
                }
            }
            //reset_password TABLE WILL ALSO NEED A is_active field
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $sql2 = 'UPDATE user SET user_password = "' . $hash . '" WHERE user_email = "' . $email . '"';

            if($conn->query($sql2))
            {
                //now set reset_isActive to 0, so the user can't repeatedly reset password
                $sql3 = 'UPDATE reset_password SET reset_isActive = 0 WHERE reset_email = "' . $email . '"';
                if($conn->query($sql3))
                {
                    $message="The Password has been updated";
                    $_SESSION["reset_pwd_message"] = $message;
                   header("Location:../View/index.php?");
                   exit();
                }
                else
                {
                    echo $conn->error."1";
                }
            }else
            {
                echo $conn->error."1";
            }
    }
}
$_SESSION["reset_pwd_message"] = $message;
header("Location:new_password.php?token=".$_GET["tokenValue"]);
exit();