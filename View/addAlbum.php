<?php
require "../Util/dbconn.php";
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
	<head>
		<title>Untitled</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../assets/css/main.css" />
        <link rel="stylesheet" href="../css/snack_back.css"/>
        <link rel="stylesheet" href="../css/ln_snackbar.css">
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">

						<!-- Logo -->
							<div class="logo">
								<a href="../orange/index.html"><strong>Relativity</strong> by Pixelarity</a>
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li><a href="../orange/index.html">Home</a></li>
									<li>
										<a href="#" class="icon fa-angle-down">Dropdown</a>
										<ul>
											<li><a href="#">Option One</a></li>
											<li><a href="#">Option Two</a></li>
											<li><a href="#">Option Three</a></li>
											<li>
												<a href="#">Submenu</a>
												<ul>
													<li><a href="#">Option One</a></li>
													<li><a href="#">Option Two</a></li>
													<li><a href="#">Option Three</a></li>
													<li><a href="#">Option Four</a></li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="current"><a href="../orange/generic.html">Generic</a></li>
									<li><a href="elements.html">Elements</a></li>
								</ul>
							</nav>

					</header>

				<!-- Section -->
					<section class="main alt">
						<header>
							<h1>Add an Album</h1>
                            <p>This page allows the administrator to add an album, to do so simply fill in the form.</p>
						</header>
						<div class="inner style2">
                            <form method="POST" action="addAlbumLogic.php" enctype="multipart/form-data" class="alt">
                                <div class="row gtr-uniform">
                                    <div class="col-12">
                                        <span class="image fit"><img id="uploadPreview" alt="" /></span>
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
                                            <option value="0" selected>- Type -</option>
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
                                    </div>
                                    <div class="col-2">
                                        <ul class="actions small">
                                            <li><a href="#" class="button small">+ Add a Type</a></li>
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
			<script src="../orange/assets/js/jquery.min.js"></script>
			<script src="../orange/assets/js/jquery.dropotron.min.js"></script>
			<script src="../orange/assets/js/jquery.scrollex.min.js"></script>
			<script src="../orange/assets/js/jquery.scrolly.min.js"></script>
			<script src="../orange/assets/js/browser.min.js"></script>
			<script src="../orange/assets/js/breakpoints.min.js"></script>
			<script src="../orange/assets/js/util.js"></script>
			<script src="../orange/assets/js/main.js"></script>

    <script>

        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };

        function PreviewImages(){
            var images =document.getElementById("albumImages[]");
            var output =document.getElementById("albumContainer");

            for(var i=0;i<images.files.length;i++)
            {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(images.files[i]);

                oFReader.onload = function (oFREvent) {
                    output.innerHTML +="<div class='col-4'><span class='image fit'><img src= " + oFREvent.target.result +" alt='Album Image'/></span></div>";
                };
            }
        }
    </script>

	</body>
</html>