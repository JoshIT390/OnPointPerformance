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
        <!-- New Slideshow CSS -->
		<link rel="stylesheet" href="slideshow.css" type="text/css">
		<!-- End New Slideshow CSS -->
        <!-- FLEXSLIDER IMPORTS 
        <link rel="stylesheet" href="flexslider.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="jquery.flexslider.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(window).load(function() {
                $('.flexslider').flexslider();
            });
        </script>
         END FLEXSLIDER IMPORTS -->
    </head>
    <body>
        <div class="wrap">
            <!-- NAVBAR -->
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="./"> <img src="./assets/images/Logo.png" style="width:220px; height:50px;float: left;"> </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#"><span class="sr-only">(current)</span>Home</a></li>
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
                    <a> <img src="./assets/images/red slash.png" style="width:100%; height:15px;float: left;"> </a>               
                </div>
            </nav>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <!-- END NAVBAR -->
            
            <div class="container"><?php include 'banner.php';?> </div>
			
            <!-- NEW SLIDESHOW CODE -->
            <div class="container">
                <div id="captioned-gallery" >
                    <figure class="slider">
                        <figure>
                            <img src="./assets/images/slide1.jpg" style="height:auto;" />
                            <figcaption>
                                <h1>On Point Truths</h1>
                                <h4>Human effort is more important than hardware.</h4>
                            </figcaption>
                        </figure>
                        <figure>
                            <img src="./assets/images/slide2.jpg" style="height:auto;"/>
                            <figcaption>
                                <h1>Quality over Quantity</h1>
                                <h4>Quality of training is more important than quantity.</h4>
                            </figcaption>
                        </figure>
                        <figure>
                            <img src="./assets/images/slide3.jpg" style="height:auto;"/>
                            <figcaption>
                                <h1>Selection</h1>
                                <h4>Selection for On Point is a never ending process.</h4>
                            </figcaption>
                        </figure>
                        <figure>
                            <img src="./assets/images/slide1.jpg" style="height:auto;" />
                            <figcaption>
                                <h1>On Point Truths</h1>
                                <h4>Human effort is more important than hardware.</h4>
                            </figcaption>
                        </figure>
                    </figure>
                </div>
            </div>
            </br>
            </br>
            <!-- END NEW SLIDESHOW CODE -->
            <!-- ANNOUNCEMENTS 
            <div class="container" style="width: auto;">
                <div class="row-fluid" style="margin-bottom: 2em;">
                    <div class="col-lg-3" style="text-align: center;">
                        <img src="./assets/images/ph_300x300.gif" alt="placeholder">
                    </div>
                    <div class="col-lg-9"style="text-align: center;">
                        <div class="jumbotron" style="height: 300px;">
                            <h1>Announcement 1</h1>
                            <p>Announcement text will go here.</p>
                        </div>
                    </div>
                </div>

                <div class="row-fluid" style="margin-bottom: 2em;">
                    <div class="col-lg-3"style="text-align: center;">
                        <img src="./assets/images/ph_300x300.gif" alt="placeholder">
                    </div>
                    <div class="col-lg-9"style="text-align: center;">
                        <div class="jumbotron" style="height: 300px;">
                            <h1>Announcement 2</h1>
                            <p>Announcement text will go here.</p>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="col-lg-3"style="text-align: center;">
                        <img src="./assets/images/ph_300x300.gif" alt="placeholder">
                    </div>
                    <div class="col-lg-9"style="text-align: center;">
                        <div class="jumbotron" style="height: 300px;">
                            <h1>Announcement 3</h1>
                            <p>Announcement text will go here.</p>
                        </div>
                    </div>
                </div>
            </div>
                    -->
					
			
            <div class="container">
                <?php include 'announcements.php';?>
            </div>
        </div>
        <!-- END ANNOUNCEMENTS -->
        
        <!--
        <div class="panel panel-default" style="margin-bottom: 0px; position: absolute;">
            <div class="panel-body">
                
            </div>
        <div class="panel-footer"></div>
        </div>-->
        
        <!-- FOOTER -->
        <?php include ("./assets/virtual/footer_home.inc"); ?>

    </body>
</html>
