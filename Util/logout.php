<?php
/* THIS CODE IS NOW IN functions.php*/

unset($_SESSION['ln_username']);
unset($_SESSION['ln_usertype']);
header('Location: ../View/index.php');
?>
