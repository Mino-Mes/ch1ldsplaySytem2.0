<?php require "../Util/dbconn.php"; ?>
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
    <script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/jquery-11.0.min.js'></script>
    <script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/unitegallery.min.js'></script>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel='stylesheet' href='../unitegallery-master/package/unitegallery/css/unite-gallery.css' type='text/css'/>
    <script type='text/javascript'
            src='../unitegallery-master/package/unitegallery/themes/tiles/ug-theme-tiles.js'></script>

    <style>

    </style>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">

        <!-- Logo -->
        <div class="logo">
            <a href="index.php"><strong>Login/Register</strong></a>
        </div>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php" class="current">Album</a></li>
                <li><a href="index.php">Inquiries</a></li>
                <li><a href="index.php">YourPhotographs</a></li>
            </ul>
        </nav>

    </header>
    <?php
    $sql = "SELECT * FROM my_photograph WHERE user_id=" . $_GET["id"];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    ?>
    <!-- Section -->
    <section class="main alt">
        <header>
            <h1></h1>
            <p></p>
            <?php
              }
            }
            ?>
        </header>
        <div id="gallery" style="display:none;width:90%;margin-left:5%;margin-right:5%;">
            <?php
            $sql = "SELECT * FROM photo WHERE album_id=" . $_GET["id"];
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <img alt=""
                         src="<?php echo $row["photo_img"]; ?>"
                         style="display:none">
                    <?php
                }
            } else {
                echo "asdasdsada";
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

<!--
HAD TO DELETE FROM THE TEMPLATE.
<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>

			-->
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

<script type="text/javascript">

    jQuery(document).ready(function () {

        jQuery("#gallery").unitegallery({
            theme_enable_preloader: false,
            tiles_max_columns: 3,
            theme_enable_preloader: true,
            tiles_space_between_cols: 13,
            theme_enable_preloader: true,
            lightbox_type: "compact"
        });

    });

</script>
</body>
</html>