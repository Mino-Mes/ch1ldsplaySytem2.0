<?php

function onlyAdmin(){
    //checks if the user is an admin, if not, send them back to index
    if(isset($_SESSION['ln_usertype'])){
        if($_SESSION['ln_usertype'] != "administrator") {
            unset($_SESSION['ln_usertype']);
            unset($_SESSION['ln_username']);
            unset($_SESSION['ln_userId']);
            header('Location: ../View/index.php');
        }
    }
}

function isCollab()
{
    if(isset($_SESSION['ln_usertype'])){
        if($_SESSION['ln_usertype'] != "collaborator" && $_SESSION['ln_usertype'] != "administrator" ) {
            unset($_SESSION['ln_usertype']);
            unset($_SESSION['ln_username']);
            unset($_SESSION['ln_userId']);
            header('Location: ../View/index.php');
        }
    }else{
        header('Location: ../View/index.php');
    }
}
    //call this function immediately on all admin pages
    function check_auth($authorization){
        //checks if the user is an admin, if not, send them back to index
        if(isset($_SESSION['ln_usertype'])){
            if($_SESSION['ln_usertype'] != $authorization) {
                unset($_SESSION['ln_usertype']);
                unset($_SESSION['ln_username']);
                unset($_SESSION['ln_userId']);
                header('Location: ../View/index.php');
            }
        }
    }
    function logout(){
        unset($_SESSION['ln_username']);
        unset($_SESSION['ln_usertype']);
        unset($_SESSION['ln_userId']);
        header('Location: ../View/index.php');
    }

    function nav()
    {
        if(isset($_SESSION["ln_usertype"]))
        { $user_name =$_SESSION["ln_username"];
            if($_SESSION["ln_usertype"] == "administrator")
            {

                echo "<header id=\"header\" >

        <!-- Logo -->
        <div class=\"logo\">
            <strong><a href='javascript:void(0)'>Hello, $user_name</a></strong>
        </div>

        <!-- Nav -->
        <nav id=\"nav\">
            <ul id=\"nav_ul\">
                <li class=\"current\"><a href=\"../View/index.php#scrollToHome\">Home</a></li>
                <li><a href=\"../View/index.php#scrollToAl\">Album</a></li>
                <li><a href=\"../View/index.php#scrollToB\">Inquiries</a></li>
                <li><a href='../View/yourPhotographs.php'>YourPhotographs</a></li>
                <li><a href='../View/myAlbums.php'>Administrative Functions</a></li>
                <li><a href='../View/Manage_users.php'>Manage Users</a></li>
                <li><a href='../View/Reports.php'>Reports</a></li>
            </ul>
        </nav>

    </header>";
            }
            else if($_SESSION["ln_usertype"] == "collaborator")
            {
                echo "<header id=\"header\">

        <!-- Logo -->
        <div class=\"logo\">
              <strong><a href='javascript:void(0)'>Hello, $user_name</a></strong>
        </div>

        <!-- Nav -->
        <nav id=\"nav\">
            <ul id=\"nav_ul\">
                <li class=\"current\"><a href=\"../View/index.php#scrollToHome\">Home</a></li>
                <li><a href=\"../View / index.php#scrollToAl\">Album</a></li>
            <li><a href = \"../View/index.php#scrollToB\" > Inquiries</a ></li >
                <li><a href='../View/yourPhotographs.php'>YourPhotographs</a></li>
                <li><a href='../View/myAlbums.php'>Administrative Functions</a></li>
            </ul>
        </nav>
    </header>";
            }
            else if($_SESSION["ln_usertype"] == "customer")
            {
                    $id=$_SESSION["ln_userId"];
                echo "<header id=\"header\" >

        <!-- Logo -->
        <div class=\"logo\">
                <strong><a href='javascript:void(0)'>Hello, $user_name</a></strong>
        </div>

        <!-- Nav -->
        <nav id=\"nav\">
            <ul id=\"nav_ul\">
                <li class=\"current\"><a href=\"../View/index.php#scrollToHome\">Home</a></li>
                <li><a href=\"../View/index.php#scrollToAl\">Album</a></li>
            <li><a href = \"../View/index.php#scrollToB\" > Inquiries</a ></li >
                <li><a href='../View/yourPhotographs.php?id=$id'>YourPhotographs</a></li>
            </ul>
        </nav>
    </header>";
            }
        }else
        {
            echo "<header id=\"header\" >
        <!-- Logo -->
        <div class=\"logo\" style='display: inline'>
            <strong><a href='javascript:void(0)'  style='display: inline' onclick='Login()'>Login</a>/<a href='javascript:void(0)' onclick='Reg()' style='display: inline'>Register</a></strong>
        </div>

        <!-- Nav -->
        <nav id=\"nav\">
            <ul id=\"nav_ul\">
                <li class=\"current\"><a href=\"../View/index.php#scrollToHome\">Home</a></li>
                <li><a href=\"../View/index.php#scrollToAl\">Album</a></li>
        <li><a href = \"../View/index.php#scrollToB\" > Inquiries</a ></li >
                <li><a href='../View/yourPhotographs.php'>YourPhotographs</a></li>
            </ul>
        </nav>

    </header>";
        }
    }
    function footer()
    {
        echo "<footer id=\"footer\">
        <p class=\"copyright\">&copy; Final Project By Amin Meslioui. All rights reserved.</p>
    </footer>" ;
    }


