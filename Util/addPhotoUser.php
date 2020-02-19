<?php
require "dbconn.php";

function createDir($dirName)
{
    if (file_exists("../Images/user_" . $dirName)) {
        return "../Images/user_" . $dirName;
    } else {
        mkdir("../Images/user_" . $dirName, 0777);

        return "../Images/user_" . $dirName;
    }
}

function getDir($id)
{
    $fileName = $_FILES['userPhotos']['name'];

    $img = "../Images/album_" . $id . "/" . basename($fileName);
    return $img;
}
$total = count($_FILES['userPhotos']['name']);
if (isset($_POST)) {
    if ($_FILES['userPhotos']['name'] != "" && !empty($_FILES['userPhotos']['name']) && $total > 0) {
        $userId = $_POST["hiddenUserId"];
        $dir = createDir($userId);

        $total = count($_FILES['userPhotos']['name']);

        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['userPhotos']['tmp_name'][$i];
            $newFilePath = $dir . "/" . $_FILES["userPhotos"]["name"][$i];

            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $sql = "INSERT INTO my_photograph VALUES(DEFAULT, $userId,'$newFilePath',1)";
                if ($conn->query($sql) == true) {
                    $message = "The Photos have been added, great work!";
                } else {
                    $message = "The Photos have not been added, please contact the administrator Error: $newFilePath" . $conn->error;
                }
            }else
            {
                $message = "Please upload the images in order to add photographs" . $conn->error;
            }
        }
    }
    else
    {
        $message="Please upload the images in order to add photographs";
    }
}else{
    $message="Can't access page";
}

echo $message;
