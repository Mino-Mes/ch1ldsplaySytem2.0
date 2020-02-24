<?php
session_start();
require "dbconn.php";

function showAdvancedSetting()
{
    return "                          
                                <div class=\"col-4\">
                                            <h4>Date</h4>
                                            <input type=\"radio\" name=\"date\" id=\"allTime\" value =\"allTime\" onclick=\"dateRange(0)\" checked>
                                            <label for=\"allTime\"> All Time</label>
                                            <input type=\"radio\" name=\"date\" id=\"rangeDate\" value =\"rangeDate\"onclick=\"dateRange(1)\">
                                            <label for=\"rangeDate\">Range</label>
                                            <div id=\"dateRangeContainer\">
                                            </div>
                                        </div>
                                        <div class=\"col-4\">
                                            <h4>User Type</h4>
                                            <input type=\"checkbox\" name=\"customerC\" id=\"customerC\">
                                            <label for=\"customerC\">Customer</label>
                                            <input type=\"checkbox\" name=\"collaboratorC\" id=\"collaboratorC\">
                                            <label for=\"collaboratorC\">Collaborator</label>
                                            <input type=\"checkbox\" name=\"adminC\" id=\"adminC\">
                                            <label for=\"adminC\">Administrator</label>
                                        </div>
                                        <div class=\"col-4\">
                                            <h4>Creator Views - <span style='color:red;'>Note :Disregards User Type Selected</span></h4>
                                            <input type=\"checkbox\" name=\"showViews\" id=\"showViews\" onclick=\"orderByViews()\">
                                            <label for=\"showViews\">Show Creator Information (Total album Views, Total Album Added,Total Photo Added )</label>
                                        </div>
                                        <div class=\"col-6\">
                                            <h4>Search a user</h4>
                                            <label for=\"lastNameS\">by Last Name</label>
                                            <input type=\"text\" name=\"lastNameS\" id=\"lastNameS\" style=\"width:30%;margin-left:36%;\">
                                        </div>
                                        </div> ";
}

function showAllUsers($conn, $orderBy)
{
    $sql = "SELECT * FROM USER ORDER BY " . $orderBy;
    $result = $conn->query($sql);

    $table = "";
    if ($result->num_rows > 0) {
        $table .= "<h4>List of All Users</h4>"
            . "<div class='table-wrapper'>"
            . "<table>"
            . "<thead>"
            . "<tr>"
            . "<th>user_id</th>"
            . "<th>Last Name</th>"
            . "<th>First Name</th>"
            . "<th>Email</th>"
            . "<th>Authentication Level</th>"
            . "<th>Username</th>"
            . "<th>Creation Date</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";


        while ($row = $result->fetch_assoc()) {
            $table .= "<tr>"
                . "<td>" . $row["user_id"] . "</td>"
                . "<td>" . $row["user_lname"] . "</td>"
                . "<td>" . $row["user_fname"] . "</td>"
                . "<td>" . $row["user_email"] . "</td>"
                . "<td>" . $row["user_authentication"] . "</td>"
                . "<td>" . $row["user_username"] . "</td>"
                . "<td>" . $row["user_creationDate"] . "</td>"
                . "</tr>";
        }

        $table .= "</tbody>"
            . "</table>"
            . "</div>";
    }

    return $table;
}

