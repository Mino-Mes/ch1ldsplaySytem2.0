<?php
require "dbconn.php";
if(isset($_POST))
{
    $sql2 = "SELECT * from photo WHERE album_id =" . $_POST["id"];
    $result2 = $conn->query($sql2);


    if ($result2->num_rows > 0) {
        while ($photo = $result2->fetch_assoc()) {
            $photo_id = $photo["photo_id"];
            $user_id = $photo["user_id"];
            $photo_img = $photo["photo_img"];
            $photo_isActive = $photo["photo_isActive"];

            if ($photo_isActive == 1) {
                $photo_isActive = "Active";
                $buttonLabel ="Set to Inactive";
            } else {
                $photo_isActive = "Disabled";
                $buttonLabel ="Set to Active";
            }

            echo "<tr><td style='width:30%;'><img src='$photo_img' alt=\"\" style='width:90%;'/></td><td>$photo_id</td><td>$user_id</td><td>$photo_isActive</td><td><ul class=\"actions fit small\"><li><a href='javascript:void(0)' onclick='isActive($photo_id)' class=\"button fit small\">$buttonLabel</a></li></ul></td><td><ul class=\"actions fit small\"><li><a href='javascript:void(0)' onclick='openDeleteModal($photo_id)' style='background-color:red;' class=\"button fit small\">Delete</a></li></ul></td></tr>";
        }
    }
}