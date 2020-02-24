<?php
require "../Util/navOtherPages.php";
session_start();
$_SESSION['current_page'] = 'admin_command';
onlyAdmin();
?>
<html>
<head>
    <title>Ch1ldsplay Media Production | Manage Users</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/snack_back.css"/>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
   <?php nav();?>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>User Management</h1>
            <p>This Page allows the administrator to promote, ban and add users</p>
        </header>
        <div class="inner style2" style="padding:10px;margin:auto;width:90%;">
            <h3>User Search</h3>

            <form method="post" action="#" class="alt">
                <div class="row gtr-uniform">
                    <div class="col-12 col-12-xsmall" id="search-box">
                        <label>Enter the username or ID of an account to find a specific user. Alternatively, you can input <em>'All'</em> to view all users. </label>
                        <input type="text" name="demo-name" id="demo-name" value="" placeholder="Search username or ID..." style="width:27%;" />
                    </div>
                </div>
            </form>
            <!-- the dynamic table goes here -->
            <div id="result"></div>
        </div>
    </section>
    <div id="snackbar"></div>

    <?php footer();?>
    <?php
    if(isset($_SESSION['msg_modify'])){

        ?>
        <script>
            //var message="<?php echo $_SESSION['msg_modify']; ?>";
            var x = document.getElementById("snackbar");
            var y = "<?php echo $_SESSION["msg_modify_isErr"]; ?>";
            if(y != "false"){
                x.style.background="green";
            }
            x.innerHTML = "<?php echo $_SESSION['msg_modify']; ?>";
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);

        </script>
        <?php
        unset($_SESSION['msg_modify']);
    }
    ?>

</div>

<!-- Scripts -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.dropotron.min.js"></script>
<script src="../assets/js/jquery.scrollex.min.js"></script>
<script src="../assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var showban = true; //this var is probably not need - remove later
            var resultDropdown = $("#result");
            if(inputVal.length){
                $.get("../Util/Manage_users_backend.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });
    });
</script>
</body>
</html>
