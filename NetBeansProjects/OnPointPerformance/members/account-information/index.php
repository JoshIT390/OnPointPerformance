<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
    
    // Redirects to login page if haven't logged in or trying to access page as admin
    if (isset($_SESSION['admin_username'])){
        unset($_SESSION['admin_username']);
    }
    elseif (!isset($_SESSION['member_username'])) {
        header("Location: ../../login");
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
        <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon">
        <link href="../../assets/bootstrapMain/css/bootstrap.css" rel="stylesheet" type="text/css" >
        <script href="../../assets/bootstrapMain/js/bootstrap.js" type="text/javascript" ></script>
        <script href="../../assets/bootstrapMain/js/bootstrap.min.js" type="text/javascript" ></script>
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
                       <a href="../../"> <img src="../../assets/images/Logo.png" style="width:220px; height:50px;float: left;"> </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="../../">Home</a></li>
                            <li><a href="../../about/">About Us</a></li>
                            <li><a href="../../apply/">Apply</a></li>
                            <li><a href="../../events/">Events</a></li>
                            <li><a href="../../merchandise/">Merchandise</a></li>
                            <li><a href="../../contact/">Contact Us</a></li>
                        </ul>    
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if (isset($_SESSION['member_username'])){
                                    echo '<li><a href="../../members">' . $_SESSION['member_username'] . '</a></li>';
                                    echo '<li><a href="../../login/logout.php">Logout</a></li>';
                                }
                                if (isset($_SESSION['admin_username'])){
                                    echo '<li><a href="../../admin">' . $_SESSION['admin_username'] . '</a></li>';
                                    echo '<li><a href="../../login/logout.php">Logout</a></li>';                            
                                }
                                elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                    echo '<li><a href="../../login">Log In</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                                    <a> <img src="../../assets/images/red slash.png" style="width:100%; height:15px;float: left;"> </a>
                </div>
            </nav>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
            <div class="container">
                <?php
                    if (isset($_SESSION['member_username'])){
                        include './account_information.php';

                        echo 
                            '<div class="row-fluid">
                                <ul class="breadcrumb">
                                    <li><a href="../">Your Account</a></li>
                                    <li class="active">View/change Account Information</li>
                                </ul>
                            </div>';

                        if (!isset($_POST["submit"])) {
                            displayAccountInformation($_SESSION["member_username"], $us_state_abbrevs, "");
                        }
                        else {
                            if (verifyEmail(trim($_POST["email"]))) {
                                if (submitAccountInformation($_SESSION["member_username"], htmlentities(trim($_POST["firstName"])), htmlentities(trim($_POST["lastName"])), htmlentities(trim($_POST["address"])), htmlentities(trim($_POST["city"])), htmlentities(trim($_POST["state"])), trim($_POST["zip"]), preg_replace("/[^0-9]/", "", trim($_POST["phone"])), htmlentities(trim($_POST["notes"])), htmlentities(trim($_POST["email"])))) {
                                    $_SESSION['member_username'] = $_POST["email"];
                                    displayAccountInformation($_SESSION["member_username"], $us_state_abbrevs, "success");
                                }
                                else {
                                    displayAccountInformation($_SESSION["member_username"], $us_state_abbrevs, "fail");
                                }
                            }
                            else {
                                displayAccountInformation($_SESSION["member_username"], $us_state_abbrevs, "fail_email");
                            }
                        }
                    }
                ?>
            </div>
        </div>
        
        <?php include ("../../assets/virtual/footer_in.inc"); ?>
    </body>
</html>

