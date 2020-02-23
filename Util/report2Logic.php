<?php
require "dbconn.php";

function showAdvancedSetting()
{
    return "<label>Date</label>"
            ."<input type='radio' name='date' id='all'>"
            ."<br>"
             ."<label User Type </label>"
            ."<input type='checkbox' value='customer' name='customer' id='customer'>"
            ."<input type='checkbox' value='collaborator' name='collaborator' id='collaborator'>";
}
function showAllUsers($conn)
{
    $sql ="SELECT * FROM USER";
    $result=$conn->query($sql);

    $table="";
    if($result->num_rows >0)
    {
        $table .= "<h4>List of All Users</h4>"
            ."<div class='table-wrapper'>"
            ."<table>"
            ."<thead>"
            ."<tr>"
            ."<th>user_id</th>"
            ."<th>Last Name</th>"
            ."<th>First Name</th>"
            ."<th>Email</th>"
            ."<th>Authentication Level</th>"
            ."<th>Username</th>"
            ."<th>Creation Date</th>"
            ."</tr>"
            ."</thead>"
            ."<tbody>";


        while($row=$result->fetch_assoc())
        {
            $table .="<tr>"
                    ."<td>".$row["user_id"]."</td>"
                    ."<td>".$row["user_lname"]."</td>"
                    ."<td>".$row["user_fname"]."</td>"
                    ."<td>".$row["user_email"]."</td>"
                    ."<td>".$row["user_authentication"]."</td>"
                    ."<td>".$row["user_username"]."</td>"
                    ."<td>".$row["user_creationDate"]."</td>"
                    ."</tr>";
        }

        $table.= "</tbody>"
                ."</table>"
                ."</div>";
    }

    return $table;
}

if(isset($_POST))
{
    if($_POST["function"] == "showAllUsers")
    {
        $message = showAllUsers($conn);
        echo $message;
    }

    if($_POST["function"] =="showAdvancedSettings")
    {
        echo showAdvancedSetting();
    }
}