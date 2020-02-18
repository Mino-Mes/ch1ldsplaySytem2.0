<?php
session_start();
require("../PHPMailer/PHPMailer.php");
require("../PHPMailer/SMTP.php");
require("../PHPMailer/Exception.php");
require("dbconn.php");

$_SESSION['reg_attempt'] = false;
$_SESSION['log_attempt'] = false;
$_SESSION['recover_attempt'] = true;

$email = $_POST['recover_email'];

$err = false;

//works
//echo $_POST['recover_email'];

//now match email to db
$sql = 'SELECT user_email FROM user';

$res = $conn->query($sql) or die ('ERROR: Database Error');

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        if(strcmp(strtolower($row['user_email']),strtolower(trim($email))) !=0){
            //this email does not match one in the db
            $err = true;
        }
    }
}

if(!$err){
    //if no error, send the recovery email
    $token = bin2hex(random_bytes(50));

    //store token in password_reset table
    $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
    $res = $conn->query($sql) or die ('ERROR: Database Error');

    $to = $email;
    $subject = "Reset your password on Ch1ldsplay Media Production";
    $msg = "Hello, please click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    $msh = wordwrap($msg,70);
    //change this depending on the site's domain
    $headers = 'From: Ch1ldsplay Media Production';
    mail($to,$subject,$msg,$headers);
    header('location: ../View/index.php');
}
else{
    $_SESSION['recover_msg'] = 'Error: we could not find your email address!';
    $_SESSION['recover_err'] = true;
    $_SESSION['recover_email'] = $_POST['recover_email'];
    header('Location: ../View/Index.php');
}


?>

