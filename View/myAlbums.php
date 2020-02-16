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

        /* Style tab links */
        .tablink {
            background-color: #3dc5ad;
            color: white;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            width: 20%;
        }

        .tablink:hover {
            background-color: #777;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            display: none;
            padding: 100px 20px;
            height: 100%;
        }

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

        .tabcontent {
            animation: fadeEffect 1s; /* Fading effect takes 1 second */
        }

        /* Go from zero to full opacity */
        @keyframes fadeEffect {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
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
        <div class="inner style2">

            <ul class='actions' style="float: right">
                <li><a href="addAlbum.php" class="button alt">+Add an Album</a></li>
                <li><a href='javascript:void(0)' onclick="addTypeModal()" class='button alt' id='myBtn'> +Add a
                        Type </a></li>
            </ul>
            <div class="col-6 col-12-small">
                <input type="checkbox" id="seeActive" name="seeActive" onclick='showTypeList()' >
                <label for="seeActive">Show Active Types Only</label>
            </div>
            <div class="col-6 col-12-small">
                <input type="checkbox" id="activeAlb" name="activeAlb">
                <label for="activeAlb">Show Active Albums Only</label>
            </div>
            <button class="tablink" onclick="openPage('Albums', this, 'black')" id="defaultOpen">Albums</button>
            <button class="tablink" onclick="openPage('types', this, 'black'),showTypeList()">Types</button>

            <div id="Albums" class="tabcontent">
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
                        $sql = "SELECT * from album";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($albums = $result->fetch_assoc()) {
                                $id = $albums["album_id"];
                                $user_id = $albums["user_id"];
                                $album_title = $albums["album_description"];
                                $album_description = $albums["album_description"];
                                $album_label = $albums["album_label"];
                                $album_img = $albums["album_img"];
                                $album_isActive = $albums["album_isActive"];
                                $album_type = $albums["typeId"];

                                if ($album_isActive == 1) {
                                    $album_isActive = "Active";
                                } else {
                                    $album_isActive = "Disabled";
                                }

                                echo "<tr><td><div class=\"row gtr-1 gtr-uniform\"><div class=\"col-12\"><span class=\"image fit\"><img src='$album_img' alt=\"\" /></span></div></div></td><td>$id</td><td>$user_id</td><td>$album_title</td><td>$album_description</td><td>$album_label</td><td>$album_type</td><td>$album_isActive</td><td><ul class=\"actions fit small\"><li><a href=\"viewAlbum.php?id=$id\" class=\"button fit small\">Update</a></li></ul></td></tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div id="types" class="tabcontent">

            </div>
        </div>
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
        <div id="snackbar"></div>
    </div>
</div>
<div id="updateType" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1 style="text-align: center">Update a Type</h1>
        <div class="row gtr-uniform">
            <div class="col-12">
                <label>
                    Type Name
                </label>
                <input id="typeName" type="text" name="typeName"/>
            </div>
            <div class="col-12">
                <input type="checkbox" id="active" name="active">
                <label for="active">Set type to Active</label>
            </div>
            <input type="hidden" id="id" name="id"/>
        </div>
        <br>
        <div class="col-12">
            <ul class="actions special">
                <li>
                    <button class="button next" type="button" id="submit" onclick="updateTypeSQL()">Update Type</button>
                </li>
            </ul>
        </div>
        <div id="snackbar1" class="snackbar"></div>
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
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.dropotron.min.js"></script>
<script src="../assets/js/jquery.scrollex.min.js"></script>
<script src="../assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>
<script>
    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

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

    function updateType(row) {
        var name = document.getElementById("typeTable").rows[row].cells[1].innerHTML;
        var active = document.getElementById("typeTable").rows[row].cells[2].innerHTML;
        var id = document.getElementById("typeTable").rows[row].cells[0].innerHTML;

        document.getElementById("typeName").value = name;
        if (active == "Active") {
            document.getElementById("active").checked = true;
        } else {
            document.getElementById("active").checked = false;
        }

        document.getElementById("id").value = id;
        // Get the modal
        var modal = document.getElementById("updateType");

        modal.style.display = "block";

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[1];

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

    function updateTypeSQL() {
        var id = document.getElementById("id").value;
        var name = document.getElementById("typeName").value;
        if (document.getElementById("active").checked) {
            var isActive = 1;
        } else {
            var isActive = 0;
        }

        var xhttp1 = new XMLHttpRequest();
        xhttp1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var x = document.getElementById("snackbar1");
                x.innerHTML = this.responseText;
                x.className = "show";
                setTimeout(function () {
                    x.className = x.className.replace("show", "");
                }, 3000);

                showTypeList();
            }
        };
        xhttp1.open("POST", "../Util/updateType.php", true);
        xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp1.send("id=" + id + "&name=" + name + "&active=" + isActive);
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
                showTypeList();
            }
        };
        xhttp1.open("POST", "../Util/addTypeLogic.php", true);
        xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp1.send("type=" + typeName);
    }

    function showTypeList() {
        if (document.getElementById("seeActive").checked) {
            var active = 1;
        } else {
            var active = 0;
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("types").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "../Util/showType.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("active=" + active);
    }


</script>

</body>
</html>