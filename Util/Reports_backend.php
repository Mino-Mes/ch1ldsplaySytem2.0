<?php
    session_start();
    require "dbconn.php";

    if($conn == false){
        die("ERROR: Could not connect!"
            .mysqli_connect_error());
    }

//sort out and copy back in old code

?>