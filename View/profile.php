<?php
require "../Util/dbconn.php";
require "../Util/navOtherPages.php";
session_start();
if(!isset($_SESSION["ln_usertype"]))
{
    header("Location:index.php");
    exit();
}
if(isset($_GET["logout"]))
{
    logout();
}
?>
<!DOCTYPE HTML>
<!--
	Relativity by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
	<head>
        <title>Ch1ldsplay Media Production | User Profile</title>
        <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
        <link rel="stylesheet" href="../assets/css/main.css"/>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				<?php nav();?>

                <?php
                    $sql="SELECT * FROM user WHERE user_id=".$_SESSION["ln_userId"];
                    $result=$conn->query($sql);

                    if($result->num_rows >0)
                    {
                        while($row=$result->fetch_assoc())
                        {
                            $fname=$row["user_fname"];
                            $lname=$row["user_lname"];
                            $email=$row["user_email"];
                            $auth=$row["user_authentication"];
                            $username=$row["user_username"];
                        }
                    }
                ?>
				<!-- Section -->
					<section class="main alt">
						<header>
							<h1>Account Information</h1>
						</header>

                            <div class="box" style='width: 50%;margin-left: 25%;margin-right: 25%;background-color: white;'>
                              <div style="text-align: center;">
                                  <h4>Username</h4><p><?=$username?></p>
                                  <h4>Full Name </h4> <p><?=$fname?> <?=$lname?></p>
                                  <h4>Email</h4><p><?=$email?></p>
                                  <h4>Account Type</h4><p><?=$auth?></p>
                                  <form method="GET" action="profile.php?">
                                      <input type="hidden" value="1" id="logout" name="logout"/>
                                      <ul class="actions special">
                                          <li style="color:white;"><button type="submit" class="button " style="color:white;background-color: red;">Log Out</button></li>
                                      </ul>
                                  </form>
                              </div>
						</div>
                   <!--     <div class="box" style='width: 50%;margin-left: 25%;margin-right: 25%;background-color: white;'>
                            <div>
                                <h4  style="text-align: center;">Change Password</h4>
                                <form>
                                    <label>
                                        Input New Password
                                    </label>
                                    <input type="password" id="psswd" name="psswd"/>
                                    <label>
                                        Confirm New Password
                                    </label>
                                    <input type="password" id="new_psswd" name="new_psswd"/>
                                    <ul class="actions special" style="margin-top: 2%;">
                                        <li ><a href="#" class="button " >Update Password</a></li>
                                    </ul>
                                </form>
                            </div>
                        </div>-->

					</section>

				<!-- Footer -->
			<?php
            footer();
            ?>

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
<?php

function logout(){
    unset($_SESSION['ln_username']);
    unset($_SESSION['ln_usertype']);
    unset($_SESSION['ln_userId']);
    header('Location: ../View/index.php');
    exit();
}

?>

	</body>
</html>