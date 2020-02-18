<?php
/* THIS CODE IS NOW IN functions.php*/
//checks if the user is an admin, if not, send them back to index
if(isset($_SESSION['ln_usertype'])){
    if($_SESSION['ln_usertype'] != 'administrator') {
        unset($_SESSION['ln_usertype']);
        unset($_SESSION['ln_username']);
        header('Location: ../View/index.php');
    }
}
?>