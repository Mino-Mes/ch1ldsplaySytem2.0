<?php
session_start();

//this path needs to be changed and the action in the index
include("dbconn.php");

//keeping track that a registration was attempted
$_SESSION['reg_attempt'] = true;
$_SESSION['log_attempt'] = false;
$_SESSION['recover_attempt'] = false;

//put some regex functions here if necessary

//initialize the vars
$lname;$fname;$email;
$username;$pass;$date;

//assoc array for form field specific errors
$arr_err = ['fname' => false,'lname' => false, 'email' => false, 'username' => false,'pass' => false, 'confirm_pass' => false];
//assoc array so that the reg form can be made sticky
$arr_form_vals = ['fname' => 'N/A','lname' => 'N/A', 'email' => 'N/A', 'username' => 'N/A','pass' => 'N/A', 'confirm_pass' => 'N/A'];

//the message returned after 'Register' is clicked
$msg = '';

//a boolean to track if the attempt was a successful attempt
$reg_success = false;
$_SESSION['reg_success'] = $reg_success;

//try catch for corner cases(if the clientside is messed with)
try
{
    $lname = trim($_POST['reg_lname']);
    $arr_form_vals["lname"] = $lname;

    $fname = trim($_POST['reg_fname']);
    $arr_form_vals['fname']=$fname;

    $email = trim($_POST['reg_email']);
    $arr_form_vals['email']=$email;

    $username = trim($_POST['reg_username']);
    $arr_form_vals['username']=$username;

    $pass = trim($_POST['reg_password']);
    $arr_form_vals['pass']=$pass;

    $confirm_pass = trim($_POST['reg_confirm_password']);
    $arr_form_vals['confirm_pass']=$confirm_pass;

    $date = date('Y-m-d',time());
}
catch(Exception $e)
{
    //something weird went wrong, send them back to index with an error message
    $_SESSION["message"] = 'ERROR: Registration failed! Please enter valid inputs';
    $_SESSION['reg_msg'] = $msg;
    $_SESSION['reg_arr_form_vals'] = $arr_form_vals;
    $conn->close();
    header('Location: ../index.php');
    exit();
}

//back-end validation

//last name
if(strlen($lname) > 35 || strlen($lname) < 1)
{
    $arr_err['lname'] = true;
}
if(!(preg_match('/^[A-Za-z]+$/',$lname)))
{
    $arr_err['lname'] = true;
}

//first name
if(strlen($fname) > 35 || strlen($fname) < 1)
{
    $arr_err['fname'] = true;
}
if(!(preg_match('/^[A-Za-z]+$/',$fname)))
{
    $arr_err['fname'] = true;
}

//email
if(strlen($email) > 255 || strlen($email) < 3)
{
    $arr_err['email'] = true;
}
//remove all illegal characters from email
$email = filter_var($email,FILTER_SANITIZE_EMAIL);
//validate email
if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
    //email is not valid
    $arr_err['email'] = true;
}

//username
if(strlen($username) > 20 || strlen($username) < 6)
{
    $arr_err['username'] = true;
}
if(!(preg_match('/^[a-zA-Z0-9_-]*$/',$username)))
{
    $arr_err['username'] = true;
}

//password
if(strlen($pass) > 35 || strlen($pass) < 8)
{
    $arr_err['pass'] = true;
}
if(!(preg_match('/^[a-zA-Z0-9_.%^&*$#@!()=+-]*$/',$pass)))
{
    $arr_err['pass'] = true;
}

//check if password and confirm password match
if(strcmp($pass,$confirm_pass) !== 0)
{
    //password doesn't match
    $arr_err['confirm_pass'] = true;
}

//now find the errors we've encountered
foreach($arr_err as $key => $value)
{
    if($value == true)
    {
        //we've got invalid inputs, throw them back to index with an error message
        $_SESSION["message"] = 'ERROR: Registration failed Please enter valid inputs';
        $_SESSION['reg_msg'] = $msg;
        $_SESSION['reg_arr_err'] = $arr_err;
        $_SESSION['reg_arr_form_vals'] = $arr_form_vals;
        $conn->close();
       header('Location: ../View/index.php');
        exit();
    }
}

