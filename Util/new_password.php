<?php
session_start();
require("dbconn.php");
require "navOtherPages.php";
//this is what you need to get
//"new_password.php?token=" . $token . "
$token = '';
try {
    $token = $_GET['token'];
    //might need to try this instead
    //$token = $_SESSION['token'];
} catch (Exception $e) {
    echo 'Error: could not retrieve token!';
}
?>
<html>
<head>
    <title>Ch1ldsplay Media Production | Reset Password</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../../assets/css/main.css"/>
    <link rel="stylesheet" href="../../css/snack_back.css"/>
    <link rel="stylesheet" href="../../css/ln_snackbar.css">
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <?php nav(); ?>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Password Reset</h1>
        </header>
        <div class="box" style='width: 50%;margin-left: 25%;margin-right: 25%;background-color: white;'>
            <div>
                <h4 style="text-align: center;">Enter a new Password</h4>
                <form method="GET" action="../passLogic.php">
                    <label>
                        Input New Password
                    </label>
                    <input type="password" id="psswd" name="psswd"/>
                    <label>
                        Confirm New Password
                    </label>
                    <input type="password" id="new_psswd" name="new_psswd"/>
                    <input type="hidden" value="<?= $token ?>" name="tokenValue" id="tokenValue"/>
                    <ul class="actions special" style="margin-top: 2%;">
                        <li>
                            <button type="submit" class="button">Update Password</button>
                        </li>
                    </ul>
                </form>
            </div>

        </div>
    </section>
<div id="snackbar"></div>



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
<script>
    function cookie(message) {
        var x = document.getElementById("snackbar");
        x.innerHTML = message;
        x.className = "show";
        setTimeout(function () {
            x.className = x.className.replace("show", "");
        }, 3000);

    }
</script>
<?php
if(isset($_SESSION["error_pssd"]))
{
    ?>
    <script>
        var message="<?php echo $_SESSION["error_pssd"]; ?>";
        cookie(message);
    </script>
    <?php
}
?>
<!-- Footer -->
<?php footer(); ?>

</body>
</html>