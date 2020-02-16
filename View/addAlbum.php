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
        <style>
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0, 0, 0); /* Fallback color */
                background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 40%;
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 1s;
                animation-name: animatetop;
                animation-duration: 1s
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

            @-webkit-keyframes animatetop {
                from {
                    top: -500px;
                    opacity: 0
                }
                to {
                    top: 0;
                    opacity: 1
                }
            }

            @keyframes animatetop {
                from {
                    top: -500px;
                    opacity: 0
                }
                to {
                    top: 0;
                    opacity: 1
                }
            }
        </style>
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
                                    <button class="button next" type="button" id="submit" onclick="UploadType(),showTypeList()">Create
                                        Type
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

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

        function showTypeDropdown()
        {
            var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var x = document.getElementById("typeDrop");
                    x.innerHTML = this.responseText;
                }
            };
            xhttp1.open("POST", "../Util/showTypeDropdown.php", true);
            xhttp1.send();
        }
        showTypeDropdown();
        function addTypeModal() {
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            modal.style.display = "block";

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
        function UploadType() {
            var typeName = document.getElementById("name").value;

            var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var x = document.getElementById("snackbar");
                    x.innerHTML = this.responseText;
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 3000);
                    showTypeDropdown();
                }
            };
            xhttp1.open("POST", "../Util/addTypeLogic.php", true);
            xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp1.send("type=" + typeName);
        }
    </script>

	</body>
</html>