function showAllusersAdvanced($conn, $date, $customer, $collab, $admin, $views, $search1, $orderBy)
{
    $dateisSet = false;
    $sql = "SELECT * FROM USER ";
    if ($date != 1) {
        $sql .= "WHERE user_creationDate < '" . date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date))) . "' ";
        $dateisSet = true;
    }

    if ($dateisSet) {
        if ($customer == 1) {
            $sql .= " AND user_authentication ='customer' ";
        }
        if ($collab == 1 && $customer == 1) {
            $sql .= " OR user_authentication = 'collaborator'";
        } else if ($collab == 1 && $customer == 0) {
            $sql .= " AND user_authentication ='collaborator'";
        }
        if ($admin == 1 && $collab == 1) {
            $sql .= " OR user_authentication ='administrator'";
        } else if ($admin == 1 && $customer == 1) {
            $sql .= " OR user_authentication LIKE 'administrator'";
        } else if ($admin == 1 && $customer == 0 && $collab == 0) {
            $sql .= " AND user_authentication ='administrator'";
        }
    } else if (!$dateisSet) {
        if ($customer == 1) {
            $sql .= "WHERE user_authentication ='customer' ";
        }
        if ($collab == 1 && $customer == 1) {
            $sql .= " OR user_authentication = 'collaborator'";
        } else if ($collab == 1 && $customer == 0) {
            $sql .= "WHERE user_authentication ='collaborator'";
        }
        if ($admin == 1 && $collab == 1) {
            $sql .= " OR user_authentication ='administrator'";
        } else if ($admin == 1 && $customer == 1) {
            $sql .= " OR user_authentication = 'administrator'";
        } else if ($admin == 1 && $customer == 0 && $collab == 0) {
            $sql .= "WHERE user_authentication ='administrator'";
        }
    }

    $isView = false;
    if ($views == 1) {
        $isView = true;
        if ($dateisSet) {
            $sql = "SELECT * FROM USER WHERE user_creationDate < '" . date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date))) . "'AND user_authentication ='collaborator' OR user_authentication = 'administrator'";
        } else if (!$dateisSet) {
            $sql = "SELECT * FROM USER WHERE user_authentication ='collaborator' OR user_authentication = 'administrator'";
        }
    }

    if ($search1 != "") {
        $isView = false;
        if ($dateisSet) {
            $sql = "SELECT * FROM USER WHERE user_creationDate < '" . date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date))) . "'AND user_lname ='$search1'";
        } else if (!$dateisSet) {
            $sql = "SELECT * FROM USER WHERE user_lname ='$search1'";
        }
    }

    $sql .= " ORDER BY " . $orderBy;

  //  return $sql;

    $result = $conn->query($sql) or die("Error: " . $conn->error);

    $table = "";
    if ($result->num_rows > 0) {
        $table .= "<h4>List of All Users</h4>"
            . "<div class='table-wrapper'>"
            . "<table>"
            . "<thead>"
            . "<tr>"
            . "<th>user_id</th>"
            . "<th>Last Name</th>"
            . "<th>First Name</th>"
            . "<th>Email</th>"
            . "<th>Authentication Level</th>"
            . "<th>Username</th>";
        if ($isView) {
            $table .= "<th>Total Views</th>";
            $table .= "<th>Album Created</th>";
            $table .= "<th>Photo Created</th>";
        }
        $table .= "<th>Creation Date</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";


        while ($row = $result->fetch_assoc()) {


            $table .= "<tr>"
                . "<td>" . $row["user_id"] . "</td>"
                . "<td>" . $row["user_lname"] . "</td>"
                . "<td>" . $row["user_fname"] . "</td>"
                . "<td>" . $row["user_email"] . "</td>"
                . "<td>" . $row["user_authentication"] . "</td>"
                . "<td>" . $row["user_username"] . "</td>";
            if ($isView) {
                $table .= "<td>" . $row["totalViews"] . "</td>";
                $sql2 = "SELECT count('user_id') as 'countUser' FROM album WHERE user_id=" . $row["user_id"];
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $table .= "<td>" . $row2["countUser"] . "</td>";
                    }
                }
                $sql3 = "SELECT count('user_id') as 'countUser' FROM photo WHERE user_id=" . $row["user_id"];
                $result3 = $conn->query($sql3);
                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        $table .= "<td>" . $row3["countUser"] . "</td>";
                    }
                }

            }
            $table .= "<td>" . $row["user_creationDate"] . "</td>"
                . "</tr>";
        }

        $table .= "</tbody>"
            . "</table>"
            . "</div>";
    }

    return $table;
}

