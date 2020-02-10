<script>
    $(document).ready(function(){

        var nav_a = document.getElementById('nav_a');
        var sb_txt = '';
        //two session variables that are set on successful login attempt
        //we'll also inlude a snackbar in here aswell

        //WORK OUT THIS FOR MOBILE AS WELL (PROBABLY NEEDS TO BE DONE IN THE MAIN JS FILE)

        <?php
            if(isset($_SESSION['ln_username']) && isset($_SESSION['ln_usertype']) && !isset($_SESSION['ln_already'])){
                //in here, let's determine the type of user
                $_SESSION['ln_already'] = true;
                switch($_SESSION['ln_usertype']){
                    case 'customer':
                    case 'collaborator':
                        ?>
                            nav_a.innerHTML = 'Your Photographs';
                            nav_a.setAttribute('href',''); // <-- add to this later
                            sb_txt = 'Login Successful!';
                        <?php
                        break;
                    case 'administrator':
                        ?>
                            nav_a.innerHTML = 'Manage Users';
                            nav_a.setAttribute('href','../Util/manage_users.php');
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
                        .innerHTML="<span id='btn_logout' class='slowOver btn_reg_log'><a href='../Util/logout.php'>Logout</a></span>"
                    //create a logout file to unset some session vars,
                    //and change back the the above element

                    var sb = document.getElementById('ln_snackbar');
                    sb.innerHTML = sb_txt;
                    sb.className = 'show';
                    setTimeout(function(){ sb.className = sb.className.replace('show', ''); }, 3000);
                <?php
            }
        ?>





    });


</script>