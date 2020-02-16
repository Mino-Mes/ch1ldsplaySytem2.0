<?php
require "dbconn.php";
if(isset($_POST))
{
    if(isset($_POST["isActive"]))
    {
        if($_POST["isActive"] ==1)
        {
            $id=$_POST["photoId"];

            $sql="SELECT photo_isActive FROM photo where photo_id=".$id;
            $result=$conn->query($sql);

            if($result->num_rows >0)
            {
                while($row=$result->fetch_assoc())
                {
                    if($row["photo_isActive"] == 1)
                    {
                        $sql1="UPDATE photo SET photo_isActive=0 WHERE photo_id=".$id;
                    }else if($row["photo_isActive"] == 0)
                    {
                        $sql1="UPDATE photo SET photo_isActive=1 WHERE photo_id=".$id;
                    }
                }

                if($conn->query($sql1) ==true)
                {
                    echo "The photograph has been updated";
                }else
                {
                    echo "the photograph was not updated";
                }
            }
        }
    }

    if( isset($_POST["deleteP"]))
    {
        if($_POST["deleteP"] == 1)
        {
            $id=$_POST["photoId"];

            $sql="DELETE FROM photo where photo_id=".$id;
            if($conn->query($sql) ==true)
            {
                echo "The photograph was deleted.";
            }
            else
            {
                echo "The photograph was not deleted, contact the administrator :Error: ".$conn->error;
            }
        }

    }

}