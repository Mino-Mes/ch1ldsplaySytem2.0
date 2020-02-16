<?php
require "dbconn.php";

if(isset($_POST))
{
 echo $_FILES["photos"]["name"];
}