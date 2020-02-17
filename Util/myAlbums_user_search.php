<?php
    require 'dbconn.php';
    //require 'Auth_security.php'

    if($conn == false){
        die("ERROR: Could not connect!");
    }

    if(isset($_REQUEST['term'])){
        $sql = 'SELECT * FROM user WHERE user_username LIKE ?';

        if($stmt = mysqli_prepare($conn, $sql)){

            mysqli_stmt_bind_param($stmt,'s',$param_term);

            $param_term = $_REQUEST['term'] . '%';

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) > 0){
                    echo '<div class="table-wrapper"><table>'
                        .'<thead>'
                        .'<tr>'
                        .'<th>Last Name</th>'
                        .'<th>First Name</th>'
                        .'<th>Email Address</th>'
                        .'<th>Username</th>'
                        .'<th>User type</th>'
                        .'</tr>'
                        .'</thead><tbody>';

                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        echo '<tr>'
                            .'<td>'.$row['user_lname'].'</td>'
                            .'<td>'.$row['user_fname'].'</td>'
                            .'<td>'.$row['user_email'].'</td>'
                            .'<td>'.$row['user_username'].'</td>'
                            .'<td>'.$row['user_authentication'].'</td>';
                    }
                    echo '</tr></tbody></table>';
                }
                else{echo '<p>No matches found!</p>';}

            }
            else{echo 'ERROR: Could not execute' .$sql.mysqli_error($conn);}
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>