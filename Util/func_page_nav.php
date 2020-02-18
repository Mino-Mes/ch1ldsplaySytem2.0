<?php
    function update_nav(){
        //Depending on where this is implemented, you may not need the jquery import, so remove it if it's redundant
        //also just make sure to check that your page has the right html elements
        ?>
        <script src="../assets/js/jquery.min.js"></script>
        <script>
            $(document).ready(function(){

                var sb_txt = '';

                <?php
                if(isset($_SESSION['ln_username']) && isset($_SESSION['ln_usertype']) && !isset($_SESSION['ln_already'])){
                //in here, let's determine the type of user
                $_SESSION['ln_already'] = true;
                switch($_SESSION['ln_usertype']){
                case 'customer':
                case 'collaborator':
                ?>
                document.getElementById('nav_ul').innerHTML += '<li><a href="">Your Photographs</a></li>';
                sb_txt = 'Login Successful!';

                <?php
                break;
                case 'administrator':
                ?>
                document.getElementById('nav_ul').innerHTML += '<li><a href="Manage_users.php">Manage Users</a></li><li><a href="Reports.php">Reports</a></li>';
                sb_txt = 'Login Successful!';
                <?php
                break;
                case 'banned':
                //since the user is banned, we will unset the session
                unset($_SESSION['ln_username']);
                unset($_SESSION['ln_usertype']);
                ?>
                sb_txt = 'Login Failed: you are banned!';
                <?php
                break;
                }
                ?>
                document.getElementById('parent_log_reg_btn')
                    .innerHTML="<span id='btn_logout' class='slowOver btn_reg_log'><a href='../Util/logout.php'>Logout</a></span>";

                var sb = document.getElementById('ln_snackbar');
                sb.innerHTML = sb_txt;
                sb.className = 'show';
                setTimeout(function(){ sb.className = sb.className.replace('show', ''); }, 3000);
                <?php
                }
                ?>

            });
        </script>
        <?php
    }
?>

