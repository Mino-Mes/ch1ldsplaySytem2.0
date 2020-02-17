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
                    $return .= ' DETAIL - USER';
                    break;
                case 'photo':
                    //$sql = 'SELECT photo_id,album_id,user_id,photo_img FROM'.$table;
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                    $return .= ' DETAIL - PHOTO ';
                    break;
                case 'album':
                    $sql = 'SELECT album_id,user_id,album_title,album_label,album_img FROM album';
                    $return .= ' DETAIL - ALBUM ';
                    break;
                default:
                    $return = 'Error!1';
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
                    $return .= ' SUMMARY - USER ';
                    //this is just here for testing purposes
                    $res = $conn->query('SELECT * FROM user') or die ('ERROR: Database Error');
                    if($res->num_rows > 0)
                    {
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
                        $return = 'No data found!';
                    }
                    break;
                case 'photo': //probably dont need the image for summary reports
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo';
                    $return .= ' SUMMARY - PHOTO  ';
                    break;
                case 'album': //same here
                    $sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM album';
                    $return .= ' SUMMARY - ALBUM ';
                    break;
                default:
                    $return = 'Error!2';
                    $err = true;
                    break;
            }
            break;
        case 'exception':
            //$return .= 'e';
            switch($table){
                case 'user':
                    $sql = "SELECT user_id,user_lname,user_fname,user_email,user_authentication,user_username,user_creationDate FROM user WHERE user_authentication = '".$input_1."' ORDER BY ".$input_2;
                    $return .= ' EXCEPTION - USER ';
                    break;
                case 'photo':
                    //$sql = 'SELECT photo_id,album_id,user_id,photo_img FROM '.$table.
                           //' WHERE user_id = '.$sql_2_res;
                    $sql = 'SELECT photo_id,album_id,user_id,photo_img FROM photo WHERE user_id = ';
                    $req_sql_2 = true;
                    $return .= ' EXCEPTION - PHOTO ';
                    break;
                case 'album':
                    //$sql = 'SELECT album_id,user_id,album_tite,album_label,album_img FROM '.$table.
                           //' WHERE user_id = '.$sql_2_res;
                    $sql = 'SELECT * FROM album WHERE user_id = ';
                    $return .= ' EXCEPTION - ALBUM ';
                    $req_sql_2 = true;
                    break;
                default:
                    $return = 'Error!3';
                    $err = true;
                    break;
            }
            break;
        default:
            $return = 'not found';
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

        //need to use another switch to determine the type of output that is needed
        switch($type){
            case 'detail':
                switch($table){
                    case 'user':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
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
                            $return = 'No data found!';
                        }
                        break;
                    case 'photo':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        //
                        break;
                    case 'album':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        ///
                        break;
                    default:
                        $return = 'Error!4';
                        break;
                }
                break;
            case 'summary':
                switch($table){
                    case 'user':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        break;
                    case 'photo':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        //
                        break;
                    case 'album':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        ///
                        break;
                    default:
                        $return = 'Error!5';
                        break;
                }
                //
                break;
            case 'exception':
                switch($table){
                    case 'user':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        break;
                    case 'photo':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        //
                        break;
                    case 'album':
                        $res = $conn->query($sql) or die ('ERROR: Database Error');
                        if($res->num_rows > 0)
                        {
                            while($row = $res->fetch_assoc()){

                            }
                        }
                        ///
                        break;
                    default:
                        $return = 'Error!6';
                        break;
                }
                ///
                break;
            default:
                $return = 'Error!7';
                break;
        }

        //$return = '<p><b>HELLO</b></p>';
        //$return .= '<p><b>WORLD</b></p>';
    }
    else{
        $return .= 'Error!8';
    }

    //$sql->close();
    //$sql_2->close();
    //$conn->close();

    $return .= 'what';
    echo json_encode($return);
    //echo json_encode('<p><b>HELLO</b></p>');

?>