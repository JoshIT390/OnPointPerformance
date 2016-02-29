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
        <title>About Us</title>
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../">On Point Performance Center</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="../">Home</a></li>
                        <li><a href="../announcements/">Announcements</a></li>
                        <li class="active"><a><span class="sr-only">(current)</span>About Us</a></li>
                        <li><a href="../apply/">Apply</a></li>
                        <li><a href="../events/">Events</a></li>
                        <li><a href="../merchandise/">Merchandise</a></li>
                        <li><a href="../contact/">Contact Us</a></li>
                    </ul>    
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if (isset($_SESSION['member_username'])){
                                echo '<li><a href="../members">' . $_SESSION['member_username'] . '</a></li>';
                                echo '<li><a href="../login/logout.php">Logout</a></li>';
                            }
                            if (isset($_SESSION['admin_username'])){
                                echo '<li><a href="../admin">' . $_SESSION['admin_username'] . '</a></li>';
                                echo '<li><a href="../login/logout.php">Logout</a></li>';                            
                            }
                            elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                echo '<li><a href="../login">Log In</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="jumbotron">
            <h1>On Point Performance Center</h1>
            <p>Description of the business goes here.</p>
            <p><a class="btn btn-primary btn-lg">Learn more</a></p>
            <div>
                
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <img src="../assets/images/ph_300x300.gif" alt="placeholder">
                </div>
                <div class="col-lg-9">
                    <div class="jumbotron">
                        <h1>Rusty Pugh</h1>
                        <p>Rusty served 14 years in the U.S. Army's elite Special Forces, known as the Green Berets. During this time Rusty operated in several high threat missions overseas. These included tours in Central America and Afghanistan where he was awarded the Bronze Star Medal and the Combat Infantry Badge. Rusty served the majority of his military  career on an Operational Detachment Alpha, otherwise known as a Special Forces A Team. Rusty was a graduate of the Special Forces Advanced Urban Combat Course as well as the Special Operations Combat Diver Qualification Course, one of the most physically demanding military courses in the world. Rusty has also competed in Tactical 3 Gun and International Practical Shooting Confederation at a National level. Rusty holds Elite / Pro totals in 2 weight classes as a powerlifter  and has squatted 800 pounds and bench pressed 650 pounds in sanctioned powerlifting meets. Rusty has coached several powerlifters to achieve Elite/Pro totals. He has a personal training certificate from the Cooper Institute in Dallas Texas.</p>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-lg-9">
                    <div class="jumbotron">
                        <h1>John Sheetz</h1>
                        <p>John served as a paid firefighter for the U.S. Forest Service, he has a back ground in competitive powerlifting and martial arts. John has a Masters of Sports Science degree from the United States Sports Academy. He is a C.S.C.S and is certified through other organizations such as NSCA and IDEA. John was selected as an intern with the USSA Human Performance Center Laboratory. John served as the Senior Exercise Physiologist for Sports Life in Ga. He was the Fitness Director for Riverside Health Systems in VA. John also developed the initial sports medicine programming for INOVA Health System in Fairfax Va. He has also worked closely with the medical team physician for a NHL hockey team.</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <img src="../assets/images/ph_300x300.gif" alt="placeholder">
                </div>
            </div>    
        </div>
        
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>

