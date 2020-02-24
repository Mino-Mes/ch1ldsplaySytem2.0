<?php
session_start();
require("../PHPMailer/PHPMailer.php");
require("../PHPMailer/SMTP.php");
require("../PHPMailer/Exception.php");
require("dbconn.php");

$_SESSION['reg_attempt'] = false;
$_SESSION['log_attempt'] = false;
$_SESSION['recover_attempt'] = true;


$err = false;

function sendEmail($to,$subject,$msg,$headers)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPDebug = false;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "meslevrai@gmail.com";
    $mail->Password = "sasuke12345";
    try {
        $mail->AddAddress("$to");
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
    try {
        $mail->SetFrom("meslevrai@gmail.com");
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
    $mail->Subject = $subject." from Ch1ldsplayMediaProduction.com";
    $mail->Body = "<strong>Subject</strong> <br>".$msg ."<br>".$headers;

    try {
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else { return true;}
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
}
//works
//echo $_POST['recover_email'];

//now match email to db
$sql = 'SELECT user_email FROM user';

$res = $conn->query($sql) or die ('ERROR: Database Error');

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        if(strcmp(strtolower($row['user_email']),strtolower(trim($_POST["recover_email"]))) !=0){
            //this email does not match one in the db
            $err = true;
            break;
        }
    }
}
    if($err){
    //if no error, send the recovery email
    $token = bin2hex(random_bytes(50));

    $email=$_POST["recover_email"];
    //store token in password_reset table
    $sql = "INSERT INTO reset_password(reset_id,reset_email, reset_token) VALUES (DEFAULT,'$email', '$token')";

   if($conn->query($sql))
   {
       $to = $_POST["recover_email"];
       $subject = "Reset your password on Ch1ldsplay Media Production";
       $msg = "Hello, please click on this <a href='new_password.php?token=$token'>link</a> to reset your password on our site";
       $msh = wordwrap($msg,70);
       //change this depending on the site's domain
       $headers = 'From: Ch1ldsplay Media Production';
       if (sendEmail($to,$subject,$msh,$headers))
       {
           $_SESSION["message"]= "The email was sent";
       }else{
           $_SESSION["message"]= "The email was not sent";
       }
   }else
   {
        echo "Error :".$conn->error;
   }
   header("Location:../View/index.php");
   exit();
}



