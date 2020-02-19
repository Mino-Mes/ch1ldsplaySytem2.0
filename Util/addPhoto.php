<?php
require "dbconn.php";
session_start();

$message="Can't access Form";
if (isset($_POST)) {

    $dir = "../Images/album_" . $_POST["albumId"];
    $total = count($_FILES["photos"]["name"]);
    $album_id=$_POST["albumId"];

    if($total >0 && $_FILES["photos"]["name"] !="" && !empty($_FILES["photos"]["name"])) {
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['photos']['tmp_name'][$i];
            $newFilePath = $dir . "/" . $_FILES["photos"]["name"][$i];

            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                $userId=$_SESSION["ln_userId"];
                    $sql3 = "INSERT INTO photo(user_id,photo_img,photo_isActive,album_id) VALUES($userId,'$newFilePath','1', $album_id)";

                    if ($conn->query($sql3) == true) {
                        $message = "The photos have been uploaded, great work!";
                    } else {
                        $message = "The photos were not uploaded, please contact the administrator Error: " . $conn->error;;
                    }
                }else
                {
                    $message="Can not upload the files, the directory does not exist";
                }
            }
    }else
    {
        $message = "In order to add photographs, please upload them first!";
    }
} else {
    $message = "In order to add photographs, please upload them first!";
}
echo $message;