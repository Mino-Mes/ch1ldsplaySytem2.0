<?php
    session_start();
    require "dbconn.php";

    $type = $_POST['type'];
    $table = $_POST['subject'];
    //try to trim this
    $input_1 = trim($_POST['input_1']);
    $input_2 = $_POST['input_2'];

    $return = '';
    $err = false;
    //require another sql query?
    $req_sql_2 = false;

    $sql = '';

    //put some input validation up here

    switch($type){
        case 'detail':
            switch($table){
                case 'user':
                    //$return = 'user!';
                    $sql = 'SELECT user_id,user_lname,user_fname,user_username,user_email,user_authentcation,user_creationDate FROM user';
                    break;
                case 'photo':
                    //$sql = 'SELECT photo_id,album_id,user_id,photo_img FROM'.$table;
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                    break;
                case 'album':
                    $sql = 'SELECT album_id,user_id,album_title,album_label,album_img FROM album';
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
                    //$sql = 'SELECT user_id,user_authentication FROM '.$table;
                    $sql = 'SELECT user_id, user_authentication FROM user';
                    break;
                case 'photo': //probably dont need the image for summary reports
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                    break;
                case 'album': //same here
                    $sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM album';
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
                    $sql = "SELECT user_id,user_lname,user_fname,user_email,user_authentication,user_username,user_creationDate FROM user WHERE user_authentication = '".$input_1."' ORDER BY ".$input_2;
                    break;
                case 'photo':
                    //$sql = 'SELECT photo_id,album_id,user_id,photo_img FROM '.$table.
                           //' WHERE user_id = '.$sql_2_res;
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo WHERE user_id = ';
                    $req_sql_2 = true;
                    break;
                case 'album':
                    //$sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM '.$table.
                           //' WHERE user_id = '.$sql_2_res;
                    $sql = 'SELECT * FROM album WHERE user_id = ';
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
        //now that data has been validated and the main sql statement has been constructed, the table can begin to be constructed

        if($req_sql_2)
        {   //most of these vars can probably just be declared in this scope
            $sql_2 = "SELECT user_id FROM user WHERE user_username = '".$input_1."'";
            //$sql_2_res = ''; <- probably isn't needed
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
        //execute some sql
        /*
        $res = $conn->query($sql);
        if($res->num_rows>0){
            while($row=$res->fetch_assoc())
            {
                $return = $row['user_id'];
            }
        }
        */


        //$return = '<p><b>HELLO</b></p>';
        //$return .= '<p><b>WORLD</b></p>';
    }
    else{
        $return = 'Error!';
    }



    echo json_encode($return);
    //echo json_encode('<p><b>HELLO</b></p>');

?>