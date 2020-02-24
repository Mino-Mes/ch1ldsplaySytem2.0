<?php

require "dbconn.php";
require "navOtherPages.php";
include 'Popup_return_handler.php';
session_start();

//onlyAdmin();
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
<head>
    <title>Chi1dsplay Media Production | Report</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/myAlbums.css">

    <style>
        th, td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <?php nav(); ?>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Report Page</h1>
        </header>
        <div class="inner style2">
            <ul class="actions special" style="width: 100%;">
                <li>
                    <button class="tablink" onclick="openPage('Users', this, 'black')"
                            id="defaultOpen">
                        Users
                    </button>

                    <button class="tablink" onclick="openPage('Albums', this, 'black')">Albums</button>

                    <button class="tablink" onclick="openPage('Photographs', this, 'black')">Photographs</button>
                </li>
            </ul>
            <div id="Users" class="tabcontent">
                <form method="POST" name="userReport" id="userReportForm" class="alt">
                    <div class="row gtr-uniform" style="text-align: center">
                        <div class="col-12">
                            <h4 style="text-align: center">Search Type</h4>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-5">
                            <input type="radio" id="type1" name="type" value="default" onclick="defaultSettings()"
                                   checked>
                            <label for="type1">Show All Users (default)</label>
                            <input type="radio" id="type2" name="type" value="advanced"
                                   onclick="showAdvancedSettings()">
                            <label for="type2"> +Advanced</label>

                        </div>
                        <div class="col-3">
                        </div>
                        <div class="col-12" id="advancedContainer" style="text-align: center;">

                        </div>
                        <div class="col-12">
                            <h4 style="text-align: center">Order By</h4>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderFname" value="fname" name="order">
                            <label for="orderFname">First Name</label>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderLname" value="lname" name="order">
                            <label for="orderLname">Last Name</label>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderNewest" name="order" value="newest">
                            <label for="orderNewest">Creation Date (Newest)</label>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderOldest" name="order" value="oldest">
                            <label for="orderOldest">Creation Date (Oldest)</label>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderUserId" name="order" value="id" checked>
                            <label for="orderUserId">UserId</label>
                        </div>
                        <div class="col-2">
                            <input type="radio" id="orderUsername" name="order" value="username">
                            <label for="orderUsername">Username</label>
                        </div>
                        <div class="col-4" id="orderViewsContainer">

                        </div>

                    </div>
                    <ul class="actions special">
                        <li><input type="submit" value="Generate Report"></li>
                    </ul>
                </form>
                <div id="tableContainer">

                </div>
            </div>
            <div id="Albums" class="tabcontent">
                <form method="POST" id="albumForm">
                    <div class="row gtr-uniform" style="text-align: center">
                        <div class="col-12">
                            <h4 style="text-align: center">Search Type</h4>
                        </div>
                        <div class="col-3">

                        </div>
                        <div class="col-6">
                            <input type="radio" name="search" id="search1" value="search" onclick="showAlbumSearch(1)"/>
                            <label for="search1">Search by Title</label>
                         <!--   <input type="radio" name="search" id="search2" value="search1"
                                   onclick="showAlbumSearch(2)"/>
                            <label for="search2">Search by Creator</label>-->
                            <input type="radio" name="search" id="all" value="all" onclick="showAlbumSearch(0)"
                                   checked/>
                            <label for="all">All Albums</label>
                            <div id="searchBoxContainer">

                            </div>
                        </div>
                        <div class="col-3">

                        </div>
                        <div class="col-12">
                            <h4 style="text-align: center">Specify</h4>
                        </div>
                        <div class="col-4">

                        </div>
                        <div class="col-4">
                            <input type="checkbox" name="images" id="images">
                            <label for="images">Images</label>
                            <input type="checkbox" name="albumViews" id="albumViews" onclick="orderByViews1()">
                            <label for="albumViews">Album Views</label>
                        </div>
                        <div class="col-4">

                        </div>
                        <div class="col-12">
                            <h4 style="text-align: center">Order By</h4>
                        </div>
                        <div class="col-3">

                        </div>
                        <div class="col-6">
                            <input type="radio" name="albumOrder" id="orderTitle" value="orderTitle">
                            <label for="orderTitle">Title</label>
                            <input type="radio" name="albumOrder" id="orderId" value="orderId" checked>
                            <label for="orderId">Album Id</label>
                            <div id="orderByViewsContainer">

                            </div>
                        </div>
                        <div class="col-3">

                        </div>

                        <ul class="actions special">
                            <li><input type="submit" value="Generate Report"></li>
                        </ul>
                    </div>
                </form>
                <div id="AlbumtableContainer">

                </div>
            </div>
            <div id="Photographs" class="tabcontent">
                <form method="POST" id="PhotoForm">
                    <div class="row gtr-uniform" style="text-align: center">
                        <div class="col-12">
                            <h4 style="text-align: center">Search Type</h4>
                        </div>
                        <div class="col-12">
                            <label>Search by Creator username</label>
                            <input type="text" name="creatorSearch" id="creatorSearch" placeholder="Search creator username">
                        </div>
                    </div>
                </form>
                <div id="photoReportContainer">

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php footer(); ?>

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
    $(document).ready(function(){
        $('#creatorSearch input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var showban = true; //this var is probably not need - remove later
            var resultDropdown = $("#photoReportContainer");
            if(inputVal.length){
                $.get("report2Logic.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });
    });

    $("form#albumForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "report2Logic.php",
            type: "POST",
            data: formData,
            success: function (data) {
                document.getElementById("AlbumtableContainer").innerHTML = data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $("form#userReportForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "report2Logic.php",
            type: "POST",
            data: formData,
            success: function (data) {
                document.getElementById("tableContainer").innerHTML = data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

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

    document.getElementById("defaultOpen").click();


    /* function showAllUsers() {
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function () {
             if (this.readyState == 4 && this.status == 200) {
                 var x = document.getElementById("tableContainer");
                 x.innerHTML = this.responseText;
             }
         };
         xhttp.open("POST", "report2Logic.php", true);
         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhttp.send("function=showAllUsers");
     }*/

    function showAdvancedSettings() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var x = document.getElementById("advancedContainer");
                x.innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "report2Logic.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=showAdvancedSettings");
    }

    function defaultSettings() {
        var x = document.getElementById("advancedContainer");
        x.innerHTML = "";
    }

    function dateRange(isActive) {
        if (isActive == 1) {
            document.getElementById("dateRangeContainer").innerHTML = "<label>Specify Date</label><input type='datetime-local' name='dateS' id='dateS'>";
        }
        if (isActive == 0) {
            document.getElementById("dateRangeContainer").innerHTML = "";
        }

    }

    function orderByViews() {
        var x = document.getElementById("showViews");
        if (x.checked == true) {
            document.getElementById("orderViewsContainer").innerHTML = "<input type='radio'name='order' id='lowViews' value='lowViews'><label for='lowViews'>Lowest Views</label><input type='radio'name='order' id='HighViews' value='HighViews'><label for='HighViews'>Highest Views</label>";
        } else if (x.checked == false) {
            document.getElementById("orderViewsContainer").innerHTML = " ";
        }
    }

    function showAlbumSearch(isActive) {
        if (isActive == 1) {
            document.getElementById("searchBoxContainer").innerHTML = "<label>Enter Title</label><input type='text' name='albumTitle' id='albumTitle'>";
        }
        /*    else if(isActive ==2)
            {
                document.getElementById("searchBoxContainer").innerHTML = "<label>Enter Creator username</label><input type='text' name='albumCreator' id='albumCreator'>";
            }*/
        else if (isActive == 0) {
            document.getElementById("searchBoxContainer").innerHTML = " ";
        }
    }

    function orderByViews1() {
        var x = document.getElementById("albumViews");

        if (x.checked == true) {
            document.getElementById("orderByViewsContainer").innerHTML = "<input type='radio' name='albumOrder' id='LowOrderViews' value='LowOrderViews'><label for='LowOrderViews'>Low Views</label><input type='radio' name='albumOrder' id='highOrderViews' value='highOrderViews'><label for='highOrderViews'>Highest View</label>"
        } else {
            document.getElementById("orderByViewsContainer").innerHTML = "";
        }
    }


</script>

</body>
</html>