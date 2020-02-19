<?php
require "dbconn.php";
if(isset($_POST))
{

    if($_POST["active"] ==1)
    {
        $sql = "SELECT * from album WHERE album_isActive = 1 ORDER BY album_id";
    }
    else
    {
        $sql = "SELECT * from album ORDER BY album_id";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($albums = $result->fetch_assoc()) {
            $id = $albums["album_id"];
            $user_id = $albums["user_id"];
            $album_title = $albums["album_title"];
            $album_description = $albums["album_description"];
            $album_label = $albums["album_label"];
            $album_img = $albums["album_img"];
            $album_isActive = $albums["album_isActive"];
            $album_type = $albums["typeId"];

            if ($album_isActive == 1) {
                $album_isActive = "Active";
            } else {
                $album_isActive = "Disabled";
            }

            echo "<tr><td><div class=\"row gtr-1 gtr-uniform\"><div class=\"col-12\"><span class=\"image fit\"><img src='$album_img' alt=\"\" /></span></div></div></td><td>$id</td><td>$user_id</td><td>$album_title</td><td>$album_description</td><td>$album_label</td><td>$album_type</td><td>$album_isActive</td><td><ul class=\"actions fit small\"><li><a href=\"viewAlbum.php?id=$id\" class=\"button fit small\">Update</a></li></ul></td><td><ul class=\"actions fit small\"><li><a href=\"javascript:void(0)\" class=\"button fit small\" id='deleteAlbum' onclick='openDeleteModal($id,\"a\")' style='background-color:red;'>Delete</a></li></ul></td></tr>";
        }
    }
}