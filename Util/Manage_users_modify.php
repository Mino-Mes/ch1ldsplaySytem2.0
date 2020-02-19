<?php
session_start();
//include 'Auth_security.php';
if(isset($_POST['action']))
{
    try{
        $sql_auth= '';
        switch(strtolower(trim($_POST['action']))){
            case 'promote':
                $sql_auth = 'collaborator';
                break;
            case 'ban':
                $sql_auth = 'banned';
                break;
            case ('unban' || 'demote'):
                $sql_auth = 'customer';
                break;
            default:
                $_SESSION['msg_modify'] = 'Error: Could not determine '.$_POST['user']."'s authorization level!";
                header('Location: Test_adminPage.php');
        }
        require 'dbconn.php';
        $sql = $conn->prepare('UPDATE user SET user_authentication =? WHERE user_username =?');
        $sql->bind_param('ss',$sql_auth,$_POST['user']);
        $sql->execute();
        $sql->close();
        $conn->close();
        $_SESSION['msg_modify'] = $_POST['user']."'s  user account has successfully been modified.";
    }
    catch(Exception $e){
        $_SESSION['msg_modify'] = 'ERROR: Failed to update '.$_POST['user']."'s  user account!";
    }
}
else{
    $_SESSION['msg_modify'] = 'Something seriously went wrong!';
}
header('Location: ../View/Manage_users.php');
exit();