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
        <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
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
                            <li class="active"><a href="#"><span class="sr-only">(current)</span>About Us</a></li>
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
                    <a> <img src="../assets/images/red slash.png" style="width:100%; height:15px;float: left;"> </a>
                </div>
            </nav>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            
            <div class="container">
            <div class="jumbotron">
                <h1>On Point Performance Center</h1>
                <p class='linez' style="font-size: 12pt">OPPC is a physical training approach for elite and tactical athletes. It’s not just gym or a workout, it is a mindset and an approach to existence. We exist for the purpose of creating mission-capable athletes who compete on the platform, in the streets and on the battlefield. Participation in this program is limited and by invitation or application only. It is not for the general population and the core focus and mission of OPPC will be vigorously protected. The owners and trainers of this facility have years of Special Forces experience and decades of institutional and experiential knowledge in the field of training athletes to become stronger, faster and more mentally tough than their competition, their adversaries or their enemies.</p>
                </div>
            </div>
            <div class="container">
                        <div class="jumbotron">
						<img src="RustyPugh.jpg" alt="Picture of Rusty Pugh" style="float:left;padding-right:15px;">
                            <h1>Rusty Pugh</h1>
                            <p class='linez' style="font-size: 12pt">Rusty served 14 years in the U.S. Army's elite Special Forces, known as the Green Berets. During this time Rusty operated in several high threat missions overseas. These included tours in Central America and Afghanistan where he was awarded the Bronze Star Medal and the Combat Infantry Badge. Rusty served the majority of his military  career on an Operational Detachment Alpha, otherwise known as a Special Forces A Team. Rusty was a graduate of the Special Forces Advanced Urban Combat Course as well as the Special Operations Combat Diver Qualification Course, one of the most physically demanding military courses in the world. Rusty has also competed in Tactical 3 Gun and International Practical Shooting Confederation at a National level. Rusty holds Elite / Pro totals in 2 weight classes as a powerlifter  and has squatted 800 pounds and bench pressed 650 pounds in sanctioned powerlifting meets. Rusty has coached several powerlifters to achieve Elite/Pro totals. He has a personal training certificate from the Cooper Institute in Dallas Texas.</p>
                        </div> 
                        <div class="jumbotron">
                            <h1>John Sheetz
                            <img src="JohnSheetz.jpg" alt="Picture of John Sheetz"  style="float:right;width:275px;height:350px;padding-left:15px;">
                            </h1>
                            <p class='linez' style="font-size: 12pt">
                                John holds a Master of Sports Science degree and has extensive experience in testing and training of athletes to improve performance. He has worked with conventional and tactical athletes from amateur to professional ranks, and has consulted with municipalities and public companies on fitness for duty programming. John has held certifications from organizations such as National Strength and Conditioning Association, ACE and others. A lifelong athlete, he participated in team sports before finding success in powerlifting and martial arts. He trained and served as both a volunteer city firefighter and a paid firefighter for the U.S. Forest Service. John is also certified as a Personal Protection Specialist by the Executive Protection Institute and holds a Private Security Service registration from the Virginia Department of Criminal Justice Services.</p>
                        </div>
  
            </div>
        </div>
        <?php include ("../assets/virtual/footer.inc"); ?>
    </body>
</html>

