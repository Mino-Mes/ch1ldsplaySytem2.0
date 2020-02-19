<?php require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
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
    <title>Ch1ldsplay Media Production | YourPhotographs</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/jquery-11.0.min.js'></script>
    <script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/unitegallery.min.js'></script>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel='stylesheet' href='../unitegallery-master/package/unitegallery/css/unite-gallery.css' type='text/css'/>
    <script type='text/javascript' src='../unitegallery-master/package/unitegallery/themes/tiles/ug-theme-tiles.js'></script>
    <link rel="stylesheet" href="../css/stylesheet_main.css">
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="stylesheet" href="../css/Stylesheet_popup.css">
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <?php nav();

    $noPhoto=false;
    if (!isset($_SESSION['ln_username'])) {
        echo "<h3 style='text-align: center;padding-top: 4%;'>Hey there !</h3>
			<div class=\"box\" style='width: 50%;margin-left: 25%;margin-right: 25%;'>
				<p>  This a page where our customers can view the pictures that we have taken for them. To request a photoshoot select business and inquiries and create an account !</p>
			</div>";
        $noPhoto=true;
    } else if(isset($_GET["id"])){

        $sql2 = "SELECT user_lname,user_fname FROM user WHERE user_id=" . $_GET["id"];
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            if ($row2 = $result2->fetch_assoc()) {
                $fname = $row2["user_fname"];
                $lname = $row2["user_fname"];
            }
        }else
        {
            echo "			<h3 style='text-align: center;padding-top: 4%;'>Hey there !</h3>
										<div class=\"box\" style='width: 50%;margin-left: 25%;margin-right: 25%;'>
											<p>Looks like you have found the YourPhotographs but do not see any photos of you, well try and contacting by filling the form in business inquiries.</p>
										</div>";
            $noPhoto=true;
        }
        ?>

        <?php
        if(!$noPhoto) {
            ?>
            <!-- Section -->
            <section class="main alt">
                <header>
                    <h1>Photographs of <?= $fname ?> <?= $lname ?></h1>
                    <h4>Enjoy and thanks again !</h4>
                </header>
                <div id="gallery" style="display:none;width:90%;margin-left:5%;margin-right:5%;">
                    <?php
                    $sql = "SELECT * FROM my_photograph WHERE user_id=" . $_GET["id"] . " AND isActive=1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <img alt=""
                                 src="<?php echo $row["img_path"]; ?>"
                                 style="display:none">
                            <?php
                        }
                    } else {
                        echo "			<h3 style='text-align: center;padding-top: 4%;'>Hey there !</h3>
										<div class=\"box\" style='width: 50%;margin-left: 25%;margin-right: 25%;'>
											<p>Looks like you have found the YourPhotographs but do not see any photos of you, well try and contacting by filling the form in business inquiries.</p>
										</div>";
                    }
                    ?>
                </div>
            </section>

            <?php
        }
    }else
    {
        header("Location:index.php");
        exit();
    }
    footer();
    ?>
   <?php if($noPhoto) {
       ?>
       <div id="test" style="padding-bottom:30%;"></div>
       <?php
   }
    ?>
</div>

<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../Util/indexFunctions.js"></script>
<script src="../js/Script_popup.js"></script>

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

</body>
</html>