<?php
session_start();
require "Util/dbconn.php";

$_SESSION['reg_attempt'] = false;
$_SESSION['log_attempt'] = true;

//for security reasons, we will not specify what field was incorrectly filled out
//rather we will just inform the user that they have entered incorrect credentials
//so if someone was trying to get into someone else's account, we wouldn't help them
//by telling them what part of the login they're getting wrong

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
        $getPsswdSQL = "SELECT user_password FROM user WHERE user_username ='$username' OR user_email='$username' LIMIT 1";
        $result2=$conn->query($getPsswdSQL);

        if(!empty($result2) && $result2->num_rows>0)
        {
            while($row2=$result2->fetch_assoc())
            {
                if(password_verify($password, $row2["user_password"]))
                {
                    //echo "You are logged in";
                    $conn->close();
                    header('Location: index.php');
                }
            }
        }
        else
        {
            $_SESSION['log_err'] = true;
            $_SESSION['log_msg'] = 'Error: incorrect Username or Password';
            //echo "Not found";
            $conn->close();
            header('Location: index.php');
        }
    }
    else{
        $_SESSION['log_err'] = true;
        $_SESSION['log_msg'] = 'Error: incorrect Username or Password';
        $conn->close();
        header('Location: index.php');
    }



}

