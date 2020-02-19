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
    <title>CH1ldsplay Media Production | MyAlbums</title>
    <meta charset="utf-8"/>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../css/myAlbums.css">
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/snack_back.css"/>
    <link rel="stylesheet" href="../css/ln_snackbar.css">
    <style>

        th, td {
            vertical-align: middle;
        }

    </style>

</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <?php nav(); ?>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Administrative Functions Page</h1>
            <p>This page allows the administrator to view all active albums. Furthermore, it allows the user to update
                any active album and add any type of album while also giving the option to add photographs to an
                existing user.</p>
        </header>
        <div class="inner style2">

            <ul class='actions' style="float: right">
                <li><a href="addAlbum.php" class="button alt">+Add an Album</a></li>
                <li><a href='javascript:void(0)' onclick="addTypeModal()" class='button alt' id='myBtn'> +Add a
                        Type </a></li>
            </ul>
            <div class="col-6 col-12-small">
                <input type="checkbox" id="seeActive" name="seeActive" onclick='showTypeList()'>
                <label for="seeActive">Show Active Types Only</label>
            </div>
            <div class="col-6 col-12-small">
                <input type="checkbox" id="activeAlb" name="activeAlb" onclick="showAlbumList()">
                <label for="activeAlb">Show Active Albums Only</label>
            </div>
            <ul class="actions special" style="width: 100%;">
                <li>
                    <button class="tablink" onclick="openPage('Albums', this, 'black'), showAlbumList()"
                            id="defaultOpen">
                        Albums
                    </button>

                    <button class="tablink" onclick="openPage('types', this, 'black'),showTypeList()">Types</button>

                    <button class="tablink" onclick="openPage('userAlbum', this, 'black')">User Albums</button>
                </li>
            </ul>
            <div id="Albums" class="tabcontent">
                <h4>List of Current Albums</h4>
                <div class="table-wrapper">
                    <table style="width:100%;">
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
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody id="albumContainer">

                    </table>
                </div>
            </div>

            <div id="types" class="tabcontent">
                <div id="result">

                </div>
            </div>

            <div id="userAlbum" class="tabcontent">
                <label>
                    Input User username (<em>Write 'All' to view All users</em>)
                </label>
                <input id="search-box" type="text" placeholder="Search username"/>
                <div id="search-table" class="table-wrapper" style="margin-top:4%;">

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
                    <input id="name1" type="text" name="name1"/>
                </div>
            </div>
            <br>
            <div class="col-12">
                <ul class="actions special">
                    <li>
                        <button class="button next" type="button" id="submit" onclick="UploadType(),showTypeList()">
                            Create
                            Type
                        </button>
                    </li>
                </ul>
            </div>
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
                        <button class="button next" type="button" id="submit" onclick="updateTypeSQL()">Update Type
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="snackbar1" class="snackbar"></div>
    <div id="delete" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4 style="text-align: center">Are you sure you want to delete this element ? </h4>
            <input type="hidden" id="hiddenId"/>
            <input type="hidden" id="functionName">
            <ul class="actions special">
                <li>
                    <button class="button next" type="button" onclick="deleteObject()" style="background-color: red;"
                            id="deleteBtn">Delete
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div id="addPhotographs" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4 style="text-align: center">Add Photos to a User</h4>
            <form id="addPhotoUserForm" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hiddenUserId" name="hiddenUserId"/>
                <label>
                    Insert Files
                </label>
                <input type="file" id="userPhotos[]" name="userPhotos[]" multiple="multiple"
                       style="margin-bottom:5%; "/>
                <ul class="actions special">
                    <li>
                        <button class="button next" type="submit" id="addPhotoBtn">Add Photographs Button</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <div id="viewYourPhotographs" class="modal1">
        <!-- Modal content -->
        <div class="modal1-content">
            <span class="close">&times;</span>
            <h4>List of Photographs in album</h4>
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Image Path</th>
                        <th>Photo Id</th>
                        <th>Creator Id</th>
                        <th>Active</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="listContainer">

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div id="snackbar"></div>
    <!-- Footer -->
  <?php footer();?>

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
<script src="../Util/myAlbumsFunctions.js"></script>
</body>
</html>