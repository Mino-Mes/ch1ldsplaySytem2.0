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

        $sqlAlb="SELECT album_img FROM album WHERE album_id=".$_POST["id"];
        $result1=$conn->query($sqlAlb);
        if($result1->num_rows>0)
        {
            while($row=$result1->fetch_assoc())
            {
                if(unlink($row["album_img"]))
                {
                //    echo "The Album path was deleted<br>";
                }else{
                 //   echo "The Album path was not deleted<br>";
                }
            }
        }

        $sqlP ="SELECT photo_img FROM photo WHERE album_id=".$_POST["id"];
        $result2=$conn->query($sqlP);
        if($result2->num_rows>0)
        {
            while($row2=$result2->fetch_assoc())
            {
                if(unlink($row2["photo_img"]))
                {
                  //  echo "The photos path were deleted<br>";
                }else{
                 //   echo "The photos path were not deleted<br>";
                }
            }
        }

        $sql="DELETE FROM album where album_id=".$_POST["id"];
        if($conn->query($sql) == true)
        {
            echo " and the album has been deleted in the database";

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

}