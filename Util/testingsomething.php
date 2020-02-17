<?php
require "dbconn.php";
?>
<script src="../orange/assets/js/jquery.min.js"></script>
<script src="../orange/assets/js/jquery.dropotron.min.js"></script>
<script src="../orange/assets/js/jquery.scrollex.min.js"></script>
<script src="../orange/assets/js/jquery.scrolly.min.js"></script>
<script src="../orange/assets/js/browser.min.js"></script>
<script src="../orange/assets/js/breakpoints.min.js"></script>
<script src="../orange/assets/js/util.js"></script>
<script src="../orange/assets/js/main.js"></script>
<script>
    $(document).ready(function(){
        //document.write('what');
        /*
        $.ajax({
            url: 'Reports_backend.php', //This is the current doc
            type: "POST",
            dataType:'json', // add json datatype to get json
            data: ({type: '1',input2: '2',input3: '3'}),
            success: function(data){
                //console.log(data);
                document.write(data);
            }
        });
        */

    });
</script>
<?php
    /*
    $y  = '';
    $x = 'hello '.$y;
    $y = ' world';
    echo $x;
    */
    $sql = 'SELECT * FROM user';
    $res=$conn->query($sql);
    if($res->num_rows>0){
        while($row=$res->fetch_assoc())
        {
            echo $row['user_username'];
        }
    }
?>
