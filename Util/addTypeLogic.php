<?php
require "dbconn.php";

if(isset($_POST))
{
    if($_POST["type"] !="" ||!empty($_POST["type"]))
    {
        $sql2= "SELECT typeName FROM type";
        $result=$conn->query($sql2);

        $checkName=true;
        if($result->num_rows > 0)
        {
            while($row=$result->fetch_assoc())
            {
                if($_POST["type"] == $row["typeName"])
                {
                    $checkName =false;
                }
            }
        }

        if($checkName)
        {
            $typeName=$_POST["type"];
            $tableName="type";
            $sql ="INSERT INTO type VALUES(DEFAULT,'$typeName',1)";
            if ($conn->query($sql) == true) {
                $message="Type has been added, great work!";
            }else{
                $message="The type could not be added,please contact the administrator : ".$conn->error;
            }
        }else
        {
            $message="An existing type already posses the name";
        }

    }else{
        $message="In order to add a type, the name can not be empty or equal to space";
    }
}else
{
    $message="Can't add Type";
}

echo $message;