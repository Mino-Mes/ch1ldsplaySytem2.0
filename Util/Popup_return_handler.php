<?php

//for regs
if(isset($_SESSION['reg_attempt']))
{
    if($_SESSION['reg_attempt'] == true)
    {
        $_SESSION['reg_attempt'] = false;

        $s_var = $_SESSION['reg_msg'];
        ?>
        <script>
            //re-open the form and place the content inside
            document.getElementById('myModal').style.display = 'block';
            document.getElementById('popup_content')
                .innerHTML =
                '<div class="inner"><form method="post" action="../Util/reg.php" class="alt"><div class="row gtr-uniform">' +
                '<div class="col-12"><h2 style="color:black;">REGISTER</h2></div>' +
                '<div class="col-12"><label style="color:black;">First Name</label><input type="text" name="reg_fname" id="reg_fname" value="" placeholder="First Name" required></div>' +
                '<div class="col-12"><label style="color:black;">Last Name</label><input type="text" name="reg_lname" id="reg_lname" value="" placeholder="Last Name" required></div>' +
                '<div class="col-12"><label style="color:black;">Email</label><input type="email" name="reg_email" id="reg_email" value="" placeholder="Email" required></div>' +
                '<div class="col-12"><label style="color:black;">Username</label><input type="text" name="reg_username" id="reg_username" value="" placeholder="Username" required></div>' +
                '<div class="col-12"><label style="color:black;">Password</label><input type="password" name="reg_password" id="reg_pass" value="" placeholder="Password" required></div>' +
                '<div class="col-12"><label style="color:black;">Confirm Password</label><input type="password" name="reg_confirm_password" id="reg_confirm_pass" value="" placeholder="Confirm Password" required></div>' +
                '<div class="col-12" id="center_button" class="reg_log_submit_btn"><input type="submit" value="Register"></div>' +
                '</div></form>' +
                '<h5 id="popup_err_txt" style="color:red;"></h5>' +
                '</div>';

            //get the registration message and put it into a JS var
            var reg_msg = <?php echo json_encode($_SESSION['reg_msg']); ?>;

            //get the form values and put them into a JS array
            var reg_arr_val = {
                'fname': <?php echo json_encode($_SESSION['reg_arr_form_vals']['fname']);?>,
                'lname': <?php echo json_encode($_SESSION['reg_arr_form_vals']['lname']);?>,
                'email': <?php echo json_encode($_SESSION['reg_arr_form_vals']['email']);?>,
                'username': <?php echo json_encode($_SESSION['reg_arr_form_vals']['username']);?>,
                'pass': <?php echo json_encode($_SESSION['reg_arr_form_vals']['pass']);?>,
                'confirm_pass': <?php echo json_encode($_SESSION['reg_arr_form_vals']['confirm_pass']);?>
            };

            //get the php reg error array and put it into a JS array
            var reg_arr_err = {
                'fname': <?php echo json_encode($_SESSION['reg_arr_err']['fname']);?>,
                'lname': <?php echo json_encode($_SESSION['reg_arr_err']['lname']);?>,
                'email': <?php echo json_encode($_SESSION['reg_arr_err']['email']);?>,
                'username': <?php echo json_encode($_SESSION['reg_arr_err']['username']);?>,
                'pass': <?php echo json_encode($_SESSION['reg_arr_err']['pass']);?>,
                'confirm_pass': <?php echo json_encode($_SESSION['reg_arr_err']['confirm_pass']);?>
            };


            //make the form sticky
            <?php
            if(isset($_SESSION['reg_success']) && $_SESSION['reg_success'] == false)
            {
            ?>
            var i = 0;
            for(var key in reg_arr_val)
            {
                document.getElementById('reg_'+Object.keys(reg_arr_val)[i]).value =
                    reg_arr_val[Object.keys(reg_arr_val)[i]];
                i++;
            }
            i = 0;
            //now show highlight the field values that are incorrect
            for(var key in reg_arr_err)
            {
                if(reg_arr_err[key] == true)
                {
                    document.getElementById('reg_'+Object.keys(reg_arr_err)[i])
                        .style.borderColor = 'red';

                }
                i++;

            }
            <?php
            }
            ?>
            //now send back a message
            document.getElementById('popup_err_txt').innerHTML =
            <?php echo json_encode($_SESSION['reg_msg']); ?>;
        </script>
        <?php


    }
}
//for logins
if(isset($_SESSION['log_attempt']))
{
    if($_SESSION['log_attempt'] == true)
    {
        $_SESSION['log_attempt'] = false;

        //a login was just attempted, now let's see if it worked out
        if($_SESSION['log_err'] == true)
        {
            ?>
            <script>
                //re-open the login popup(modal)
                document.getElementById('myModal').style.display = "block";
                document.getElementById("popup_content").innerHTML =
                    '<form method="post" action="../Util/Login.php" class="alt"><div class="row gtr-uniform">'+
                    '<div class="col-12"><h2 style="text-align: center;">Login</h2></div>'+
                    '<div class="col-12"><label style="color:black;">Username / Email</label><input type="text" name="log_username" id="log_username" value="" placeholder="Username or Email" required/></div>'+
                    '<div class="col-12"><label style="color:black;">Password</label><input type="password" name="log_password" id="log_password" value="" placeholder="Password" required/></div>'+
                    '<ul class="actions special" style="margin-top: 4%;">' +
                    ' <li><button class="button next" type="submit">Login</button></li>' +
                    ' </ul>'+
                    '</div></form>'+
                    '<a id="forgot_pass" href="javascript:forgot_pass()">Forgot password?</a>'+
                    '<h5 id="popup_err_txt"></h5>';

                //make the form sticky
                var user = document.getElementById('log_username');
                user.value = <?php echo json_encode($_SESSION['log_username']);?>;
                user.style.borderColor = 'red';

                var pass = document.getElementById('log_password');
                pass.value = <?php echo json_encode($_SESSION['log_pass']);?>;
                pass.style.borderColor = 'red';

                //send back a message
                document.getElementById('popup_err_txt').innerHTML =
                <?php echo json_encode($_SESSION['log_msg']); ?>;

            </script>
            <?php
        }
    }
}
//for pass recovery
if(isset($_SESSION['recover_attempt']))
{
    if($_SESSION['recover_attempt'] == true){
        $_SESSION['recover_attempt'] == false;
        //create a popup with the recovery message
        if($_SESSION['recover_err']) {
            ?>
            <script>
                document.getElementById('myModal').style.display = "block";
                document.getElementById("popup_content").innerHTML =
                    '<form method="post" action="../Util/pass_recovery.php" class="alt"><div class="row gtr-uniform">' +
                    '<div class="col-12"><h2 style="text-align: center;">Recover password</h2></div>' +
                    '<div class="col-12"><label style="color:black;">Email Address</label><input type="email" name="recover_email" id="recover_email" value="" placeholder="Email" required/></div>' +
                    '<ul class="actions special" style="margin-top: 4%;">' +
                    ' <li><button class="button next" type="submit">Recover</button></li>' +
                    ' </ul>' +
                    '</div></form>' +
                    '<a id="forgot_pass" href="javascript:forgot_cancel()">Cancel</a>' +
                    '<h5 id="popup_err_txt"></h5>';

                var recover = document.getElementById('recover_email');
                recover.value = <?php echo json_encode($_SESSION['log_pass']);?>;
                recover.style.borderColor = 'red';

                //send back a message
                document.getElementById('popup_err_txt').innerHTML =
                <?php echo json_encode($_SESSION['recover_msg']); ?>;
            </script>
            <?php
        }
    }
}


?>


