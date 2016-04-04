<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
    
    // Redirects to login page if haven't logged in or trying to access page as admin
    if (isset($_SESSION['member_username'])){
        unset($_SESSION['member_username']);
    }
    elseif (!isset($_SESSION['admin_username'])) {
        header("Location: ../../login");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OPPC Admin Page</title>
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="inline.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">On Point Performance Administration Page</a>
            </div>
            
             <!-- /.navbar-header -->
             
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="./profile/"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="../../"><i class="fa fa-home fa-fw"></i> Public Website</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            
                        </li>
                        <li>
                            <a href="./index.php"><i class="fa fa-users fa-fw"></i> Member Management</a>
                        </li>
                        <li>
                            <a href="./adminslist.php"><i class="fa fa-users fa-fw"></i> Admin Management</a>
                        </li>
                        <li>
                            <a href="./calendar.php"><i class="fa fa-calendar fa-fw"></i> Manage Calendar</a>
                        </li>
                        <li>
                            <a href="./email.php"><i class="fa fa-envelope-o fa-fw"></i> Email Members</a>
                        </li>
						<li>
                            <a href="./applications.php"><i class="fa fa-edit fa-fw"></i> View Applications</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Website Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./bannerm.php">Front Page Banner</a>
                                </li>
                                <li>
                                    <a href="./announcementsm.php">Front Page Announcements</a>
                                </li>
								<li>
                                    <a href="./formsm.php">Forms</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">View Application</h1>
			<?php 
                            include "../../databaseInfo.php";
                            
                            $appID = $_POST["appID"];
                            
                            try{
                                $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                // Exceptions fire when occur
                                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                                $query = $connection->prepare('SELECT * FROM ' . APPLICATIONS_TABLE . ' WHERE APP_ID=' . $appID);
                                $query->execute();
                            }
                            catch(PDOException $e) {
                                echo "<div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";
            
                                return FALSE;
                            }
                            $results = $query->fetch();
                            /*
                             * ["APP_ID"]=>[0]
                             * ["FIRSTNAME"]=>[1]
                             * ["LASTNAME"]=>[2]
                             * ["PHONE"]=>[3]
                             * ["EMAIL"]=>[4]
                             * ["AGE"]=>[5]
                             * ["GENDER"]=>[6]
                             * ["MILITARY_BG"]=>[7]
                             * ["MILITARY_BG_COMMENTS"]=>[8]
                             * ["LAW_EN_BG"]=>[9]
                             * ["LAW_EN_BG_COMMENTS"]=>[10]
                             * ["COMP_ATHLETE_BG"]=>[11]
                             * ["COMP_ATHLETE_BG_COMMENTS"]=>[12]
                             * ["CURRENTLY_TRAIN"]=>[13]
                             * ["DAYS_PER_WEEK_TRAINING"]=>[14]
                             * ["TRAINING_TIME"]=>[15]
                             * ["CERTIFICATION"]=>[16]
                             * ["CERTIFICATION_COMMENTS"]=>[17]
                             * ["ADDITIONAL_COMMENTS"]=>[18]
                            */
                            if ($results[7] == "1"){
                                $military = $results[8];
                            }else {
                                $military = "None";
                            }
                            if ($results[9] == "1"){
                                $law = $results[10];
                            }else{
                                $law = "None";
                            }
                            if ($results[11] == "1"){
                                $strength = $results[12];
                            }else{
                                $strength = "None";
                            }
                            if ($results[16] == "1"){
                                $health = $results[17];
                            }else{
                                $health = "None";
                            }

                            echo "<table>"
                                    . "<tr><td><strong>First Name</strong></td><td>" . $results[1] . "</td></tr>"
                                    . "<tr><td><strong>Last Name</strong></td><td>" . $results[2] . "</td></tr>"
                                    . "<tr><td><strong>Age</strong></td><td>" . $results[5] . "</td></tr>"
                                    . "<tr><td><strong>Gender</strong></td><td>" . $results[6] . "</td></tr>"
                                    . "<tr><td><strong>Phone</strong></td><td>" . $results[3] . "</td></tr>"
                                    . "<tr><td><strong>E-mail</strong></td><td>" . $results[4] . "</td></tr>"
                                    . "<tr><td><strong>Military</strong></td><td>" . $military . "</td></tr>"
                                    . "<tr><td><strong>Law Enforcement</strong></td><td>" . $law . "</td></tr>"
                                    . "<tr><td><strong>Competitive</strong></td><td>" . $strength . "</td></tr>"
                                    . "<tr><td><strong>Health Certification</strong></td><td>" . $health . "</td></tr>"
                                    . "<tr><td><strong>Current Gym</strong></td><td>" . $results[13] . "</td></tr>"
                                    . "<tr><td><strong>Training Days (per week)</strong></td><td>" . $results[14] . "</td></tr>"
                                    . "<tr><td><strong>Training Time</strong></td><td>" . $results[15] . "</td></tr>"
                                    . "<tr><td><strong>Additional Information</strong></td><td>" . $results[18] . "</td></tr>"
                                    . "<tr><td><strong>Management</strong></td><td>"
                                        . "<form action='deleteApplication.php' method='post'>"
                                            . "<input type='hidden' name='appID' value='" . $appID . "'>"
                                            . "<input class='btn btn-warning' type='submit' value='Delete'>"
                                        . "</form>"
                                    . "</td></tr>"
                                . "</table>";
                            
                            
                        ?>
                        <div class="container" style="text-align: center;">
                        <form action="appComment.php" method="post">
                            <div class="row" style="text-align: center;">
                                <label for="adminComments"><h3>Add/Edit Admin Comments:</h3></label>
                            </div>
                            <div class="row">
                                <textarea name="adminComments" rows="5" cols="50"><?php echo $results[19];?></textarea>
                            </div>
                            <div class="row" style="text-align: center;">
                                <input type="hidden" name="appID" value="<?php echo $appID; ?>">
                                <input type="submit" class="btn btn-primary" value="Save Comment">
                            </div>
                        </form>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
