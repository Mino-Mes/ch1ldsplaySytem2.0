<?php require "../Util/dbconn.php"; ?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>MyAlbums</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/snack_back.css"/>
    <link rel="stylesheet" href="../css/ln_snackbar.css">
    <style>
        th, td {
            vertical-align: middle;
        }
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
            <p>This page allows the adminstrator to view all active albums. Furthermore, it allows the user to update
                any active album and add any type of album </p>
        </header>
        <?php
        $sql = "SELECT * FROM album WHERE album_id=" . $_GET["id"];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $albumTitle = $row["album_title"];
                $img = $row["album_img"];
                $creator = $row["user_id"];
                $label = $row["album_label"];
                $type = $row["typeId"];
                $isActive = $row["album_isActive"];
                $description = $row["album_description"];
            }
        }
        ?>
        <div class="inner style2">

            <form method="post" action="#" class="alt" enctype="multipart/form-data">
                <div class="row gtr-uniform">
                    <!-- Break -->
                    <div class="col-12">
                        <ul class="actions" style="float:right">
                            <li><input type="submit" value="Update Album Information" /></li>
                        </ul>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Album Title
                        </label>
                        <input type="text" name="albumTitle" id="albumTitle" value="<?=$albumTitle?>" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Album Label
                        </label>
                        <input type="email" name="albumLabel" id="albumLabel" value="<?=$label?>"/>
                    </div>
                    <!-- Break -->
                    <div class="col-12">
                        <label>
                            Album Type
                        </label>
                        <select name="type" id="type">
                            <?php
                            $sql = "SELECT * FROM type";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                     if($type == $row["typeId"])
                                     {?>
                                         <option value="<?php echo $row["typeId"] ?>" selected><?php echo $row["typeName"] ?></option>
                                         <?php
                                     }else
                                     {?>
                                         <option value="<?php echo $row["typeId"] ?>"><?php echo $row["typeName"] ?></option>
                                    <?php }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Break -->
                    <div class="col-6 col-12-small">
                        <?php
                            if($isActive == 1)
                            {?>
                                <input type="checkbox" id="isActive" name="isActive" checked>
                            <?php
                            }
                            else{
                                ?>
                                <input type="checkbox" id="isActive" name="isActive">
                            <?php
                            }
                        ?>

                        <label for="isActive">Album is Active</label>
                    </div>
                    <!-- Break -->
                    <div class="col-12">
                        <textarea name="albumDescription" id="albumDescription" rows="6"></textarea><script>document.getElementById("albumDescription").value="<?=$description?>"</script>
                    </div>

                <div class="col-6">
                    <h4>Album Cover Image</h4>
                    <span class="image fit"><img src="<?=$img?>" style="width:100%;" id="uploadPreview" alt="" /></span>
                </div>
                <div class="col-6" >
                    <label>
                        Enter gallery image file
                    </label>
                    <input id="uploadImage" type="file" name="myPhoto" id="myPhoto" onchange="PreviewImage();" />
                </div>
            </form>

            <ul class='actions' >
                <li><a href="javascript:void(0)" onclick="addPhotoModal()" class="button alt">+Add a photograph</a></li>
            </ul>
            <h4>List of Photographs in album</h4>
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Image Path</th>
                        <th>Photo Id</th>
                        <th>Creator Id</th>
                        <th>album_id</th>
                        <th>isActive</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql2 = "SELECT * from photo WHERE album_id =" . $_GET["id"];
                    $result2 = $conn->query($sql2);

                    if ($result2->num_rows > 0) {
                        while ($photo = $result2->fetch_assoc()) {
                            $photo_id = $photo["photo_id"];
                            $user_id = $photo["user_id"];
                            $photo_img = $photo["photo_img"];
                            $photo_isActive = $photo["photo_isActive"];

                            if ($photo_isActive == 1) {
                                $photo_isActive = "Active";
                            } else {
                                $photo_isActive = "Disabled";
                            }

                            echo "<tr><td style='width:30%;'><img src='$photo_img' alt=\"\" style='width:90%;'/></td><td>$photo_id</td><td>$user_id</td><td>$photo_isActive</td><td><ul class=\"actions fit small\"><li><a href=\"#\" class=\"button fit small\">Update</a></li></ul></td></tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
</div>
</section>
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1 style="text-align: center">Add a Photograph</h1>
        <div class="row gtr-uniform">
            <div class="col-12">
                <label>
                    Input the Files
                </label>
                <input id="photos" type="file" name="photos" multiple/>
            </div>
        </div>
        <br>
        <div class="col-12">
            <ul class="actions special">
                <li>
                    <button class="button next" type="button" id="submit" onclick="addImage()" >Add Photo</button>
                </li>
            </ul>
        </div>
        <div id="snackbar"></div>
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
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.dropotron.min.js"></script>
<script src="../assets/js/jquery.scrollex.min.js"></script>
<script src="../assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>
<script>

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
    function addPhotoModal() {
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

    function addImage()
    {

        var imgfiles=document.getElementById("photos");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var x = document.getElementById("snackbar");
                x.innerHTML = this.responseText;
                x.className = "show";
                setTimeout(function () {
                    x.className = x.className.replace("show", "");
                }, 3000);
                showTypeList();
            }
        };
        xhttp.open("POST", "../Util/addPhoto.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+<?=$_GET["id"]?>  + "&files=" + imgfiles);
    }

</script>

</body>
</html>