//now that the basic validation is out of the way,
//we need to make sure that both the username and email are not already in use

$no_err = false;

$sql = 'SELECT user_username, user_email FROM user';
$res = $conn->query($sql) or die ('ERROR: Database Error');

if($res->num_rows > 0)
{
    while($row = $res->fetch_assoc())
    {
        if(strcmp(strtolower($row['user_username']),strtolower($username)) ==0)
        {
            $arr_err['username'] = true;
        }
        if(strcmp(strtolower($row['user_email']),strtolower($email)) ==0)
        {
            $arr_err['username'] = true;
        }
    }
    if($arr_err['username'] && !$arr_err['email'])
    {
        //username is already taken
        $_SESSION['reg_err_arr'] = $arr_err;
        $_SESSION['reg_arr_form_vals'] = $arr_form_vals;
        $_SESSION["message"] = 'ERROR: the username: ' . $username . ' is already in use';
        $_SESSION['reg_msg'] = $msg;
        $res->close();
        $conn->close();
        header('Location: ../View/index.php');
        exit();
    }
    elseif($arr_err['email'] && !$arr_err['username'])
    {
        //email is already taken
        $_SESSION['reg_err_arr'] = $arr_err;
        $_SESSION['reg_arr_form_vals'] = $arr_form_vals;
        $_SESSION["message"]= 'ERROR: the email address: ' . $email . 'is already in use';
        $_SESSION['reg_msg'] = $msg;
        $res->close();
        $conn->close();
        header('Location: ../View/index.php');
        exit();
    }
    elseif($arr_err['username'] && $arr_err['email'])
    {
        //both are already taken
        $_SESSION['reg_err_arr'] = $arr_err;
        $_SESSION['reg_arr_form_vals'] = $arr_form_vals;
        $_SESSION["message"] = 'ERROR: the username: ' . $username . ' and email address: ' . $email . ' are both already in use';
        $_SESSION['reg_msg'] = $msg;
        $res->close();
        $conn->close();
        header('Location: ../View/index.php');
        exit();
    }
    else{
        //we're good to go
        $no_err = true;

    }
}
else{
    //this is for the rare case where no other users are found
    $no_err = true;
}

//no insert the new user into the DB
if($no_err)
{
    $hash=password_hash($pass,PASSWORD_BCRYPT);


  /*  $sql = $conn->prepare("INSERT INTO user (user_lname,user_fname,user_email,user_username,user_password,user_creationDate)
                VALUES (?,?,?,?,?,?)");
    $sql->bind_param('ssssss', $lname,$fname,$email,$username, $hash,$date);
*/
    $date = date('Y-m-d',time());
    $sql="INSERT INTO user (user_lname,user_fname,user_email,user_username,user_password,user_creationDate) VALUES ('$lname','$fname','$email','$username', '$hash','$date')";
    if($conn->query($sql) === TRUE)
    {
        $last_id=$conn->insert_id;
        echo $last_id;
    }


    $msg = 'Registration Successful!';
    $_SESSION['reg_msg'] = $msg;

    $reg_success = true;

    $sql3="SELECT * FROM user WHERE user_id=".$last_id;
    $result3=$conn->query($sql3);
    if($result3->num_rows >0)
    {
        while($row=$result3->fetch_assoc())
        {
            $_SESSION['ln_usertype'] =$row["user_authentication"];
            $_SESSION['ln_username'] =$row["user_fname"];
            $_SESSION['ln_userId']=$row["user_id"];
        }
    }
    $_SESSION['reg_success'] = $reg_success;
    $conn->close();
    header('Location: ../View/index.php');
    exit();
}
else{
    $_SESSION["message"] = 'Something seriously went wrong!';
    $_SESSION['reg_msg'] = $msg;
    $_SESSION['reg_arr_form_vals'] = $arr_form_vals;

    header('Location: ../View/index.php?message=1');
    exit();
}

