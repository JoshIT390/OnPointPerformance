<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
    
    // Redirects to proper portal if already logged in
    if(isset($_SESSION["member_username"])) {
        header("Location: ../members/");
        exit();
    }
    elseif(isset($_SESSION["admin_username"])) {
        header("Location: ../admin/");
        exit();
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>On Point Performance Center</title>
        <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
         <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <div class="wrap">
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="../"> <img src="../assets/images/Logo.png" style="width:220px; height:50px;float: left;"> </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="../">Home</a></li>
                            <li><a href="../about/">About Us</a></li>
                            <li><a href="../apply/">Apply</a></li>
                            <li><a href="../events/">Events</a></li>
                            <li><a href="../merchandise/">Merchandise</a></li>
                            <li><a href="../contact/">Contact Us</a></li>
                        </ul>    
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if (isset($_SESSION['member_username'])){
                                    echo
                                    '<li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"' . $_SESSION['member_username'] . ' <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="../members">Dashboard</a></li>
                                            <li class="divider"></li>
                                            <li><a href="./logout.php">Logout</a></li>
                                        </ul>
                                    </li>';
                                    /*echo '<li><a href="../members">My Account</a></li>';
                                    echo '<li><a href="./logout.php">Logout</a></li>';*/
                                }
                                if (isset($_SESSION['admin_username'])){
                                    echo
                                    '<li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $_SESSION['admin_username'] . ' <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="../admin">Admin Portal</a></li>
                                            <li class="divider"></li>
                                            <li><a href="./logout.php">Logout</a></li>
                                        </ul>
                                    </li>';                                /*echo '<li><a href="../admin">My Account</a></li>';
                                    echo '<li><a href="./logout.php">Logout</a></li>';*/                            
                                }
                                else {
                                    echo '<li><a href="../login">Log In</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                    <a> <img src="../assets/images/red slash.png" style="width:100%; height:15px;float: left;"> </a>
                </div>
            </nav>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
            <div class="container">
                    <?php
                        include 'password_reset.php';

                        if (isset($_SESSION['member_username']) || isset($_SESSION['admin_username'])) {
                            // Reload page so that browser reads header injection up top to redirect to proper portal
                            /*echo '<body onload="setInterval(function() {window.location.reload();}, 2000);">';*/

                            if (isset($_SESSION['member_username'])) {
                                echo '<body onload="window.location.href = \'../members/\';">';
                            }
                            elseif (isset($_SESSION['admin_username'])) {
                                echo '<body onload="window.location.href = \'../admin/\';">';
                            }
                        }
                    ?>
            </div>
        </div>
        <?php include ("../assets/virtual/footer.inc"); ?>
    </body>
</html>
