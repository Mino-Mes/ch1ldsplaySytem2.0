<?php
require "dbconn.php";
if(isset($_POST))
{
    if($_POST["name"] !="" ||!empty($_POST["name"]))
    {
        $sql2= "SELECT typeName FROM type";
        $result=$conn->query($sql2);

        $checkName=true;
        if($result->num_rows > 0)
        {
            while($row=$result->fetch_assoc())
            {
                if($_POST["name"] == $row["typeName"])
                {
                    $checkName =false;
                }
            }
        }

        $sql3="SELECT typeName FROM type WHERE typeId=".$_POST["id"];
        $result2=$conn->query($sql3);

        if($result2->num_rows > 0)
        {
            while($row2=$result2->fetch_assoc())
            {
                if($row2["typeName"] == $_POST["name"])
                {
                    $checkName =true;
                }
            }
        }

        if($checkName)
        {
            $typeId=$_POST["id"];
            $typeName=$_POST["name"];
            $isActive=$_POST["active"];

            if($isActive=="on")
            {
                $isActive=1;
            }

            $sql ="UPDATE type SET typeName='$typeName',isActive=$isActive WHERE typeId=".$typeId;
            if ($conn->query($sql) == true) {
                $message="The Type has been updated, great work! ";
            }else{
                $message="The type could not be updated,please contact the administrator : ".$conn->error;
            }
        }else
        {
            $message="An existing type already posses the name";
        }

    }else{
        $message="In order to update a type, the name can not be empty or equal to space";
    }
    echo $message;
}
