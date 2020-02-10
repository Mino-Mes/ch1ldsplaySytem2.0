<?php require "../Util/dbconn.php";?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
	<head>
		<title>MyAlbums</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">

						<!-- Logo -->
							<div class="logo">
								<a href="index.php"><strong>Relativity</strong> by Pixelarity</a>
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li><a href="index.php">Home</a></li>
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
									<li class="current"><a href="myAlbums.php">Generic</a></li>
									<li><a href="elements.html">Elements</a></li>
								</ul>
							</nav>

					</header>

				<!-- Section -->
					<section class="main alt">
						<header>
							<h1>Administrative Functions Page</h1>
							<p>This page allows the adminstrator to view all active albums. Furthermore, it allows the user to update any active album and add any type of album </p>
						</header>
						<div class="inner style2" >
                            <h4>List of Current Albums</h4>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Image Path</th>
                                        <th>Album Id</th>
                                        <th>Creator Id</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Label</th>
                                        <th>Type Id</th>
                                        <th>isActive</th>
                                        <th>Update</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql="SELECT * from album";
                                    $result =$conn->query($sql);

                                    if($result->num_rows > 0)
                                    {
                                        while($albums = $result->fetch_assoc())
                                        {
                                            $id=$albums["album_id"];
                                            $user_id=$albums["user_id"];
                                            $album_title=$albums["album_description"];
                                            $album_description=$albums["album_description"];
                                            $album_label=$albums["album_label"];
                                            $album_img=$albums["album_img"];
                                            $album_isActive=$albums["album_isActive"];
                                            $album_type=$albums["typeId"];

                                            if($album_isActive == 1)
                                            {
                                                $album_isActive = "Active";
                                            }else
                                            {
                                                $album_isActive = "Disabled";
                                            }

                                             echo "<tr><td><div class=\"row gtr-1 gtr-uniform\"><div class=\"col-12\"><span class=\"image fit\"><img src='$album_img' alt=\"\" /></span></div></div></td><td>$id</td><td>$user_id</td><td>$album_title</td><td>$album_description</td><td>$album_label</td><td>$album_type</td><td>$album_isActive</td><td><ul class=\"actions fit small\"><li><a href=\"#\" class=\"button fit small\">Update</a></li></ul></td></tr>";
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <ul class="actions">
                                <li><a href="#" class="button alt">+Add an Album</a></li>
                            </ul>
						</div>
                        <div class="inner style2" >
                            <h4>List of Current Types</h4>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Type Id</th>
                                        <th>Type Name</th>
                                        <th>Is Active</th>
                                        <th>Update</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql="SELECT * from type";
                                    $result =$conn->query($sql);

                                    if($result->num_rows > 0)
                                    {
                                        while($row = $result->fetch_assoc())
                                        {
                                            $typeId=$row["typeId"];
                                            $typeName=$row["typeName"];

                                            echo "<tr><td>$typeId</td><td>$typeName</td><td></td></td><td><ul class=\"actions fit small\"><li><a href=\"#\" class=\"button fit small\">Update</a></li></ul></td></tr>";
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <ul class="actions">
                                <li><a href="#" class="button alt">+Add a Type</a></li>
                            </ul>
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
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>