<?php
session_start();
require "Util/dbconn.php";
 include 'Util/Popup_return_handler.php';?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>Untitled</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <link rel="stylesheet" href="snack_back.css"/>
    <link rel="stylesheet" href="Style/Stylesheet_popup.css">

    <style>

    </style>
</head>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header" class="alt">

        <!-- Logo -->
        <div class="logo">
            <a href="index.php"><strong>Login/Register</strong></a>
        </div>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li class="current"><a href="index.php">Home</a></li>
                <li><a href="#scrollToAl">Album</a></li>
                <li><a href="#scrollToB">Inquiries</a></li>
                <li><a href="">YourPhotographs</a></li>
            </ul>
        </nav>

    </header>

    <!-- Banner -->
    <section id="banner">
        <h1 style="color:white;text-shadow:2px 2px black;">
            Ch1ldsplay Media Production</h1>
        <a href="#first" class="more scrolly">Learn More</a>
    </section>

    <!-- Section -->
    <section class="main alt" id="first">
        <header>
            <h2 id="scrollToAl">Album</h2>
            <p>Select a type of album you which to view.</p>
        </header>

        <form method="post" action="index.php" id="galleryForm">
            <select name="galleryType" id="demo-category" style="width:50%;margin-left:25%;">
                <?php
                $sql = "SELECT * FROM type";
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
            <div style="margin-left:42%;margin-bottom:2%;">
                <input type="submit" value="Search" class="button" style="margin-top:2%;">
                <input type="reset" value="All" class="button alt">
            </div>
        </form>

        <div class="inner">
            <?php
            if (isset($_POST["galleryForm"])) {
                $g_type = $_POST["galleryType"];

               header("Location:adasdasd.php");
               exit;

                $sql2 = "SELECT * FROM album WHERE album_type=". $g_type;
                $result2 = $conn->query($sql2);

                if ($result2->num_rows > 0) {
                    while ($album = $result2->fetch_assoc()) {
                        ?>
                        <article class="post style2 alt">
                            <div class="content">
                                <header>
                                    <span class="category"><?php echo $album["album_label"]; ?></span>
                                    <h3><?php echo $album["album_title"] ?></h3>
                                </header>
                                <p><?php echo $album["album_description"] ?></p>
                                <ul class="actions">
                                    <li><a href="album.php?id=<?php echo $album['album_id'];?>" class="button next">View Full Album</a></li>
                                </ul>
                            </div>
                            <div class="image" data-position="center"><img src="<?php echo $album["album_img"] ?>"
                                                                           alt=""/></div>
                        </article>
                        <?php
                    }
                }
            } else {
                $sql2 = "SELECT * FROM album";
                $result2 = $conn->query($sql2);

                $count = 0;

                if ($result2->num_rows > 0) {
                    while ($album = $result2->fetch_assoc()) {

                        $count++;
                        if ($count % 2 == 0) {
                            ?>
                            <article class="post style2 alt">
                                <div class="content" style="margin-left:30%;">
                                    <header>
                                        <span class="category"><?php echo $album["album_label"]; ?></span>
                                        <h3><?php echo $album["album_title"] ?></h3>
                                    </header>
                                    <p><?php echo $album["album_description"] ?></p>
                                    <ul class="actions">
                                        <li><a href="album.php?id=<?php echo $album['album_id'];?>" class="button next">View Full Album</a></li>
                                    </ul>
                                </div>
                                <div class="image" data-position="center"><img src="<?php echo $album["album_img"] ?>"
                                                                               alt="" style="width: 230%;"/></div>
                            </article>
                            <?php
                        } else {
                            ?>
                            <article class="post style2">
                                <div class="content" style="width:40%;">
                                    <header>
                                        <span class="category"><?php echo $album["album_label"]; ?></span>
                                        <h3><?php echo $album["album_title"] ?></h3>
                                    </header>
                                    <p><?php echo $album["album_description"] ?></p>
                                    <ul class="actions">
                                        <li><a href="album.php?id=<?php echo $album['album_id'];?>" class="button next">View Full Album</a></li>
                                    </ul>
                                </div>
                                <div class="image" data-position="center"><img src="<?php echo $album["album_img"] ?>"
                                                                               alt="" style="width:150%;"/></div>
                            </article>
                            <?php
                        }
                    }
                }
            }

            ?>
        </div>
    </section>
    <!-- Section -->
    <section class="main alt special">
        <header>
            <h2 id="scrollToB">Business Inquiries</h2>
            <p>Request a photoshoot or Contact me by filling the form bellow, a confimation will be sent. From there I
                will
                personally contact you via email.</p>
        </header>
        <div class="inner">
            <form method="post" action="Functions.php" name="emailForm" id="emailForm" class="alt">
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <label>
                            First Name
                        </label>
                        <input type="text" name="fname" id="fname" value="" placeholder="First Name"/>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Last Name
                        </label>
                        <input type="text" name="lname" id="lname" value="" placeholder="Last Name"/>
                    </div>
                    <!-- Break -->
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="" placeholder="Email"/>
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
                                  rows="6"></textarea>
                    </div>
                    <div class="col-12">
                        <label>
                            Briefly explain your availabilities.
                        </label>
                        <textarea name="avail" id="availabilities" placeholder="Explain Availabilities"
                                  rows="6"></textarea>
                    </div>
                    <!-- Break -->
                    <div class="col-12" id="center_button">
                        <input type="submit" id="emailSubmitBtn" value="Send Message"/>
                    </div>
                </div>
            </form>
            <?php
            if(isset($_GET["mail_message"]))
            {
                echo " <div id=\"snackbar\">".$_GET["mail_message"]."</div>"
                ?>

                <script>
                    function myFunction() {
                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    }
                    myFunction();
                </script>
                <?php
                //echo "<p id=\"errorMessage\" style=\"color:Red;text-align: center;\"> ".$_GET['mail_message']."</p>  ";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
            <li><a href="#" class="icon alt fa-phone"><span class="label">Phone</span></a></li>
            <li><a href="#" class="icon alt fa-envelope-o"><span class="label">Email</span></a></li>
        </ul>
        <p class="copyright">&copy; Untitled. All rights reserved.</p>
    </footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<script src="Script_popup.js"></script>

</body>
</html>