// Get the modal
var modal = document.getElementById("myModal");

// Get the register button
var btn_reg = document.getElementById("btn_register");

//Get the login button
var btn_log = document.getElementById("btn_login");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the Register button, open the modal
btn_reg.onclick = function() {
    modal.style.display = "block";
    //document.getElementById("popup_content").innerHTML += '<?php require_once("Util/Layout.php");create_login_form();?>';
    document.getElementById("popup_content")
        .innerHTML =
        '<div class="inner"><form method="post" action="reg.php" class="alt"><div class="row gtr-uniform">' +
        '<div class="col-12"><h2 style="color:black;">REGISTER</h2></div>' +
        '<div class="col-12"><label style="color:black;">First Name</label><input type="text" name="reg_fname" id="reg_fname" value="" placeholder="First Name" required></div>' +
        '<div class="col-12"><label style="color:black;">Last Name</label><input type="text" name="reg_lname" id="reg_lname" value="" placeholder="Last Name" required></div>' +
        '<div class="col-12"><label style="color:black;">Email</label><input type="email" name="reg_email" id="reg_email" value="" placeholder="Email" required></div>' +
        '<div class="col-12"><label style="color:black;">Username</label><input type="text" name="reg_username" id="reg_username" value="" placeholder="Username" required></div>' +
        '<div class="col-12"><label style="color:black;">Password</label><input type="password" name="reg_password" id="reg_pass" value="" placeholder="Password" required></div>' +
        '<div class="col-12"><label style="color:black;">Confirm Password</label><input type="password" name="reg_confirm_password" id="reg_confirm_pass" value="" placeholder="Confirm Password" required></div>' +
        '<div class="col-12" id="center_button" class="reg_log_submit_btn"><input type="submit" value="Register"></div>' +
        '</div></form>' +
        '<h5 id="popup_err_txt"></h5>' +
        '</div>';

}

// When the user clicks on the Login button, open the modal
btn_log.onclick = function(){
    modal.style.display = "block";
    //document.getElementById("popup_content").innerHTML += '<?php require_once("Util/Layout.php");create_login_form();?>';
    document.getElementById("popup_content").innerHTML =
        '<div class="inner"><form method="post" action="Login.php" class="alt"><div class="row gtr-uniform">'+
        '<div class="col-12"><h2 style="color:black;">LOGIN</h2></div>'+
        '<div class="col-12"><label style="color:black;">Username / Email</label><input type="text" name="log_username" id="log_username" value="" placeholder="Username or Email" required></div>'+
        '<div class="col-12"><label style="color:black;">Password</label><input type="text" name="log_password" id="log_password" value="" placeholder="Password" required></div>'+
        '<div class="col-12" id="center_button" class="reg_log_submit_btn"><input type="submit" value="Login"></div>'+
        '</div></form>'+
        '<h5 id="popup_err_txt"></h5>'+
        '</div>';
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    document.getElementById("popup_content").innerHTML = '';

}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementById("popup_content").innerHTML = '';
    }
}