function albumReport($conn, $searchType, $images, $albumViews,$totalPhotos, $orderBy)
{
    $sql = "";
    if ($searchType == "all") {
        $sql .= "SELECT * FROM album";
    } else {
        $sql .= "SELECT * FROM album WHERE album_title = '$searchType'";
    }

    $sql .= " ORDER BY " . $orderBy;
//return $sql;
    $result = $conn->query($sql);
    $table = "";
    if ($result->num_rows > 0) {
        $table .= "<h4>List of Albums</h4>"
            . "<div class='table-wrapper'>"
            . "<table>"
            . "<thead>"
            . "<tr>";
        if ($images == 1) {
            $table .= "<th>Image</th>";
        }
        $table .= "<th>album_id</th>"
            ."<th>Creator</th>"
            . "<th>Title</th>"
            . "<th>Description</th>"
            . "<th>Label</th>"
            . "<th>Type</th>";
        if ($albumViews == 1) {
            $table .= "<th>Total Views</th>";
        }
        if($totalPhotos ==1)
        {
            $table .= "<th>Total Photographs</th>";
        }
        $table .="</tr>"
                  ."</thead>"
                  ."<tbody>";

        while($row=$result->fetch_assoc())
        {
            $table .="<tr>";
            if($images==1)
            {
                $album_img = $row["album_img"];
                $table .="<td style='width: 20%;'><img src='$album_img' alt=\"\" style='width: 100%;' ></td>";
            }
            $table .="<td>".$row["album_id"]."</td>";
            $sql2 ="SELECT user_username FROM user WHERE user_id=".$row["user_id"];
            $result2=$conn->query($sql2);
            if($result2->num_rows>0)
            {
                while($row2=$result2->fetch_assoc())
                {
                    $table .="<td>".$row2["user_username"]."</td>";
                }
            }
            $table .="<td>".$row["album_title"]."</td>"
                     ."<td>".$row["album_description"]."</td>"
                     ."<td>".$row["album_label"]."</td>";

            $sql3="SELECT typeName FROM type WHERE typeId =".$row["typeId"];
            $result3=$conn->query($sql3);
            if($result3->num_rows>0)
            {
                while($row3=$result3->fetch_assoc())
                {
                    $table .="<td>".$row3["typeName"]."</td>";
                }
            }
            if($albumViews == 1)
            {
                $table .="<td>".$row["album_views"]."</td>";
            }
            if($totalPhotos ==1)
            {
                $sql4="SELECT count('album_id') AS 'countPhoto' FROM photo WHERE album_id=".$row["album_id"];
                $result4=$conn->query($sql4);

                if($result4->num_rows >0)
                {
                    while($row4=$result4->fetch_assoc())
                    {
                        $table .="<td>".$row4["countPhoto"]."</td>";
                    }
                }
            }
             $table .="</tr>";
        }
        $table .="</tbody>"
                  ."</table>"
                  ."</div>";
    }
 return $table;
}
function showPhotoReport($conn,$search,$searchValue,$showImage,$orderBy)
{
    if($search == "byCreator")
    {
        $sql2="SELECT user_id FROM user WHERE user_username='$searchValue'";
        $result2=$conn->query($sql2);
        if($result2->num_rows >0)
        {
            while($row2=$result2->fetch_assoc())
            {
                $user_id=$row2["user_id"];
            }
        }else
        {
            return "<h3>There is no Photograph created by this User</h3>";
        }


        $sql ="SELECT * FROM photo WHERE user_id=".$user_id;
    }else if($search == "albumTitle")
    {
        $sql2="SELECT album_id FROM album WHERE album_title='$searchValue'";
        $result2=$conn->query($sql2);
        if($result2->num_rows >0)
        {
            while($row2=$result2->fetch_assoc())
            {
                $album_id=$row2["album_id"];
            }
        }else
        {
            return "<h3>There is no Photograph corresponding to this album</h3>";
        }
        $sql ="SELECT * FROM photo WHERE album_id=".$album_id;
    }else if($search =="all")
    {
        $sql="SELECT * FROM photo";
    }

    $sql .=" ORDER BY ".$orderBy;

    $table="";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        $table = "<h4>List of Photographs</h4>"
            . "<div class='table-wrapper'>"
            . "<table>"
            . "<thead>"
            . "<tr>";
        if($showImage ==1)
        {
            $table .="<th>Photo Image</th>";
        }
           $table .="<th>photo_id</th>"
            ."<th>Creator</th>"
            ."<th>Album</th>"
            ."</tr>"
            ."</thead>"
             ."<tbody>";
        while($row=$result->fetch_assoc())
        {
            $table.="<tr>";
            if($showImage ==1)
            {
                $photo_img=$row["photo_img"];
                $table .="<td style='width: 20%;'><img src='$photo_img' alt=\"\" style='width: 100%;' ></td>";
            }
            $table .="<td>".$row["photo_id"]."</td>";
            $sql2="SELECT user_username FROM user WHERE user_id=".$row["user_id"];
            $result2=$conn->query($sql2);
            if($result2->num_rows >0)
            {
                while($row2=$result2->fetch_assoc())
                {
                    $username=$row2["user_username"];
                    $table .="<td>$username</td>";
                }
            }
            $sql3="SELECT album_title FROM album WHERE album_id=".$row["album_id"];
            $result3=$conn->query($sql3);
            if($result3->num_rows >0)
            {
                while($row3=$result3->fetch_assoc())
                {
                    $title=$row3["album_title"];
                    $table .="<td>$title</td>";
                }
            }
            $table .="</tr>";
        }
        $table .="</tbody>"
            ."</table>"
            ."</div>";
    }
    return $table;
}

