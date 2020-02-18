<?php
require "dbconn.php";
if(isset($_POST))
{
    $sql2 = "SELECT * from my_photograph WHERE user_id =" . $_POST["id"];
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while ($photo = $result2->fetch_assoc()) {
            $photo_img = $photo["img_path"];
            $photo_id=$photo["mp_id"];
            $user_id = $photo["user_id"];
            $isActive = $photo["isActive"];

            if ($isActive == 1) {
                $isActive = "Active";
                $buttonLabel ="Set to Inactive";
            } else {
                $isActive = "Disabled";
                $buttonLabel ="Set to Active";
            }

            echo "<tr>
                    <td style='width:30%;'><img src='$photo_img' alt=\"\" style='width:90%;'/></td>
                    <td>$photo_id</td>
                    <td>$user_id</td>
                    <td>$isActive</td>
                    <td><ul class=\"actions fit small\"><li><a href=\"javascript:void(0)\" class=\"button alt fit small\"  onclick='isActive($photo_id)' style=\"padding-left:1%;padding-right:1%;\">$buttonLabel</a></li></ul></td>
                    <td><ul class=\"actions fit small\"><li><a href=\"javascript:void(0)\" class=\"button  fit small\" onclick='deletePhoto($photo_id)' style=\"padding-left:1%;padding-right:1%;background-color: red;\">Delete</a></li></ul></td>
                    </tr>";
        }
    }
}