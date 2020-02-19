<?php
session_start();
require "dbconn.php";

$_SESSION['reg_attempt'] = false;
$_SESSION['log_attempt'] = true;
$_SESSION['recover_attempt'] = false;

//for security reasons, we will not specify what field was incorrectly filled out
//rather we will just inform the user that they have entered incorrect credentials
//so if someone was trying to get into someone else's account, we wouldn't help them
//by telling them what part of the login they're getting wrong

//this code needs to be better optimized

$_SESSION['log_msg'] = '';
$_SESSION['log_err'] = false;

if(isset($_POST))
{
    $username=trim($_POST["log_username"]);
    $password=trim($_POST["log_password"]);

    //used to make the login form sticky
    $_SESSION['log_username'] = $username;
    $_SESSION['log_pass'] = $password;

    $sql="SELECT user_username,user_email FROM user";
    $result=$conn->query($sql);

    $userExists=false;

    if($result->num_rows>0)
    {
        while($row=$result->fetch_assoc())
        {
            if($username == $row["user_username"] || $username == $row["user_email"])
            {
                $userExists=true;
                //echo "YO MAN IT MATCHES";
            }
        }
    }

    if($userExists)
    {
        $getPsswdSQL = "SELECT user_password,user_authentication,user_id,user_fname FROM user WHERE user_username ='$username' OR user_email='$username' LIMIT 1";
        $result2=$conn->query($getPsswdSQL);

        if(!empty($result2) && $result2->num_rows>0)
        {
            while($row2=$result2->fetch_assoc())
            {
                if(password_verify($password, $row2["user_password"]))
                {
                    //ln = logged in
                    $_SESSION['ln_usertype'] = $row2['user_authentication'];
                    $_SESSION['ln_username'] = $row2['user_fname'];
                    $_SESSION['ln_userId']=$row2["user_id"];
                    $conn->close();
                    header('Location: ../View/index.php?');
                }
                else{
                    $_SESSION['log_err'] = true;
                    $_SESSION['log_msg'] = 'Error: incorrect Username or Password';
                    //echo "Not found";
                    $conn->close();
                    header('Location: ../View/index.php');
                    exit();
                }
            }
        }
        else
        {
            $_SESSION['log_err'] = true;
            $_SESSION['log_msg'] = 'Error: incorrect Username or Password';
            //echo "Not found";
            $conn->close();
            header('Location: ../View/index.php');

        }
    }
    else{
        $_SESSION['log_err'] = true;
        $_SESSION['log_msg'] = 'Error: incorrect Username or Password';
        $conn->close();
        header('Location: ../View/index.php');
    }
    echo 'test 1';
}
echo 'test 2';