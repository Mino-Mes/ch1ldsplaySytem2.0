<?php
session_start();
require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
$_SESSION['current_page'] = 'admin_command';

onlyAdmin();
?>
<html>
	<head>
        <title>Ch1ldsplay Media Production | Manage Users</title>
        <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../assets/css/main.css"/>
    </head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				<?php nav();?>

				<!-- Section -->
					<section class="main alt">
						<header>
							<h1>User Management</h1>
						</header>
						<div class="inner style2">
                            <h3>User Search</h3>

                            <form method="post" action="#" class="alt">
                                <div class="row gtr-uniform">
                                    <div class="col-12 col-12-xsmall" class="search-box">
                                        <input type="text" name="demo-name" class="search-box" id="demo-name" value="" placeholder="Search username..." />
                                    </div>
                                    <div class="col-4 col-12-xsmall">
                                        <input type="checkbox" id="demo-human" name="demo-human" checked>
                                        <label for="demo-human">Include banned users</label>
                                    </div>
                                </div>
                            </form>
                            <!-- the dynamic table goes here -->
                            <div class="result">
                                <?php
                                if(isset($_SESSION['msg_modify'])){
                                    echo $_SESSION['msg_modify'];
                                    unset($_SESSION['msg_modify']);
                                }
                                ?>
                            </div>

						</div>
					</section>

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

            <script type="text/javascript">
                $(document).ready(function(){
                    $('.search-box input[type="text"]').on("keyup input", function(){
                        /* Get input value on change */
                        var inputVal = $(this).val();
                        var resultDropdown = $(".result");
                        if(inputVal.length){
                            $.get("../Util/Manage_users_backend.php", {term: inputVal}).done(function(data){
                                // Display the returned data in browser
                                resultDropdown.html(data);
                            });
                        } else{
                            resultDropdown.empty();
                        }
                    });
                });
            </script>
	</body>
</html>