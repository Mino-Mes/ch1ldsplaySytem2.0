<?php
session_start();
require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
isCollab();
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
	<head>
        <title>Ch1ldsplay Media Production | addAlbum</title>
        <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
        <link rel="stylesheet" href="../assets/css/main.css" />
        <link rel="stylesheet" href="../css/snack_back.css"/>
        <link rel="stylesheet" href="../css/ln_snackbar.css">
        <link rel="stylesheet" href="../css/addAlbum.css">
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<?php nav();?>

				<!-- Section -->
					<section class="main alt">
						<header>
							<h1>Add an Album</h1>
                            <p>This page allows the administrator to add an album, to do so simply fill in the form.</p>
						</header>
						<div class="inner style2">
                            <form method="POST" action="../Util/addAlbumLogic.php" name="addAlbumForm" id="addAlbumForm" enctype="multipart/form-data" class="alt">
                                <div class="row gtr-uniform">
                                    <div class="col-12">
                                        <span class="image fit"><img id="uploadPreview" alt=""  style="width: 60%;"/></span>
                                        <label>
                                           Enter gallery image file
                                        </label>
                                        <input id="uploadImage" type="file" name="myPhoto" id="myPhoto" onchange="PreviewImage();" />
                                    </div>
                                    <div class="col-6 col-12-xsmall">
                                        <label>
                                            Enter the album title
                                        </label>
                                        <input type="text" name="title" id="title" value="" placeholder="Album Title" />
                                    </div>
                                    <div class="col-6 col-12-xsmall">
                                        <label>
                                            Enter the album Label
                                        </label>
                                        <input type="text" name="label" id="label" value="" placeholder="Album label" />
                                    </div>
                                    <!-- Break -->
                                    <div class="col-10">
                                        <label>
                                            Select Album Type
                                        </label>
                                        <select name="typeDrop" id="typeDrop" >


                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <ul class="actions small">
                                            <li><a href="javascript:void(0)" onclick="addTypeModal()" class="button small">+ Add a Type</a></li>
                                        </ul>
                                    </div>
                                    <!-- Break -->
                                    <div class="col-12">
                                        <label>
                                            Enter album description
                                        </label>
                                        <textarea name="description" id="description" placeholder="Album Description" rows="6"></textarea>
                                    </div>
                                    <!-- Break -->
                                    <div class="col-12">
                                        <span class="image fit"><img id="uploadPreview" alt="" /></span>
                                        <label>
                                            Enter gallery image file
                                        </label>
                                        <input id="albumImages[]" type="file" name="albumImages[]"  onchange="PreviewImages()"  multiple="multiple" />
                                    </div>
                                    <!-- Break -->
                                    <div class="col-12">
                                        <div class="box alt">
                                            <div class="row gtr-50 gtr-uniform" id="albumContainer">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Break -->
                                    <div class="col-6 col-12-small">
                                        <input type="checkbox" id="active" name="active" checked>
                                        <label for="active">Make Album Active</label>
                                    </div>
                                    <!-- Break -->
                                    <div class="col-12">
                                        <ul class="actions special">
                                            <li><button class="button next" type="submit" id="submit">Create Album</button></li>
                                        </ul>
                                    </div>
                                    <div id="snackbar"></div>
                                   <?php
                                    if(isset($_GET["message"]))
                                    {?>
                                        <script>
                                            function showSnackBar(){
                                                var x = document.getElementById("snackbar");
                                                x.innerHTML="<?=$_GET["message"]?>";
                                                x.className = "show";
                                                setTimeout(function () {
                                                    x.className = x.className.replace("show", "");
                                                }, 3000);
                                            }
                                                showSnackBar();
                                        </script>
                                        <?php
                                    }
                                        ?>
                                </div>
                            </form>
						</div>
					</section>
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 style="text-align: center">Add a Type</h1>
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <label>
                                    Enter Type Name
                                </label>
                                <input id="name" type="text" name="name"/>
                            </div>
                        </div>
                        <br>
                        <div class="col-12">
                            <ul class="actions special">
                                <li>
                                    <button class="button next" type="button" id="submit" onclick="UploadType()">Create
                                        Type
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

				<!-- Footer -->
					<?php ?>>

			</div>

		<!-- Scripts -->
			<script src="../orange/assets/js/jquery.min.js"></script>
			<script src="../orange/assets/js/jquery.dropotron.min.js"></script>
			<script src="../orange/assets/js/jquery.scrollex.min.js"></script>
			<script src="../orange/assets/js/jquery.scrolly.min.js"></script>
			<script src="../orange/assets/js/browser.min.js"></script>
			<script src="../orange/assets/js/breakpoints.min.js"></script>
			<script src="../orange/assets/js/util.js"></script>
			<script src="../orange/assets/js/main.js"></script>
            <script src="../Util/addAlbumFunctions.js"></script>
	</body>
</html>