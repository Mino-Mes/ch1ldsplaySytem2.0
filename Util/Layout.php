<?php

    /* IMPORTANT: for the moment the following functions are not needed, javascript has instead been used */



    //Register creation function - to improve efficiency by only creating the form when needed
    //Client-side validation included
    //Used in Index.php
    //reg refers to all registration related elements

function create_register_form(){

    // first block of echo statements creates two of the style divs and the form
    echo '<div class="inner">'.'<form method="post" action="#" class="alt">'.'<div class="row gtr-uniform">';

    //title of the popup
    echo '<div class="col-12">'.'<h2>REGISTER</h2>'.'</div>';

    // the divs label and input for first name
    echo '<div class="col-12">'.' <label style="color:white;">'.'First Name'.'</label>'.'<input type="text" name="reg_fname" id="reg_fname" value="" placeholder="First Name" />'.'</div>';

    //the divs label and input for last name
    echo '<div class="col-12">'.'<label style="color:white;">'.'Last Name'.'</label>'.'<input type="text" name="reg_lname" id="reg_lname" value="" placeholder="Last Name" />'.'</div>';

    //the divs label and input for email
    echo '<div class="col-12">'.'<label style="color:white;">'.'Email'.'</label>'.'<input type="email" name="reg_email" id="reg_email" value="" placeholder="Email" />'.'</div>';

    //the divs label and input for username
    echo '<div class="col-12">'.'<label style="color:white;">'.'Username'.'</label>'.'<input type="text" name="reg_username" id="reg_username" value="" placeholder="Username" />'.'</div>';

    //the divs label and input for password
    echo '<div class="col-12">'.'<label style="color:white;">'.'Password'.'</label>'.'<input type="password" name="reg_password" id="reg_password" value="" placeholder="Password" />'.'</div>';

    //the divs label and input for confirm password
    echo '<div class="col-12">'.'<label style="color:white;">'.'Confirm Password'.'</label>'.'<input type="password" name="reg_confirm_password" id="reg_confirm_password" value="" placeholder="Confirm Password" />'.'</div>';

    //the submit button
    echo '<div class="col-12" id="center_button" class="reg_log_submit_btn">'.'<input type="submit" value="Register">'.'</div>';

    //the last of the divs and the form closing tag
    echo '</div>'.'</form>';

    echo '<h5 id="popup_err_txt"></h5>';

    echo '</div>';

}

    //Login creation function - to improve efficiency by only creating the form when needed
    //Client-side validation included
    //Used in Index.php
    //log refers to all login related elements

function create_login_form(){

    // first block of echo statements creates two of the style divs and the form
    echo '<div class="inner">'.'<form method="post" action="#" class="alt">'.'<div class="row gtr-uniform">';

    //title of the popup
    echo '<div class="col-12">'.'<h2>LOGIN</h2>'.'</div>';

    // the divs label and input for username (you can also enter your email as your username)
    echo '<div class="col-12">'.' <label style="color:white;">'.'Username / Email'.'</label>'.'<input type="text" name="log_username" id="log_username" value="" placeholder="Username or Email" />'.'</div>';

    //the divs label and input for password
    echo '<div class="col-12">'.'<label style="color:white;">'.'Password'.'</label>'.'<input type="text" name="log_password" id="log_password" value="" placeholder="Password" />'.'</div>';

    //the submit button
    echo '<div class="col-12" id="center_button" class="reg_log_submit_btn">'.'<input type="submit" value="Register">'.'</div>';

    //the last of the divs and the form closing tag
    echo '</div>'.'</form>';

    echo '<h5 id="popup_err_txt"></h5>';

    echo '</div>';
}
?>