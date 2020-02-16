<?php
require "dbconn.php";
if(isset($_POST))
{

    $option="<option value=\"0\" selected>- Type -</option>";

    $sql = "SELECT * FROM type";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $typeId=$row["typeId"];
            $typeName=$row["typeName"];

            $option .="<option value=$typeId>$typeName</option>";
        }
    }
    echo $option;
}