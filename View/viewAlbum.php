<?php require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
session_start();?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>Ch1ldsplay Media Production | viewAlbums</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/snack_back.css"/>
    <link rel="stylesheet" href="../css/ln_snackbar.css">
    <link rel="stylesheet" href="../css/viewAlbum.css">
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
  <?php nav();?>
    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Update Album Page</h1>
            <p>This page allows the administrator to update an album information and add photographs to it. </p>
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

            <form method="post" action="../Util/updateAlbumInfo.php" id="updateForm" class="alt" enctype="multipart/form-data">
                <div class="row gtr-uniform">
                    <!-- Break -->
                    <div class="col-12">
                        <ul class="actions" style="float:right">
                            <li><input type="submit" value="Update Album Information" form="updateForm"/></li>
                            <li><a href="javascript:void(0)" onclick="addPhotoModal()" class="button alt">+Add a
                                    photograph</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Album Title
                        </label>
                        <input type="text" name="albumTitle" id="albumTitle" value="<?= $albumTitle ?>"/>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <label>
                            Album Label
                        </label>
                        <input type="text" name="albumLabel" id="albumLabel" value="<?= $label ?>"/>
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
                                    if ($type == $row["typeId"]) {
                                        ?>
                                        <option value="<?php echo $row["typeId"] ?>"
                                                selected><?php echo $row["typeName"] ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $row["typeId"] ?>"><?php echo $row["typeName"] ?></option>
                                    <?php }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" value="<?= $_GET["id"] ?>" id="id" name="id"/>
                    <!-- Break -->
                    <div class="col-6 col-12-small">
                        <input type="checkbox" id="isActive" name="isActive" <?php if($isActive == 1) {echo "checked";}?>>
                        <label for="isActive">Album is Active</label>
                    </div>
                    <!-- Break -->
                    <div class="col-12">
                        <textarea name="description" id="description" rows="6"></textarea>
                        <script>document.getElementById("description").value = "<?=$description?>"</script>
                    </div>
                    <input type="hidden" value="<?= $img ?>" id="dfltImage" name="dfltImage"/>
                    <div class="col-6">
                        <h4>Album Cover Image</h4>
                        <span class="image fit"><img src="<?= $img ?>" style="width:100%;" id="uploadPreview"
                                                     alt=""/></span>
                    </div>

                    <div class="col-6">
                        <label>
                            Enter gallery image file
                        </label>
                        <input id="uploadImage" type="file" name="myPhoto" id="myPhoto" onchange="PreviewImage();"/>
                    </div>
            </form>
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
                }
            }
            ?>

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
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="listContainer">
                    <?php

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
        <form method="POST" action="../Util/addPhoto.php" id="addPhotoForm" enctype="multipart/form-data" class="alt">
            <div class="row gtr-uniform">
                <div class="col-12">
                    <label>
                        Input the Files
                    </label>
                    <input id="photos[]" type="file" name="photos[]" multiple="multiple"/>
                </div>
            </div>
            <input type="hidden" name="albumId" id="albumId" value="<?= $_GET["id"] ?>"
            <br>
            <div class="col-12">
                <ul class="actions special">
                    <li>
                        <button class="button next" type="submit" id="submit">Add Photo</button>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>
<div id="deleteP" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h4 style="text-align: center">Are you sure you want to delete the photograph ? </h4>
        <input type="hidden" id="photoIdHidden"/>
        <ul class="actions special">
            <li>
                <button class="button next" type="button"  onclick="deletePhoto()" style="background-color: red;" id="deleteBtn">Delete Photo</button>
            </li>
        </ul>
    </div>
</div>
<div id="snackbar"></div>
<?php
if (isset($_GET["message"])) {
    ?>
    <script>
        function showSnackBar() {
            var x = document.getElementById("snackbar");
            x.innerHTML = "<?=$_GET["message"]?>";
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
<script src="../Util/viewAlbumFunctions.js"></script>
<script>

    function addImage() {

        var imgfiles = document.getElementById("photos");
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
        xhttp.send("id=" + <?=$_GET["id"]?> + "&files=" + imgfiles.value);
    }

    function showAlbumPhotoList() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var x = document.getElementById("listContainer");
                x.innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "../Util/showPhotoList.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + <?=$_GET["id"]?>);
    }

    showAlbumPhotoList();
</script>

</body>
</html>