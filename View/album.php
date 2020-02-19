<?php require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
session_start();
if(!isset($_GET["id"]))
{
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>Ch1ldsplay Media Production | Album</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
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
   <?php nav();?>
    <?php
    $sql = "SELECT * FROM album WHERE album_id=" . $_GET["id"];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    ?>
    <!-- Section -->
    <section class="main alt">
        <header>
            <h1><?php echo $row["album_title"] ?></h1>
            <p><?php echo "by ".$row["album_label"] ?></p>
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

  <?php footer();?>

</div>

<!-- Scripts -->
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>


</body>
</html>