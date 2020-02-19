<?php
session_start();
require "dbconn.php";

$type = $_POST['type'];
$table = $_POST['subject'];
//try to trim this
$input_1 = trim($_POST['input_1']);
$input_2 = $_POST['input_2'];

$return='';
$err = false;
//require another sql query?
$req_sql_2 = false;


$sql = '';

$test = '';

//let's see if we can get all the values
//$return = $type.','.$table.','.$input_1.','.$input_2;
//good, make sure to validate that $input_1 isn't empty if
//a exception report for album or photo is requested

switch($type)
{
    case 'summary':
        $return .= $type.',';
        switch($table){
            case 'user':
                $return .= $table.',';
                $sql = 'SELECT user_id, user_authentication FROM user';
                break;
            case 'photo':
                $return .= $table.',';
                $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                break;
            case 'album':
                $return .= $table.',';
                $sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM album';
                break;
            default:
                $err = true;
                break;
        }
        break;
    case 'detail':
        $return .= $type.',';
        switch($table){
            case 'user':
                $return .= $table.',';
                $sql = 'SELECT user_id,user_lname,user_fname,user_username,user_email,user_authentication,user_creationDate FROM user';
                break;
            case 'photo':
                $return .= $table.',';
                $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                break;
            case 'album':
                $return .= $table.',';
                $sql = 'SELECT album_id,user_id,album_title,album_label,album_img FROM album';
                break;
            default:
                $err = true;
                break;
        }
        break;
    case 'exception':
        $return .= $type.',';
        switch($table){
            case 'user':
                $return .= $table.',';
                $sql = "SELECT user_id,user_lname,user_fname,user_email,user_authentication,user_username,user_creationDate FROM user WHERE user_authentication = '".$input_1."' ORDER BY ".$input_2;
                break;
            case 'photo':
                $return .= $table.',';
                $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo WHERE user_id = ';
                $req_sql_2 = true;
                if(empty($input_1) || empty($input_2)){
                    $err = true;
                }
                break;
            case 'album':
                $return .= $table.',';
                $sql = 'SELECT * FROM album WHERE user_id = ';
                $req_sql_2 = true;
                if(empty($input_1) || empty($input_2)){
                    $err = true;
                }
                break;
            default:
                $err = true;
                break;
        }
        break;
}

