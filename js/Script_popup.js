function forgot_pass(){
    document.getElementById("popup_content").innerHTML =
        '<form method="post" action="../Util/pass_recovery.php" class="alt"><div class="row gtr-uniform">'+
        '<div class="col-12"><h2 style="text-align: center;">Recover password</h2></div>'+
        '<div class="col-12"><label style="color:black;">Email Address</label><input type="email" name="recover_email" id="recover_email" value="" placeholder="Email" required/></div>'+
        '<ul class="actions special" style="margin-top: 4%;">' +
        ' <li><button class="button next" type="submit">Recover</button></li>' +
        ' </ul>'+
        '</div></form>'+
        '<a id="forgot_pass" href="javascript:forgot_cancel()">Cancel</a>'+
        '<h5 id="popup_err_txt"></h5>';
}
function forgot_cancel(){
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

}

// Get the modal
var modal = document.getElementById("myModal");

// When the user clicks on the Register button, open the modal
function Reg() {
    var modalOther=document.getElementById("myModal");
    modalOther.style.display="none";
    var modal = document.getElementById("myModal1");
    modal.style.display = "block";
    //document.getElementById("popup_content").innerHTML += '<?php require_once("Util/Layout.php");create_login_form();?>';
    document.getElementById("popup_content1")
        .innerHTML =
        '<div class="inner"><form method="post" action="../Util/reg.php" class="alt"><div class="row gtr-uniform">' +
        '<div class="col-12"><h2 style="text-align: center">Register</h2></div>' +
        '<div class="col-6"><label style="color:black;">First Name</label><input type="text" name="reg_fname" id="reg_fname" value="" placeholder="First Name" required/></div>' +
        '<div class="col-6"><label style="color:black;">Last Name</label><input type="text" name="reg_lname" id="reg_lname" value="" placeholder="Last Name" required/></div>' +
        '<div class="col-6"><label style="color:black;">Email</label><input type="email" name="reg_email" id="reg_email" value="" placeholder="Email" required/></div>' +
        '<div class="col-6"><label style="color:black;">Username</label><input type="text" name="reg_username" id="reg_username" value="" placeholder="Username" required/></div>' +
        '<div class="col-6"><label style="color:black;">Password</label><input type="password" name="reg_password" id="reg_pass" value="" placeholder="Password" required/></div>' +
        '<div class="col-6"><label style="color:black;">Confirm Password</label><input type="password" name="reg_confirm_password" id="reg_confirm_pass" value="" placeholder="Confirm Password" required></div>' +
        '<ul class="actions special" style="margin-top: 4%;">' +
        ' <li><button class="button next" type="submit">Register</button></li>' +
        ' </ul>'+
        '</div></form>' +
        '<h5 id="popup_err_txt"></h5>' +
        '</div>';

    var span = document.getElementsByClassName("close")[1];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        document.getElementById("popup_content1").innerHTML = '';

    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.getElementById("popup_content1").innerHTML = '';
        }
    }


}

// When the user clicks on the Login button, open the modal
function Login(){
    var modal = document.getElementById("myModal");
    var modalOther = document.getElementById("myModal1");
    modalOther.style.display = "none";
    modal.style.display = "block";
    //document.getElementById("popup_content").innerHTML += '<?php require_once("Util/Layout.php");create_login_form();?>';
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


// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
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
}


