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

function showAllusersAdvanced($conn,$date,$customer,$collab,$admin,$views,$search,$orderBy)
{
    $dateisSet=false;
    $sql = "SELECT * FROM USER ";
    if($date != 1)
    {
        $sql .="WHERE user_creationDate < '".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)))."' ";
        $dateisSet =true;
    }

    if($dateisSet)
    {
        if($customer == 1)
        {
            $sql .= " AND user_authentication ='customer' ";
        }
        if($collab == 1 && $customer == 1)
        {
            $sql .=" OR user_authentication = 'collaborator'";
        }else if($collab ==1 && $customer==0)
        {
            $sql .= " AND user_authentication ='collaborator'";
        }
        if($admin == 1 && $collab ==1 )
        {
            $sql .= " OR user_authentication ='administrator'";
        }else if($admin == 1 && $customer ==1)
        {
            $sql .= " OR user_authentication LIKE 'administrator'";
        }else if($admin == 1 && $customer ==0 && $collab ==0)
        {
            $sql .=" AND user_authentication ='administrator'";
        }
    }else if(!$dateisSet)
    {
        if($customer == 1 )
        {
            $sql .= "WHERE user_authentication ='customer' ";
        }
        if($collab == 1 && $customer == 1)
        {
            $sql .=" OR user_authentication = 'collaborator'";
        }else if($collab ==1 && $customer==0)
        {
            $sql .= "WHERE user_authentication ='collaborator'";
        }
        if($admin == 1 && $collab ==1 )
        {
            $sql .= " OR user_authentication ='administrator'";
        }else if($admin == 1 && $customer ==1)
        {
            $sql .= " OR user_authentication = 'administrator'";
        }else if($admin == 1 && $customer ==0 && $collab ==0)
        {
            $sql .="WHERE user_authentication ='administrator'";
        }
    }

    $isView=false;
    if($views==1)
    { $isView=true;
        if($dateisSet)
        {
            $sql = "SELECT * FROM USER WHERE user_creationDate < '".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)))."'AND user_authentication ='collaborator' OR user_authentication = 'administrator'";
        }else if(!$dateisSet)
        {
            $sql = "SELECT * FROM USER WHERE user_authentication ='collaborator' OR user_authentication = 'administrator'";
        }
    }

    if($search != 0)
    {
        $isView=false;
        if($dateisSet)
        {
            $sql = "SELECT * FROM USER WHERE user_creationDate < '".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)))."'AND user_lname ='$search'";
        }else if(!$dateisSet)
        {
            $sql = "SELECT * FROM USER WHERE user_lname ='$search'";
        }
    }

    $sql .= " ORDER BY ".$orderBy;

//return $sql;

    $result = $conn->query($sql) or die("Error: ". $conn->error);

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
            if($isView)
            {
                $table.="<th>Total Views</th>";
                $table.="<th>Album Created</th>";
                $table.="<th>Photo Created</th>";
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
                if($isView)
                {
                    $table .= "<td>" . $row["totalViews"] . "</td>";
                    $sql2="SELECT count('user_id') as 'countUser' FROM album WHERE user_id=".$row["user_id"];
                    $result2=$conn->query($sql2);
                    if($result2->num_rows>0)
                    {
                        while($row2=$result2->fetch_assoc())
                        {
                            $table .= "<td>" . $row2["countUser"] . "</td>";
                        }
                    }
                    $sql3="SELECT count('user_id') as 'countUser' FROM photo WHERE user_id=".$row["user_id"];
                    $result3=$conn->query($sql3);
                    if($result3->num_rows>0)
                    {
                        while($row3=$result3->fetch_assoc())
                        {
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

if (isset($_POST)) {
    /*  if($_POST["function"] == "showAllUsers")
      {
          $message = showAllUsers($conn);
          echo $message;
      }
  */
    if (isset($_POST["function"])) {
        if ($_POST["function"] == "showAdvancedSettings") {
            echo showAdvancedSetting();
        }
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
                $date=1;
            } else if ($_POST["date"] == "rangeDate") {
                    $date =$_POST["dateS"];
            }
            if (isset($_POST["customerC"])) {
                   $customer=1;
            } else {
                $customer=0;
            }

            if (isset($_POST["collaboratorC"])) {
                    $collab=1;
            } else {
                $collab=0;
            }

            if (isset($_POST["adminC"])) {
                    $admin=1;
            } else {
                    $admin=0;
            }
            if (isset($_POST["showViews"])) {
                    $views=1;
            } else {
                    $views=0;
            }
            if(!empty($_POST["lastNameS"]) && isset($_POST["lastNameS"]))
            {
                $search=$_POST["lastNameS"];
            }else
            {
                $search=0;
            }

            if ($_POST["order"] == "fname") {
              $orderBy ="user_fname";
            } else if ($_POST["order"] == "lname") {
                $orderBy ="user_lname";
            } else if ($_POST["order"] == "newest") {
                $orderBy ="user_creationDate DESC";
            } else if ($_POST["order"] == "oldest") {
                $orderBy ="user_creationDate ASC";
            } else if ($_POST["order"] == "id") {
                $orderBy ="user_id";
            } else if ($_POST["order"] == "username") {
                $orderBy ="user_username";
            }else if($_POST["order"] == "lowViews")
            {
                $orderBy ="totalViews ASC";
            }else if($_POST["order"] == "HighViews")
            {
                $orderBy ="totalViews DESC";
            }

            $message =showAllusersAdvanced($conn,$date,$customer,$collab,$admin,$views,$search,$orderBy);
            echo $message;
        }
    }
}