if(!$err){
    //now that inputs have been validated and sql statements have
    //been constructed, let's do the rest
    if($req_sql_2){
        $sql_2 = "SELECT user_id FROM user WHERE user_username = '".$input_1."'";
        $user_id = '';

        $res=$conn->query($sql_2);
        if($res->num_rows>0){
            while($row=$res->fetch_assoc())
            {
                $user_id = $row['user_id'];
            }
        }
        $sql .= $user_id;

    }
    //now that this conditional if statement is out of the way,
    //let's get to the next big switch

    //for testing
    //$return = '';

    switch($type){
        case 'summary':
            //$return .= $type.',';
            switch($table){
                case 'user':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $users = 0;
                        $customer = 0;
                        $collab =0;
                        $admin = 0;
                        $banned = 0;

                        while($row = $res->fetch_assoc()){
                            $users++;
                            switch($row['user_authentication']){
                                case 'customer':
                                    $customer++;
                                    break;
                                case 'collaborator':
                                    $collab++;
                                    break;
                                case 'administrator':
                                    $admin++;
                                    break;
                                case 'banned':
                                    $banned++;
                                    break;
                            }
                            $return =
                                '<p>There are '.$users.' total users</p>'.
                                '<p>'.$customer.' customers</p>'.
                                '<p>'.$collab.' collaborators</p>'.
                                '<p>'.$admin.' admins</p>'.
                                '<p>'.$banned.' banned users</p>';

                        }
                    }
                    break;
                case 'photo':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $photos = 0;

                        while($row = $res->fetch_assoc()){
                            $photos++;
                        }
                        $return = '<p>There are a total of '.$photos.' photos</p>';
                    }
                    break;
                case 'album':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $albums = 0;

                        while($row = $res->fetch_assoc()){
                            $albums++;
                        }
                        $return = '<p>There are a total of '.$albums.' albums</p>';
                    }
                    break;
                default:
                    break;
            }
            break;
        case 'detail':
            //$return .= $type.',';
            switch($table){
                case 'user':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>ID</th>'.
                            '<th>Last name</th>'.
                            '<th>First name</th>'.
                            '<th>Username</th>'.
                            '<th>Email</th>'.
                            '<th>Type</th>'.
                            '<th>Date created</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td>'.$row['user_lname'].'</td>'.
                                '<td>'.$row['user_fname'].'</td>'.
                                '<td>'.$row['user_username'].'</td>'.
                                '<td>'.$row['user_email'].'</td>'.
                                '<td>'.$row['user_authentication'].'</td>'.
                                '<td>'.$row['user_creationDate'].'</td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    break;
                case 'photo':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>Photo ID</th>'.
                            '<th>Album ID</th>'.
                            '<th>User ID</th>'.
                            '<th>Photo</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['photo_id'].'</td>'.
                                '<td>'.$row['album_id'].'</td>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td><img src="'.$row['photo_img'].'" height="25" width="25"></td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    break;
                case 'album':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>Album ID</th>'.
                            '<th>User ID</th>'.
                            '<th>Album title</th>'.
                            '<th>Album label</th>'.
                            '<th>Album image</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['album_id'].'</td>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td>'.$row['album_title'].'</td>'.
                                '<td>'.$row['user_label'].'</td>'.
                                '<td><img src="'.$row['album_img'].'" height="25" width="25"></td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    break;
                default:
                    break;
            }
            break;
        case 'exception':
            //$return .= $type.',';
            switch($table){
                case 'user':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>ID</th>'.
                            '<th>Last name</th>'.
                            '<th>First name</th>'.
                            '<th>Username</th>'.
                            '<th>Email</th>'.
                            '<th>Type</th>'.
                            '<th>Date created</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td>'.$row['user_lname'].'</td>'.
                                '<td>'.$row['user_fname'].'</td>'.
                                '<td>'.$row['user_username'].'</td>'.
                                '<td>'.$row['user_email'].'</td>'.
                                '<td>'.$row['user_authentication'].'</td>'.
                                '<td>'.$row['user_creationDate'].'</td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    else{
                        $return = 'No records of this type found.';
                    }
                    break;
                case 'photo':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>Photo ID</th>'.
                            '<th>Album ID</th>'.
                            '<th>User ID</th>'.
                            '<th>Photo</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['photo_id'].'</td>'.
                                '<td>'.$row['album_id'].'</td>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td><img src="'.$row['photo_img'].'" height="25" width="25"></td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    else{
                        $return = 'No records of this type found.';
                    }
                    break;
                case 'album':
                    //$return .= $table;
                    $res = $conn->query($sql) or die ('Error: Database Error');
                    if($res->num_rows > 0){
                        $return =
                            '<div class="table-wrapper"><table>'.
                            '<thead>'.
                            '<tr>'.
                            '<th>Album ID</th>'.
                            '<th>User ID</th>'.
                            '<th>Album title</th>'.
                            '<th>Album label</th>'.
                            '<th>Album image</th>'.
                            '</tr>'.
                            '</thead><tbody>';
                        while($row = $res->fetch_assoc()){
                            $return .=
                                '<tr>'.
                                '<td>'.$row['album_id'].'</td>'.
                                '<td>'.$row['user_id'].'</td>'.
                                '<td>'.$row['album_title'].'</td>'.
                                '<td>'.$row['album_label'].'</td>'.
                                '<td><img src="'.$row['album_img'].'" height="25" width="25"></td>'.
                                '</tr>';
                        }
                        $return .= '</tbody></table>';
                    }
                    break;
                default:
                    break;
            }
            break;
    }
}
else{
    $return = 'Error: cannot generate report.';
}

echo json_encode($return);



?>