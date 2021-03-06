<?php

require "../Util/dbconn.php";
require "../Util/nav.php";
include '../Util/Popup_return_handler.php';
session_start();
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>Ch1ldsplay Media Production | Home</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/snack_back.css"/>
    <link rel="stylesheet" href="../css/Stylesheet_popup.css">
    <link rel="stylesheet" href="../css/ln_snackbar.css">
    <link rel="stylesheet" href="../css/stylesheet_main.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>
<body class="is-preload">
<!-- Wrapper -->
<div id="wrapper" >
<div id="scrollToHome"></div>
        <?php nav();?>
    <!-- Banner -->
    <section id="banner">
        <h1 style="color:white;text-shadow:2px 2px black;" >
            Ch1ldsplay Media Production</h1>
        <a href="#first" class="more scrolly">Learn More</a>
    </section>
    <!-- Section -->
    <section class="main alt" id="first">
        <header>
            <h2 id="scrollToAl">Album</h2>
            <p>Select a type of album you which to view.</p>
        </header>

        <select name="galleryType" id="typeDrop" style="width:50%;margin-left:25%;">
            <?php
            $sql = "SELECT * FROM type where isActive=1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row["typeId"] ?>"><?php echo $row["typeName"] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <ul class="actions special" style="margin-top: 1%;">
            <li> <input type="button" onclick="getGalleryType()" id="submit" value="Search"/></li>
            <li> <input type="button" onclick="showAll()" value="All" class="button alt"/></li>
        </ul>
    <!-- Div container of the gallery which is generated by php-->
        <div class="inner" id="galleryContainer">

        </div>
    </section>
    <!-- Section -->
    <section class="main alt special" id="second">
        <header>
            <h2 id="scrollToB">Business Inquiries</h2>
            <p>Request a photoshoot or Contact me by filling the form bellow, a confimation will be sent. From there I
                will
                personally contact you via email.</p>
        </header>
        <div class="inner">
            <form method="post" action="../Util/Functions.php" name="emailForm" id="emailForm" class="alt">
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <label>
                            First Name
                        </label>
                        <input type="text" name="fname" id="fname" value="" placeholder="First Name" required/>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Last Name
                        </label>
                        <input type="text" name="lname" id="lname" value="" placeholder="Last Name" required/>
                    </div>
                    <!-- Break -->
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Email
                        </label>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Services
                        </label>
                        <select name="service" id="service">
                            <option value="0">- Services -</option>
                            <option value="photographer">Photographer</option>
                            <option value="videographer">Videographer</option>
                            <option value="photographer+videographer">Photographer + Videographer</option>
                        </select>
                    </div>

                    <div class="col-12" id="mailMessage">
                        <label>
                            Briefly explain what type of photographs you are looking for.
                        </label>
                        <textarea name="description" id="description" placeholder="Enter your description"
                                  rows="6" required></textarea>
                    </div>
                    <div class="col-12">
                        <label>
                            Briefly explain your availabilities.
                        </label>
                        <textarea name="avail" id="availabilities" placeholder="Explain Availabilities"
                                  rows="6" required></textarea>
                    </div>
                    <ul class="actions special">
                        <li><button class="button next" type="button" onclick="sendEmail()" id="emailSubmitBtn">Send Message</button></li>
                    </ul>
                </div>
            </form>
        </div>
    </section>
    <div id="snackbar"></div>
    <?php
    if(isset($_SESSION["message"]))
    {
        $error= $_SESSION["message"];
        ?>
        <script>
                var message="<?php echo $error;?>";
                var x = document.getElementById("snackbar");
                x.innerHTML = message;
                x.className = "show";
                setTimeout(function () {
                    x.className = x.className.replace("show", "");
                }, 3000);

        </script>
        <?php
        unset($_SESSION["message"]);
    }
    ?>
    <?php
    if(isset($_SESSION["reset_pwd_message"]))
    { $error= $_SESSION["reset_pwd_message"];
        ?>
        <script>

                var x = document.getElementById("snackbar");
                x.innerHTML = "<?php echo $error;?>";
                x.className = "show";
                setTimeout(function () {
                    x.className = x.className.replace("show", "");
                }, 3000);


            cookie();
        </script>
        <?php
        unset( $_SESSION["reset_pwd_message"]);
    }
    ?>

    <!-- Footer -->
    <?php footer();?>
</div>

<div id="myModal" class="modal" style="overflow: hidden;">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="popup_content"></div>
    </div>
</div>
<div id="myModal1" class="modal" style="overflow: hidden;">
    <!-- Modal content -->
    <div class="modal1-content">
        <span class="close">&times;</span>
        <div id="popup_content1"></div>
    </div>
</div>

<div id='ln_snackbar'></div>

<!-- Scripts -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.dropotron.min.js"></script>
<script src="../assets/js/jquery.scrollex.min.js"></script>
<script src="../assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../js/Script_popup.js"></script>
<script src="../js/jump.js"></script>
<script src="../Util/indexFunctions.js"></script>

<script>
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status ==200)
        {
            document.getElementById("galleryContainer").innerHTML=this.responseText;
        }
    };
    xhttp.open("POST", "../Util/selectGalleryType.php", true);
    xhttp.send();
</script>

</body>
</html>