if (isset($_POST)) {
    /*  if($_POST["function"] == "showAllUsers")
      {
          $message = showAllUsers($conn);
          echo $message;
      }
  */

    if(isset($_POST["photoSearch"]))
    {
        if($_POST["photoSearch"] == "byCreator")
        {
            $search="byCreator";
            $searchValue=$_POST["creatorSearch"];
        }else if($_POST["photoSearch"] == "albumTitle")
        {
            $search="albumTitle";
            $searchValue=$_POST["albumSearch"];
        }else if($_POST["photoSearch"] == "all")
        {
            $search="all";
            $searchValue=0;
        }
        if(isset($_POST["photoImages"]))
        {
            $showImage=1;
        }else
        {
            $showImage=0;
        }
        if(isset($_POST["photoOrder"]))
        {
            if($_POST["photoOrder"] =="creator")
            {
                $orderBy ="user_id";
            }else if($_POST["photoOrder"] =="album")
            {
                $orderBy ="album_id";
            }
        }
        $message =showPhotoReport($conn,$search,$searchValue,$showImage,$orderBy);
        echo $message;
    }

    if (isset($_POST["function"])) {
        if ($_POST["function"] == "showAdvancedSettings") {
            echo showAdvancedSetting();
        }
    }

    if (isset($_POST["search"])) {
        if ($_POST["search"] == "search") {

            if(isset($_POST["albumTitle"]))
            {
                $searchType = $_POST["albumTitle"];
            }
        } else if ($_POST["search"] == "all") {
            $searchType = "all";
        }

        if (isset($_POST["images"])) {
            $images = 1;
        } else {
            $images = 0;
        }
        if (isset($_POST["albumViews"])) {
            $Albumviews = 1;
        } else {
            $Albumviews = 0;
        }
        if(isset($_POST["totalPhotos"]))
        {
            $totalPhotos=1;
        }
        else
        {
            $totalPhotos=0;
        }
        if (isset($_POST["albumOrder"])) {
            if ($_POST["albumOrder"] == "orderTitle") {
                $orderBy = "album_title";
            } else if ($_POST["albumOrder"] == "orderId") {
                $orderBy = "album_id";
            } else if ($_POST["albumOrder"] == "LowOrderViews") {
                $orderBy = "album_views ASC";
            } else if ($_POST["albumOrder"] == "highOrderViews") {
                $orderBy = "album_views DESC";
            }
        }
       $message =  albumReport($conn, $searchType, $images, $Albumviews,$totalPhotos, $orderBy);
        echo $message;
    }

    if (isset($_POST["type"])) {
        if ($_POST["type"] == "default") {
            if ($_POST["order"] == "fname") {
                $message = showAllUsers($conn, "user_fname");
            } else if ($_POST["order"] == "lname") {
                $message = showAllUsers($conn, "user_lname");
            } else if ($_POST["order"] == "newest") {
                $message = showAllUsers($conn, "user_creationDate DESC");
            } else if ($_POST["order"] == "oldest") {
                $message = showAllUsers($conn, "user_creationDate ASC");
            } else if ($_POST["order"] == "id") {
                $message = showAllUsers($conn, "user_id");
            } else if ($_POST["order"] == "username") {
                $message = showAllUsers($conn, "user_username");
            }
           echo $message;
        } else if ($_POST["type"] == "advanced") {
            if ($_POST["date"] == "allTime") {
                $date = 1;
            } else if ($_POST["date"] == "rangeDate") {
                $date = $_POST["dateS"];
            }
            if (isset($_POST["customerC"])) {
                $customer = 1;
            } else {
                $customer = 0;
            }

            if (isset($_POST["collaboratorC"])) {
                $collab = 1;
            } else {
                $collab = 0;
            }

            if (isset($_POST["adminC"])) {
                $admin = 1;
            } else {
                $admin = 0;
            }
            if (isset($_POST["showViews"])) {
                $views = 1;
            } else {
                $views = 0;
            }
            $search = $_POST["lastNameS"];

            if ($_POST["order"] == "fname") {
                $orderBy = "user_fname";
            } else if ($_POST["order"] == "lname") {
                $orderBy = "user_lname";
            } else if ($_POST["order"] == "newest") {
                $orderBy = "user_creationDate DESC";
            } else if ($_POST["order"] == "oldest") {
                $orderBy = "user_creationDate ASC";
            } else if ($_POST["order"] == "id") {
                $orderBy = "user_id";
            } else if ($_POST["order"] == "username") {
                $orderBy = "user_username";
            } else if ($_POST["order"] == "lowViews") {
                $orderBy = "totalViews ASC";
            } else if ($_POST["order"] == "HighViews") {
                $orderBy = "totalViews DESC";
            }

            $message = showAllusersAdvanced($conn, $date, $customer, $collab, $admin, $views, $search, $orderBy);
            echo $message;
        }
    }
}