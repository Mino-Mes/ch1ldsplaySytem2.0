<?php
require "dbconn.php";

if(isset($_POST))
{
    $message = "";
    $verified_title = false;
    $verified_label = false;
    $verified_service = false;
    $verified_description = false;
    $verified_img = false;
    $verified_images = false;

    $title=$_POST["albumTitle"];
    $title=$_POST["albumTitle"];
    $album_label=$_POST["albumLabel"];
    $type=$_POST["type"];
    $description=$_POST["description"];
    $id=$_POST["id"];

    if(isset($_POST["isActive"]))
    {
        $isActive=1;
    }else
    {
        $isActive=0;
    }

    if (empty($title) || is_numeric($title)) {
        $message .= "The title can not be a numeric value or empty <br>";
        $verified_title = true;

    } else {
        $sql = "SELECT album_title FROM album";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["album_title"] == $title) {
                    $message .= "An existing album already posses this title, please select another.<br>";
                    $verified_title = true;

                }
            }
        }
    }

    $sql3="SELECT album_title FROM album where album_id=".$_POST["id"];
    $result=$conn->query($sql3);

    if($result->num_rows >0)
    {
        while($row=$result->fetch_assoc())
        {
            if($row["album_title"] == $title)
            {
                $verified_title = false;
            }
        }
    }

    if (empty($album_label) || is_numeric($album_label)) {
        $verified_label = true;
        $message .= "The label can not be a numeric value or empty<br>";
    }

    if (empty($type) || $type== 0) {
        $verified_service = true;
        $message .= "Please select a type for the Album <br>";

    }

    if (empty($description)) {
        $verified_description = true;
        $message .= "The description can not be empty <br>";
        echo "111";
    }
    if ($_FILES['myPhoto']['name'] == null || $_FILES['myPhoto']['name'] == "") {
        $verified_img = true;
        $message .="Please upload the gallery image file<br>";
    }
    if ($verified_description && $verified_title && $verified_service && $verified_label) {
        $message = "In order to update the album information, the form must be completely filled in all the form";
    }else if($verified_description ==false && $verified_title ==false && $verified_service ==false && $verified_label ==false)
    {
        if($verified_img ==true)
        {
            $img=$_POST["dfltImage"];
        }else if($verified_img ==false)
        {
            $img="../Images/album_".$id."/".$_FILES["myPhoto"]["name"];
        }

        $sql2 ="UPDATE album SET album_title='$title', album_description='$description', album_label='$album_label', album_isActive= $isActive, album_img= '$img' , typeId= $type WHERE album_id=".$id;

        if($conn->query($sql2)==true)
        {
            $message="The album has been updated!";
        }
        else
        {
            $message="The message was not updated, contact administrator : ".$conn->error;

            echo $conn->error;
        }
    }
}else
{
    $message="Fill in the form in order to update an album";
}
echo $message;
