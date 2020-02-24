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
                                            <h4>Creator Views</h4>
                                            <input type=\"checkbox\" name=\"showViews\" id=\"showViews\" onclick=\"orderByViews()\">
                                            <label for=\"showViews\">Show Creator Views</label>
                                            <h4>Creator</h4>
                                            <input type=\"checkbox\" name=\"albumsC\" id=\"albumsC\">
                                            <label for=\"albumsC\">Number of Albums</label>
                                            <input type=\"checkbox\" name=\"photoC\" id=\"photoC\">
                                            <label for=\"photoC\">Number of Photographs</label>
                                        </div>
                                        <div class=\"col-6\">
                                            <h4>Search a user</h4>
                                            <label for=\"lastNameS\">by Last Name</label>
                                            <input type=\"text\" name=\"lastNameS\" id=\"lastNameS\" style=\"width:30%;margin-left:36%;\">
                                        </div>
                                         <div class=\"col-6\">   
                                            <label for=\"usernameS\">by Username</label>
                                            <input type=\"text\" name=\"usernameS\" id=\"usernameS\" style=\"width:30%;margin-left:36%;\">

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

function showAllusersAdvanced($conn,$date,$customer,$collab,$admin,$views,$album,$photo,$orderBy)
{
    $dateisSet=false;
    $sql = "SELECT * FROM USER ";
    if($date != 1)
    {
       $fdate= date('Y-m-d', strtotime($date));
        $sql .=" WHERE user_creationDate > $fdate ";
        $dateisSet=true;
    }

    if($dateisSet)
    {
        if($customer == 1 && $date)
        {
            $sql .= "AND user_authentication ='customer' ";
        }
        if($collab == 1 && $customer == 1)
        {
            $sql .=" OR user_authentication = 'collaborator'";
        }else if($collab ==1 && $customer==0)
        {
            $sql .= "AND user_authentication ='collaborator'";
        }
        if($admin == 1 && $collab ==1 )
        {
            $sql .= " OR user_authentication ='administrator'";
        }else if($admin == 1 && $customer ==1)
        {
            $sql .= " OR user_authentication LIKE 'administrator'";
        }else if($admin == 1 && $customer ==0 && $collab ==0)
        {
            $sql .="AND user_authentication ='administrator'";
        }
    }else if(!$dateisSet)
    {
        if($customer == 1 && $date)
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
            $sql .= " OR user_authentication LIKE 'administrator'";
        }else if($admin == 1 && $customer ==0 && $collab ==0)
        {
            $sql .="WHERE user_authentication ='administrator'";
        }
    }



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

            if (isset($_POST["albumsC"])) {
                    $album=1;
            } else {
                    $album=0;
            }
            if (isset($_POST["photoC"])) {
                    $photo=1;
            } else {
                    $photo=0;
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
            }

            $message =showAllusersAdvanced($conn,$date,$customer,$collab,$admin,$views,$album,$photo,$orderBy);
            echo $message;
        }
    }
}