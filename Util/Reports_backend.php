<?php
    session_start();
    require "dbconn.php";

    $type = $_POST['type'];
    $table = $_POST['subject'];
    $input_1 = $_POST['input_1'];
    $input_2 = $_POST['input_2'];

    //echo json_encode($type.','.$table.','.$input_1.','.$input_2);

    $return = '';
    $err = false;
    //require another sql query?
    $req_sql_2 = false;

    $sql = '';
    //for finding a user id based off a username
    $sql_2 = '';
    $sql_2_res = '';
    $username = '';
    //$test = 'works';

    //if($type == 'detail'){
        //$return .= $test;
    //}

    switch($type){
        case 'detail':
            switch($table){
                case 'user':
                    //$return = 'user!';
                    $sql = 'SELECT user_id,user_lname,user_fname,user_username,
                            user_email,user_authentcation,user_creationDate FROM '.$table;
                    break;
                case 'photo':
                    //$sql = 'SELECT photo_id,album_id,user_id,photo_img FROM'.$table;
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM '.$table;
                    break;
                case 'album':
                    $sql = 'SELECT album_id,user_id,album_title,album_label,album_img FROM '.$table;
                    break;
                default:
                    $return = 'Error!';
                    $err = true;
                    break;
            }
            break;
        case 'summary':
            //$return .= 's';
            switch($table){
                case 'user':
                    $sql = 'SELECT user_id,user_authentication FROM '.$table;
                    break;
                case 'photo': //probably dont need the image for summary reports
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM '.$table;
                    break;
                case 'album': //same here
                    $sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM '.$table;
                    break;
                default:
                    $return = 'Error!';
                    $err = true;
                    break;
            }
            break;
        case 'exception':
            //$return .= 'e';
            switch($table){
                case 'user':
                    $sql = 'SELECT user_id,user_lname,user_fname,user_username,
                            user_email,user_authentcation,user_creationDate FROM '.$table.
                            ' WHERE user_authentication = '.$input_1.' ORDER BY '.$input_2;
                    break;
                case 'photo':
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM '.$table.
                           ' WHERE user_id = '.$sql_2_res;
                    $req_sql_2 = true;
                    break;
                case 'album':
                    $sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM '.$table.
                           ' WHERE user_id = '.$sql_2_res;
                    $req_sql_2 = true;
                    break;
                default:
                    $return = 'Error!';
                    $err = true;
                    break;
            }
            break;
        default:
            $return .= 'not found';
            $err = true;
            break;
    }

    if(!$err){
        //no that data has been validated and the main sql statement has been constructed, the table can begin to be constructed
        if($req_sql_2)
        {
            $sql_2 = 'SELECT user_id FROM user WHERE user_username = '.trim($input_1);
            $res_2 = $conn->query($sql_2);
            if($res_2->num_rows > 0)
            {
                //run queries and then put into $result var

            }
        }
    }


    //echo json_encode($sql);
    //echo json_encode('<p><b>HELLO</b></p>');


    //echo json_encode($test1);
    //echo json_encode($test1.','.$test2.','.$test3.','.$test4);

?>