<?php
require "dbconn.php";
if(isset($_POST))
{
    if($_POST["fname"] =="t")
    {
        $typeId=$_POST["id"];

        $sql="DELETE FROM type where typeId=".$typeId;
        if($conn->query($sql) == true)
        {
            echo "The Type has been deleted";
        }
        else{
            echo "The type was not deleted, contact the adminstrator : Error ".$conn->error;
        }
    }

    if($_POST["fname"] == "a")
    {
        $sql="DELETE FROM album where album_id=".$_POST["id"];
        if($conn->query($sql) == true)
        {
            echo "The album has been deleted";

            $sql2="DELETE FROM photo where album_id=".$_POST["id"];
            if($conn->query($sql2) == true)
            {
                echo "The album and the photographs were deleted";
            }else{
                echo "The album was not deleted, contact the adminstrator : Error ".$conn->error;
            }
        }
        else{
            echo "The album was not deleted, contact the adminstrator : Error ".$conn->error;
        }
    }

    if($_POST["fname"]=="ua")
    {

    }
}