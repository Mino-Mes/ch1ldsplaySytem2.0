<?php
require "dbconn.php";

if (isset($_POST)) {
    $list = "<div class='inner style2'>";
    $list .= "<h4>List of Current Types </h4>";
    $list .= "<div class='table-wrapper'>";
    $list .= "<table id='typeTable'>";
    $list .= "<thead>";
    $list .= "<tr>";
    $list .= "<th>Type Id</th>";
    $list .= "<th>Type Name</th>";
    $list .= "<th>Is Active</th>";
    $list .= "<th>Update</th>";
    $list .="<th>Delete</th>";
    $list .= "</tr>";
    $list .= "</thead>";
    $list .= "<tbody>";

    if($_POST["active"] ==1)
    {
        $sql = "SELECT * from type WHERE isActive = 1 ORDER BY typeId";
    }
    else
    {
        $sql = "SELECT * from type ORDER BY typeId";
    }
    $result = $conn->query($sql);

    $count=0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $count++;
            $typeId = $row["typeId"];
            $typeName = $row["typeName"];
            $typeActive = $row["isActive"];
            $numActive =$row["isActive"];

            if ($typeActive == 1) {
                $typeActive = "Active";
            } else {
                $typeActive = "Not Active";
            }

            $list .= "<tr><td>$typeId</td><td>$typeName</td><td>$typeActive</td></td><td><ul class=\"actions fit small\"><li><a href=\"javascript:void(0)\" class=\"button fit small\" id='updateTypeBtn' onclick='updateType(".$count.")' style='width:60%;padding-left:1%;padding-right:1%;'>Update</a></li></ul></td><td><ul class=\"actions fit small\"><li><a href=\"javascript:void(0)\" class=\"button fit small\" id='deleteType' onclick='openDeleteModal($typeId,\"t\")' style='width:80%;padding-left:1%;padding-right:1%;background-color:red;'>Delete</a></li></ul></td></tr>";
        }
    }
    $list .= "</table>";
    $list .= "</div>";
}
echo $list;
