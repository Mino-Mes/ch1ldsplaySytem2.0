<?php
require("../PHPMailer/PHPMailer.php");
require("../PHPMailer/SMTP.php");
require("../PHPMailer/Exception.php");


function IsInjected($str)
{
    $injections = array('(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
    );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if(preg_match($inject,$str))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function sendEmail($fname,$lname,$email,$subject,$body)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "meslevrai@gmail.com";
    $mail->Password = "sasuke12345";
    try {
        $mail->AddAddress("aladdinemes@gmail.com");
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
    try {
        $mail->SetFrom("meslevrai@gmail.com");
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
    $mail->Subject = $subject." from ".$fname;
    $mail->Body = "<strong>Sender</strong> ".$fname." ".$lname."<br> <strong>Email Address</strong> ".$email."<br> <strong>Subject</strong> <br>".$body;

    try {
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {}
    } catch (\PHPMailer\PHPMailer\Exception $e) {}
}

 //Send an Email to chi1dsplayphotoshoot@gmail.com
    if (isset($_POST)) {

        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $email = $_POST['email'];
        $service = $_POST['service'];
        $description = $_POST['description'];
        $availabilities = $_POST['avail'];

        $verified_first_name = false;
        $verified_last_name = false;
        $verified_email = false;
        $verified_service = false;
        $verified_description = false;
        $verified_availabilities = false;

        if (empty($first_name) || is_numeric($first_name) || empty($last_name) || is_numeric($last_name)) {
            //Error message the first name and last name field cannot be empty or be a numeric value.
            $verified_first_name = true;
            $verified_last_name = true;

            $message = "Please, the First Name and Last Name field must be filled and can not be numeric values";
        }

        if (empty($email)) {
            //Error the email is not valid.
            $verified_email = true;
            $message = "Invalid Email";
        }
        if (empty($description) || is_numeric($description)) {
            //Error description field must be filled.
            $verified_description = true;
            $message = "Invalid Description";
        }
        if (empty($availabilities) || is_numeric($availabilities)) {
            //Error availabilities field must be filled.
            $verified_availabilities = true;
            $message = "Invalid availabilities";
        }
        if (empty($service) || $service == '0') {
            //Error availabilities field must be filled.
            $verified_service = true;
            $message = "Select a service";
        }

        if ($verified_service == true && $verified_availabilities == true && $verified_email == true && $verified_last_name == true && $verified_first_name == true && $verified_email == true)
        {
            $message = "Please fill in the form completely in order to contact our photographer";
        }
        if ($verified_service == false && $verified_availabilities == false && $verified_email == false && $verified_last_name == false && $verified_first_name == false && $verified_email == false) {
            $email_subject = "CHI1DSPLAY MEDIA PRODUCTION - New Photoshoot Request from";
            $email_body = "You have receive a new Schedule Request from <em> $first_name $last_name</em> :
                <br>
        <strong> Requested Service</strong>
        <br>
           &nbsp;&nbsp; $service
           <br>
        <strong>Description:</strong>
      <br>
             &nbsp;&nbsp;$description
          <br>
         <strong>Availabilities</strong>
         <br>
           &nbsp;&nbsp; $availabilities";

            sendEmail($first_name,$last_name,$email,$email_subject,$email_body);
            $message = "An email has been sent,<br>the owner will contact you soon, Thank you !";
        }
    }
    echo $message;



