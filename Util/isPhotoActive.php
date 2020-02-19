<?php
require "dbconn.php";
if (isset($_POST)) {
    if (isset($_POST["isActive"])) {

        $mpPhoto = false;
        $albPhoto = false;
        $id = $_POST["photoId"];
        if ($_POST["isActive"] == 1) {
            $sql = "SELECT photo_isActive FROM photo where photo_id=" . $id;
            $albPhoto = true;
        } else if ($_POST["isActive"] == 2) {
            $sql = "SELECT isActive FROM my_photograph where mp_id=" . $id;
            $mpPhoto = true;
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($albPhoto) {
                    if ($row["photo_isActive"] == 1) {
                        $sql1 = "UPDATE photo SET photo_isActive=0 WHERE photo_id=" . $id;
                    } else if ($row["photo_isActive"] == 0) {
                        $sql1 = "UPDATE photo SET photo_isActive=1 WHERE photo_id=" . $id;
                    }
                }

                if ($mpPhoto) {
                    if ($row["isActive"] == 1) {
                        $sql1 = "UPDATE my_photograph SET isActive=0 WHERE mp_id=" . $id;
                    } else if ($row["isActive"] == 0) {
                        $sql1 = "UPDATE my_photograph SET isActive=1 WHERE mp_id=" . $id;
                    }
                }

            }

            if ($conn->query($sql1) == true) {
                echo "The photograph has been updated";
            } else {
                echo "the photograph was not updated";
            }
        }
    }

    if (isset($_POST["deleteP"])) {

        $id = $_POST["photoId"];
        if ($_POST["deleteP"] == 1) {
            $sql = "DELETE FROM photo where photo_id=" . $id;
            $sqlImg = "SELECT photo_img FROM photo WHERE photo_id=" . $id;
            $result = $conn->query($sqlImg);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (unlink($row["photo_img"]))
                    {
                        echo "The Image path was deleted<br>";
                    }else
                    {
                        echo "The image path was not deleted<br>";
                    }
                }
            }
        } else if ($_POST["deleteP"] == 2) {
            $sql = "DELETE FROM my_photograph where mp_id=" . $id;

            $sqlImg = "SELECT img_path FROM my_photograph WHERE mp_id=" . $id;

            $result = $conn->query($sqlImg);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (unlink($row["img_path"]))
                    {
                        echo "The photos were path deleted.<br>";
                    }else
                    {
                        echo "The photos path were not deleted.<br>";
                    }
            }
            }
        }
        if ($conn->query($sql) == true) {
            echo " and the photograph was deleted in the database.";
        } else {
            echo " and the photograph were not deleted in the database, contact the administrator :Error: " . $conn->error;
        }
    }


}