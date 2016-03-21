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
        <title>Contact Us</title>
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>