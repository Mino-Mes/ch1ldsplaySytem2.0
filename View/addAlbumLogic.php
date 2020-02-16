<?php
session_start();
require "../Util/dbconn.php";


function createDir($dirName)
{
    if (file_exists("../Images/album_". $dirName)) {
        return "../Images/album_" . $dirName . "/";
    } else {
        mkdir("../Images/album_". $dirName, 0777);

        return "../Images/album_" . $dirName . "/";
    }
}


function getDir($id)
{
    $title = $_POST["title"];
    $fileName = $_FILES['myPhoto']['name'];

    $img = "../Images/album_" . $id . "/" . basename($fileName);
    return $img;
}

function albDir($id)
{
    $img = "../Images/album_" . $id;
    return $img;
}

function uploadImage($id)
{
    $uploadDirectory = createDir($id);

    $fileName = $_FILES['myPhoto']['name'];
    $fileTmpName = $_FILES['myPhoto']['tmp_name'];

    $uploadPath = $uploadDirectory . basename($fileName);

    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

    if ($didUpload) {
        echo "The file " . basename($fileName) . " has been uploaded";
    } else {
        echo "An error occurred. Please contact the administrator.";
    }
}

if (isset($_POST)) {
    $message = "";
    $verified_title = false;
    $verified_label = false;
    $verified_service = false;
    $verified_description = false;
    $verified_img = false;
    $verified_images = false;
    $album_created=false;
    $images_add=false;

    if (empty($_POST["title"]) || is_numeric($_POST["title"])) {
        $message .= "The title can not be a numeric value or empty <br>";
        $verified_title = true;
    } else {
        $sql = "SELECT album_title FROM album";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["album_title"] == $_POST["title"]) {
                    $message .= "An existing album already posses this title, please select another.<br>";
                    $verified_title = true;
                }
            }
        }
    }
    $total = count($_FILES['albumImages']['name']);
    for ($i = 0; $i < $total; $i++) {
        if ($_FILES["albumImages"]["name"][$i] == "" || $_FILES["albumImages"]["name"][$i] == null) {
            $message .= "Please add the photographs you want to add to the album<br>";
            $images_add = true;
        }
    }
    if (empty($_POST["label"]) || is_numeric($_POST["label"])) {
        $verified_label = true;
        $message .= "The label can not be a numeric value or empty<br>";
    }
    if (empty($_POST["typeDrop"]) || $_POST["typeDrop"] == 0) {
        $verified_service = true;
        $message .= "Please select a type for the Album <br>";
    }
    if (empty($_POST["description"])) {
        $verified_description = true;
        $message .= "The description can not be empty <br>";
    }
    if ($_FILES['myPhoto']['name'] == null || $_FILES['myPhoto']['name'] == "") {
        $verified_img = true;
        $message .="Please upload the gallery image file<br>";
    }

    if ($verified_description && $verified_title && $verified_service && $verified_label && $verified_img && $images_add) {
        $message = "In order to add an album fill in all the form";
    } else if ($verified_description == false && $verified_title == false && $verified_service == false && $verified_label == false && $verified_img == false && $images_add ==false) {



        $title = $_POST["title"];
        $description = $_POST["description"];
        $label = $_POST["label"];
        $type = $_POST["typeDrop"];
        $active = $_POST["active"];

        if (isset($active)) {
            $active = 1;
        } else {
            $active = 0;
        }

        $sql = "INSERT INTO album(user_id,album_title,album_description,album_label,album_isActive,typeId) VALUES('1','$title','$description','$label','$active','$type')";

        if ($conn->query($sql) == true) {
            $album_created=true;
        } else {
            $message = "The album was not added, please contact the administrator Error: " . $conn->error;;
        }
    //Get Last inserted album id in order to add the photograph to the album.
        $sql2 = "SELECT album_id FROM album WHERE album_id =LAST_INSERT_ID()";
                   $result2 = $conn->query($sql2);
                   if ($result2->num_rows > 0) {

                       while ($album = $result2->fetch_assoc()) {
                           $album_id = $album["album_id"];
                       }
                   }
        if($album_created)
        {
            uploadImage($album_id);
            $img=getDir($album_id);
            $inserted_album=false;

            $sql4 = "UPDATE album SET album_img='$img' WHERE album_id=".$album_id;

            if($conn->query($sql4) == true)
            {
                $inserted_album=true;
            }else
            {
                $message ="The Album image could not have been uploaded ".$conn->error();
            }

            if($inserted_album)
            {
                for ($i = 0; $i < $total; $i++) {
                    $tmpFilePath = $_FILES['albumImages']['tmp_name'][$i];
                    $dir = albDir($album_id);
                    $newFilePath = $dir . "/" . $_FILES["albumImages"]["name"][$i];

                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                        $sql3 = "INSERT INTO photo(user_id,photo_img,photo_isActive,album_id) VALUES('1','$newFilePath','1', $album_id)";

                        if ($conn->query($sql3) == true) {
                            $message = "The Album has been created, great work!";
                        } else {
                            $message = "The Album was not created, please contact the administrator Error: " . $conn->error;;
                        }
                    }
                }
            }
        }
        $conn->close();
    }
} else {
    $message = "Submit the form in order to create a new album";
}
header("Location:addAlbum.php?message=" . $message);
exit();
