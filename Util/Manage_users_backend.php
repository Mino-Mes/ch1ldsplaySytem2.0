<?php
require "dbconn.php";
//include 'Auth_security.php';

if ($conn == false) {
    die("ERROR: Could not connect!"
        . mysqli_connect_error());
}

if (isset($_REQUEST['term'])) {
    $noBindParam=false;
    if ($_REQUEST['term'] == "All") {
        $sql = $sql = 'SELECT * FROM user';
        $noBindParam=true;
    }else
    {
        $sql = 'SELECT * FROM user WHERE user_username LIKE ?';
    }


    if ($stmt = mysqli_prepare($conn, $sql)) {

        if(!$noBindParam)
        {
            mysqli_stmt_bind_param($stmt, 's', $param_term);
            $param_term = $_REQUEST['term'] . '%';
        }


        //execute a prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-wrapper"><table>'
                    . '<thead>'
                    . '<tr>'
                    . '<th>Last Name</th>'
                    . '<th>First Name</th>'
                    . '<th>Email Address</th>'
                    . '<th>Username</th>'
                    . '<th>Authentication</th>'
                    . '<th>Actions</th>'
                    . '</tr>'
                    . '</thead><tbody>';

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    //there needs to be another hidden form value here whose value is the username
                    //this will allow us to keep track, instead of sending all the user information, we will
                    //just send that since we'll be accessing the db using that username anyway
                    echo '<tr>'
                        . '<td>' . $row['user_lname'] . '</td>'
                        . '<td>' . $row['user_fname'] . '</td>'
                        . '<td>' . $row['user_email'] . '</td>'
                        . '<td>' . $row['user_username'] . '</td>'
                        . '<td>' . $row['user_authentication'] . '</td>';

                    //strtolower are used here just in case
                    if (strtolower($row['user_authentication']) == 'banned') {
                        echo '<td><form method="post" action="../Util/Manage_users_modify.php">'
                            . '<input type="hidden" name="action" value="unban">'
                            . '<input type="hidden" name="user" value="' . $row['user_username'] . '">'
                            . '<input id="unban_' . $row['user_username'] . '" id="btn_unban" class="btn" type="submit" value="UNBAN"></form></td>';
                    }

                    if (strtolower($row['user_authentication']) != 'collaborator' && strtolower($row['user_authentication']) != 'banned') {
                        echo '<td><form method="post" action="../Util/Manage_users_modify.php">'
                            . '<input type="hidden" name="action" value="promote">'
                            . '<input type="hidden" name="user" value="' . $row['user_username'] . '">'
                            . '<input id="promote_' . $row['user_username'] . '" id="btn_promote" class="btn" type="submit" value="PROMOTE"></form></td>';
                    }

                    if (strtolower($row['user_authentication']) == 'collaborator') {
                        echo '<td><form method="post" action="../Util/Manage_users_modify.php">'
                            . '<input type="hidden" name="action" value="demote">'
                            . '<input type="hidden" name="user" value="' . $row['user_username'] . '">'
                            . '<input id="demote_' . $row['user_username'] . '" id="btn_demote" class="btn" type="submit" value="DEMOTE"></form></td>';
                    }

                    if (strtolower($row['user_authentication']) != 'banned') {
                        echo '<td><form method="post" action="../Util/Manage_users_modify.php">'
                            . '<input type="hidden" name="action" value="ban">'
                            . '<input type="hidden" name="user" value="' . $row['user_username'] . '">'
                            . '<input id="ban_' . $row['user_username'] . '" id="btn_ban" class="btn" type="submit" value="BAN"></form></td>'
                            . '<td><form method="post" action="hrefgoeshere.php">'
                            . '<input type="hidden" name="action" value="add">'
                            . '<input type="hidden" name="user" value="' . $row['user_username'] . '">';
                    }
                }
                echo '</tbody></tr></table>';
            } else {
                echo '<p>No matches found!</p>';
            }
        } else {
            echo 'ERROR: Could not execute' . $sql . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>