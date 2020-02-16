<?php
require "dbconn.php";

if (isset($_POST)) {

    $dir = "../Images/album_" . $_POST["albumId"];
    $total = count($_FILES["photos"]["name"]);
    $album_id=$_POST["albumId"];

    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES['photos']['tmp_name'][$i];
        $newFilePath = $dir . "/" . $_FILES["photos"]["name"][$i];

        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            {
                $sql3 = "INSERT INTO photo(user_id,photo_img,photo_isActive,album_id) VALUES('1','$newFilePath','1', $album_id)";

                if ($conn->query($sql3) == true) {
                    $message = "The photos have been uploaded, great work!";
                } else {
                    $message = "The photos were not uploaded, please contact the administrator Error: " . $conn->error;;
                }
            }
        }
    }
} else {
    $message = "In order to add photographs, please upload them first!";
}
header("Location:../View/viewAlbum.php?id=$album_id&message=". $message);
exit();