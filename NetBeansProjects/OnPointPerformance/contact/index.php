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
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <li class="active"><a><span class="sr-only">(current)</span>Contact Us</a></li>
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
                <div class="row-fluid">
                    <h1 style="color:#ffffff; font-weight: bold">CONTACT US</h1>
                    <hr style="border: 0; border-bottom: 1px #ffffff; background: #999;" />
                </div>
                <div class="row-fluid">  
                    <div class="span6">


                        <?php
                            include 'form_submission.php';

                            if (!isset($_POST["submit"]) && !isset($_POST["g-recaptcha-response"]) && !isset($_POST["name"]) && !isset($_POST["email"]) && !isset($_POST["message"])) {
                                displayForm();
                            }
                            if (isset($_POST["submit"]) && !isset($_POST["g-recaptcha-response"]) && (!isset($_POST["name"]) && !isset($_POST["email"]) && !isset($_POST["message"]))) {
                                echo "Please fill out all fields";
                                displayForm();
                            }
                            elseif (isset($_POST["submit"]) && isset($_POST["g-recaptcha-response"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
                                if (isValid($_POST["g-recaptcha-response"])) {
                                    if (submitEmail($_POST["name"], $_POST["email"], $_POST["message"])) {
                                        echo '<div class="alert alert-dismissible alert-success">
                                                <button type="button" class="close" data-dismiss="alert">&close;</button>
                                                Message sent successfully
                                            </div>';
                                        displayForm();
                                    }
                                    else {
                                        echo '<div class="alert alert-dismissible alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">&close;</button>                                
                                                There has been a problem with submission. Please try again.
                                            </div>';
                                        displayForm();
                                    }
                                }
                                else {
                                        echo '<div class="alert alert-dismissible alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">&close;</button>      
                                                There has been a problem with our verification process. Please try again.
                                            </div>';
                                    displayForm();
                                }
                            }
                        ?>
                    </div>
                    <div class="span6">
                        <div class="pull-right">                            
                            <div>
                                <h3 style="font-weight: bold; color:#ffffff">CONNECT WITH US</h3>
                                <hr style="height: 1px; background-color:#ffffff; color:#ffffff" />
                                <div style="height: 60px">
                                    <a href="https://www.facebook.com/On-POINT-Performance-Center-773104732833906/" target="_blank">
                                        <i class="fa fa-facebook-official fa-3x"></i>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h3 style="font-weight: bold; color:#ffffff">OUR LOCATION</h3>
                                <hr style="height: 1px; background-color:#ffffff; color:#ffffff" />
                                <div>
                                    <b>On Point Performance Center</b><br />
                                    567-B North Cameron St<br />
                                    Winchester, VA 22601
                                </div><br />
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d919.3066800457663!2d-78.16116457542195!3d39.19249507007405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b5ee35e994fc51%3A0x3e77c2192738fe80!2s567+N+Cameron+St%2C+Winchester%2C+VA+22601!5e0!3m2!1sen!2sus!4v1457649163764" width="380" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include ("../assets/virtual/footer.inc"); ?>
    </body>
</html>