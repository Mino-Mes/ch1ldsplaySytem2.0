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
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
        <link rel="stylesheet" href="../css/myAlbums.css">
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
                                <ul class='actions special' >
                                    <li><a href="javascript:void(0)"  onclick="showAllUsers()" class="button alt" style="float:left;">Show All Users</a></li>
                                    <li><a href="javascript:void(0)" class="button alt" style="float:left;">Specify</a></li>
                                </ul>
                                <form method="POST" action="#" class="alt">
                                    <div class="row gtr-uniform">
                                        <div class="col-4">
                                        </div>
                                        <div class="col-5">
                                            <input type="radio" id="type1" name="type"  onclick="defaultSettings()" checked>
                                            <label for="type1">Show All Users (default)</label>
                                            <input type="radio" id="type2" name="type" onclick="showAdvancedSettings()">
                                            <label for="type2"> +Advanced</label>

                                        </div>
                                        <div class="col-3">
                                        </div>
                                        <div class="col-12" id="advancedContainer">

                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderFname" name="order"  checked>
                                            <label for="orderFname">First Name</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderLname" name="order">
                                            <label for="orderLname">Last Name</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderNewest" name="order">
                                            <label for="orderNewest">Creation Date (Newest)</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderOldest" name="order">
                                            <label for="orderOldest">Creation Date (Oldest)</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderUserId" name="order">
                                            <label for="orderUserId">UserId</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="orderUsername" name="order">
                                            <label for="orderUsername">Username</label>
                                        </div>
                                        <div class="col-4" id="orderViewsContainer">

                                        </div>
                                        <div class="col-12">
                                            <h4>Date</h4>
                                            <input type="radio" name="date" id="allTime" onclick="dateRange(0)">
                                            <label for="allTime"> All Time</label>
                                            <input type="radio" name="date" id="rangeDate" onclick="dateRange(1)">
                                            <label for="rangeDate">Range</label>
                                            <div id="dateRangeContainer">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h4>User Type</h4>
                                            <input type="checkbox" name="customerC" id="customerC">
                                            <label for="customerC">Customer</label>
                                            <input type="checkbox" name="collaboratorC" id="collaboratorC">
                                            <label for="collaboratorC">Collaborator</label>
                                            <input type="checkbox" name="adminC" id="adminC">
                                            <label for="adminC">Administrator</label>
                                        </div>
                                        <div class="col-12">
                                            <h4>Creator Views</h4>
                                            <input type="checkbox" name="showViews" id="showViews" onclick="orderByViews()">
                                            <label for="showViews">Show Creator Views</label>
                                            <h4>Creator</h4>
                                            <input type="checkbox" name="albumsC" id="albumsC">
                                            <label for="albumsC">Number of Albums</label>
                                            <input type="checkbox" name="photoC" id="photoC">
                                            <label for="photoC">Number of Photographs</label>
                                        </div>
                                        <div class="col-12">
                                            <h4>Search a user</h4>
                                            <label for="lastNameS">by Last Name</label>
                                            <input type="text" name="lastNameS" id="lastNameS" style="width:50%;">
                                            <label for="usernameS">by Username</label>
                                            <input type="text" name="usernameS" id="usernameS" style="width:50%;">

                                        </div>
                                    </div>
                                </form>
                                <input type="checkbox" id="demo-priority-low" name="demo-priority" checked>
                                <div id="tableContainer">

                                </div>
                            </div>
                            <div id="Albums" class="tabcontent">
                            </div>
                            <div id="Photographs" class="tabcontent">
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

        function showAllUsers()
        {
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
        }
        function showAdvancedSettings()
        {
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
        function defaultSettings()
        {
            var x =document.getElementById("advancedContainer");
            x.innerHTML="";
        }
        function dateRange(isActive) {
            if (isActive == 1) {
                document.getElementById("dateRangeContainer").innerHTML = "<label>Specify Date</label><input type='date' name='dateS' id='dateS'>";
            }
            if (isActive == 0) {
                document.getElementById("dateRangeContainer").innerHTML = "";
            }

        }
        function orderByViews()
        {
            var x=document.getElementById("showViews");
            if(x.checked ==true)
            {
                document.getElementById("orderViewsContainer").innerHTML="asdasd";
            }else if(x.checked ==false)
            {
                document.getElementById("orderViewsContainer").innerHTML=" ";
            }

        }


    </script>

	</body>
</html>