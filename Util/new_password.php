<?php
    session_start();
    require("dbconn.php");
    //this is what you need to get
    //"new_password.php?token=" . $token . "
    $token = '';
    try{
        $token = $_GET['token'];
        //might need to try this instead
        //$token = $_SESSION['token'];
    }
    catch(Exception $e)
    {
        echo 'Error: could not retrieve token!';
    }
?>
<html>
<head>
    <title>Untitled</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css"/>
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
                <li><a href="../orange/elements.html">Elements</a></li>
            </ul>
        </nav>

    </header>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Password Reset</h1>
        </header>
        <div class="inner style2" style="padding:10px;margin:auto;width:90%;">
            <?php
                if(!isset($_GET['pass'])) {
                    ?>
                    <h3>Enter New Password</h3>

                    <form method="post" action="new_password.php" class="alt">
                        <div class="row gtr-uniform">
                            <div class="col-12 col-12-xsmall" id="search-box">
                                <input type="text" name="new_pass" id="demo-name" value=""
                                       placeholder="Enter new password..." style="width:27%;"/>
                                <input type="submit" value="Reset">
                            </div>
                        </div>
                    </form>
                    <div id="result">
                    </div>
                    <?php
                }
                else{
                    //might need some revising
                    $sql = 'SELECT reset_email,reset_isActive FROM password_reset WHERE reset_token = "'.$token.'"';
                    $res->$conn->query($sql) or die('Error: Database Error');
                    $email = '';
                    if($res->num_rows > 0){
                        while($row = $res->fetch_assoc())
                        {
                            if($row['reset_isActive'])
                            {
                                $email = $row['reset_email'];
                            }
                        }
                    }
                    //reset_password TABLE WILL ALSO NEED A is_active field
                    $hash=password_hash($pass,PASSWORD_BCRYPT);
                    $sql2 = 'UPDATE user SET user_password = "'.$hash.'" WHERE user_email = "'.$email.'"';
                    $res->$conn->query($sql2) or die ('Error: Database Error');

                    //now set reset_isActive to 0, so the user can't repeatedly reset password
                    $sql3 = 'UPDATE password_reset SET reset_isActive = 0 WHERE reset_email = "'.$email.'"' ;
                    $res->$conn->query($sql3) or die ('Error: Database Error');

                    ?>
                    <div><p>Password has been reset!</p></div>
                    <?php
                }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
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

</body>
</html>