<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
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
        <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon">
        <?php include ("./assets/virtual/mainBootstrap.inc"); ?>
        
        <!-- FLEXSLIDER IMPORTS -->
        <link rel="stylesheet" href="flexslider.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="jquery.flexslider.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(window).load(function() {
                $('.flexslider').flexslider();
            });
        </script>
        <!-- END FLEXSLIDER IMPORTS -->
    </head>
    <body>
        <!-- NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">On Point Performance Center</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a><span class="sr-only">(current)</span>Home</a></li>
                        <li><a href="./about/">About Us</a></li>
                        <li><a href="./apply/">Apply</a></li>
                        <li><a href="./events/">Events</a></li>
                        <li><a href="./merchandise/">Merchandise</a></li>
                        <li><a href="./contact/">Contact Us</a></li>
                    </ul>    
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if (isset($_SESSION['member_username'])){
                                echo '<li><a href="./members">' . $_SESSION['member_username'] . '</a></li>';
                                echo '<li><a href="./login/logout.php">Logout</a></li>';
                            }
                            if (isset($_SESSION['admin_username'])){
                                echo '<li><a href="./admin">' . $_SESSION['admin_username'] . '</a></li>';
                                echo '<li><a href="./login/logout.php">Logout</a></li>';                            
                            }
                            elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                echo '<li><a href="./login">Log In</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
        
        <!-- FLEXSLIDER -->
        <div class="container-fluid">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <img src="./assets//images/slide1.jpg" />
                        <div class="flex-caption">
                            <h1>Dual Purpose Gym</h1>
                            <h4>We have our facility split into two sides, one for strength training and the other tactical training</h4>
                        </div>
                    </li>
                    <li>
                        <img src="./assets/images/slide2.jpg" />
                        <div class="flex-caption">
                            <h1>Strength Training</h1>
                            <h4>Our strength training section has all the equipment you needed to get stronger</h4>
                        </div>
                    </li>
                    <li>
                        <img src="./assets/images/slide3.jpg" />
                        <div class="flex-caption">
                            <h1>Tactical Training</h1>
                            <h4>Our tactical section is set up for practicing military and police routines</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END FLEXSLIDER -->
        
        <!-- ANNOUNCEMENTS -->
        <div class="container-fluid">
            <?php include 'announcements/announcements.php';?>
        </div>
        <!-- END ANNOUNCEMENTS -->
        
        <!--
        <div class="panel panel-default" style="margin-bottom: 0px; position: absolute;">
            <div class="panel-body">
                
            </div>
        <div class="panel-footer"></div>
        </div>-->
        
        <!-- FOOTER -->
        <div class="well">
            <?php include ("./assets/virtual/footer.inc"); ?>
        </div>
        <!-- END FOOTER -->
        
        <!--
        <div class="panel panel-default" style="margin-bottom: 0px; padding-top: 2px;">
            <div class="panel-footer">
                
            </div>
        </div>-->
    </body>
</html>
