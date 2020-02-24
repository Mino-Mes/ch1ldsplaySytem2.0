<?php
    require 'dbconn.php';
    //require 'Auth_security.php'

    if($conn == false){
        die("ERROR: Could not connect!");
    }
$returnString="";
    if(isset($_REQUEST['term'])){
        $noBindParam=false;
        if($_REQUEST['term'] == "All")
        {
            $sql = 'SELECT * FROM user';
            $noBindParam=true;
        }else{
            $sql = 'SELECT * FROM user WHERE user_username LIKE ? OR user_id LIKE ?';
        }

        if($stmt = mysqli_prepare($conn, $sql)){

            if(!$noBindParam)
            {
                mysqli_stmt_bind_param($stmt,'ss',$param_term,$param_term);
            }
            $param_term = $_REQUEST['term'] . '%';

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) > 0){
                    $returnString.= '<table>'
                        .'<thead>'
                        .'<tr>'
                        .'<th>Last Name</th>'
                        .'<th>First Name</th>'
                        .'<th>Email Address</th>'
                        .'<th>Username</th>'
                        .'<th>User type</th>'
                        .'<th>Add Photograph</th>'
                        .'<th>View YourPhotograph</th>'
                        .'</tr>'
                        .'</thead><tbody>';

                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

                       $userId=$row["user_id"];
                        $returnString.= '<tr>'
                            .'<td>'.$row['user_lname'].'</td>'
                            .'<td>'.$row['user_fname'].'</td>'
                            .'<td>'.$row['user_email'].'</td>'
                            .'<td>'.$row['user_username'].'</td>'
                            .'<td>'.$row['user_authentication'].'</td>'
                            .'<td><ul class="actions fit small"><li><a href="javascript:void(0)" class="button fit small" onclick="addPhotoModal('.$userId.')" style="padding-left:1%;padding-right:1%;">Add Photographs</a></li></ul></td>'
                            .'<td><ul class="actions fit small"><li><a href="javascript:void(0)" class="button alt fit small" onclick="showYourPhotographListModal('.$userId.')" style="padding-left:1%;padding-right:1%;">View</a></li></ul></td></tr>';
                    }
                    $returnString .= '</tbody></table>';

                    echo $returnString;
                }
                else{$returnString = '<p>No matches found!</p>';}

            }
            else{echo 'ERROR: Could not execute' .$sql.mysqli_error($conn);}
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>