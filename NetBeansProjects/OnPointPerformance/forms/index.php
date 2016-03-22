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
        <title>Forms</title>
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
        
        
    </head>
    <body>
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
        
        
        
        <div class="container">
            <div class="jumbotron" style="text-align: center;">
                <h1>Forms</h1>
            </div>
            <?php
							$servername = "mysql.dnguyen94.com";
							$username = "ad_victorium";
							$password = "MT8AlJAM";
							$database = "onpoint_performance_center_lower";
                                                        $memberid = $_POST["random"];

							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
                                                        }
                            $query = "SELECT * FROM FORMS;";
							$result = mysqli_query($conn, $query);
                                                        while($row = $result->fetch_assoc()) {
                                                            echo "<div class='panel panel-danger'>
  <div class='panel-heading'>
    <h3 class='panel-title'>" . $row["NAME"] . "</h3>
  </div>
  <div class='panel-body'> <a href='" . $row["PDF"] . "'>" . $row["PDF"] . "</a></div>
</div>";                                                      }
                                                        $result->close();
			?>
			
        </div>
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>