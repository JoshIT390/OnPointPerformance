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
        <title>Merchandise</title>
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
                        <li><a href="../about/">About Us</a></li>
                        <li><a href="../apply/">Apply</a></li>
                        <li><a href="../events/">Events</a></li>
                        <li class="active"><a><span class="sr-only">(current)</span>Merchandise</a></li>
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
  <h1>Jumbotron</h1>
  <p>Merchandise Item 1</p>
  <p><a class="btn btn-primary btn-lg">Learn more</a></p>
</div>
        
           <div class="jumbotron">
  <h1>Jumbotron</h1>
  <p>Merchandise Item 2</p>
  <p><a class="btn btn-primary btn-lg">Learn more</a></p>
</div>
        
        
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
                
            </div>
        </div>
    </body>
</html>