function recover_popup(){
    //forgot password functionality
        document.getElementById("popup_content").innerHTML =
            '<div class="inner"><form method="post" action="../Util/pass_recovery.php.php" class="alt"><div class="row gtr-uniform">'+
            '<div class="col-12"><h2 style="color:black;">Forgot Password</h2></div>'+
            '<div class="col-12"><label style="color:black;">Email Address</label><input type="text" name="recover_email" id="recover_email" value="" placeholder="Email address" required></div>'+
            '<div class="col-12" id="center_button" class="recover_btn"><input type="submit" value="Recover"></div>'+
            '</div></form>'+
            '<a id="forgot_cancel">Cancel</a>'+
            '<h5 id="popup_err_txt"></h5>'+
            '</div>';
}
function recover_cancel(){
    //if they change their mind, set the form back to what it was
    document.getElementById("popup_content").innerHTML =
        '<div class="inner"><form method="post" action="../Util/Login.php" class="alt"><div class="row gtr-uniform">'+
        '<div class="col-12"><h2 style="color:black;">LOGIN</h2></div>'+
        '<div class="col-12"><label style="color:black;">Username / Email</label><input type="text" name="log_username" id="log_username" value="" placeholder="Username or Email" required></div>'+
        '<div class="col-12"><label style="color:black;">Password</label><input type="password" name="log_password" id="log_password" value="" placeholder="Password" required></div>'+
        '<div class="col-12" id="center_button" class="reg_log_submit_btn"><input type="submit" value="Login"></div>'+
        '</div></form>'+
        '<a id="forgot_pass">Forgot password?</a>'+
        '<h5 id="popup_err_txt"></h5>'+
        '</div>';
}
/*
function test() {
    document.write('works');
}
 */