<?php
session_start();
//include 'Auth_security.php';
$_SESSION['current_page'] = 'admin_command';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>

<script src="https://code.jquery.com/jquery-1.12.4.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            //var resultDropdown = $(this).siblings(".result");
            var resultDropdown = $(".result");
            if(inputVal.length){
                $.get("Manage_users_backend.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        // remove this after table is made

        /*
        $(document).on("click", ".result", function(){
            $(this).parents(".search-box")
                .find('input[type="text"]').val($(this).text());
            $(this).parent(".result")
                .empty();
        });
         */
        /*
        $(document).on("click", ".result", function(){
            $(".search-box")
                .find('input[type="text"]').val($(this).text());
            $(".result")
                .empty();
        });
        */

    });
</script>
<body>
<p>Use the search bar below to find users by their username</p>
<div class="search-box">
    <input type="text" autocomplete="off" placeholder="Search username...">
</div>
<div class="result">
    <?php
    if(isset($_SESSION['msg_modify'])){
        echo $_SESSION['msg_modify'];
        unset($_SESSION['msg_modify']);
    };
    ?>
</div>
</body>
</html>
