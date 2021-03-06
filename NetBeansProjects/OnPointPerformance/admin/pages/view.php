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
                        <h1 class="page-header">Member Management</h1>
                            <p>                                                   
                                <?php
                                    include "../../databaseInfo.php";

                                    try {
                                        $memberStatus;
                                        
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $accountInformationQuery = $connection->query('
                                            SELECT M.MEMBER_ID, M.MEMBER_EMAIL, M.FIRSTNAME, M.LASTNAME, M.ADDRESS, M.CITY, M.STATE, M.ZIP, M.PHONE, M.NOTES, M.ADMIN_NOTES, M.PASSWORD, M.DUEDATE, M.ACTIVESTATUS, ME.FIRSTNAME, ME.LASTNAME, ME.PHONE, ME.RELATIONSHIP, ME.EMERGENCY_CONTACT_ID 
                                            FROM ' . USER_CREDENTIAL_TABLE . ' M INNER JOIN ' . EMERGENCY_CONTACTS_TABLE . ' ME ON ME.MEMBER_ID = M.MEMBER_ID
                                            WHERE M.MEMBER_ID = '. $connection->quote($_POST["buttonMemberID"])
                                        );

                                        $accountInformation = $accountInformationQuery->fetch(PDO::FETCH_NUM);
                                        
                                        if ($accountInformation[13] == 1) {
                                            $memberStatus = "Active";
                                        }
                                        elseif ($accountInformation[13] == 0) {
                                            $memberStatus = "Inactive";
                                        }
                                        
                                        echo 
                                            "<h3> Viewing " . $accountInformation[2] . " " . $accountInformation[3] . "</h3></br>
                                            <table style='width:75%'>
                                                <tr>
                                                    <td>First Name: " . $accountInformation[2] . "</td>
                                                    <td>Last Name: " . $accountInformation[3] . "</td>
                                                    <td>Dues Paid Until: " . $accountInformation[12] . "</td>
                                                    <td>Member Status: " . $memberStatus . "</td>
                                                <tr>
                                                    <td> </br>Street Address: " . $accountInformation[4] . "</td>
                                                    <td></br>City: " . $accountInformation[5] . "</td>
                                                    <td></br>State: " . $accountInformation[6] . "</td>
                                                    <td></br>Zip Code: " . $accountInformation[7] . "</td>
                                                </tr>
                                                <tr>
                                                    <td> </br>Phone Number: " . preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $accountInformation[8]) . "</td>
                                                    <td></br>Email Address: " . $accountInformation[1] . "</td>
                                                </tr>
                                            </table>
                                            </br>
                                            <div style='width:50%'>
                                                Member Viewable Notes: </br>" . $accountInformation[9] . 
                                            "</div>
                                            </br>
                                            <div style='width:50%'>
                                                Administrator Notes: </br>" . $accountInformation[10] . 
                                            "</div>
                                                                                                                </br>
                                            <h4>Emergency Contact</h4>
                                            <table style='width:50%'>
                                                <tr>
                                                    <td>First Name: " . $accountInformation[14] . "</td>
                                                    <td>Last Name: " . $accountInformation[15] . "</td>
                                                    <td>Phone Number: " . $accountInformation[16] . "</td>
                                                    <td>Relationship: " . $accountInformation[17] . "</td>
                                                </tr>
                                            </table>
                                            </br>
                                            <div>
                                                <form action='edit.php' method='post'>
                                                    <input type='text' name='buttonMemberID' value='" . $accountInformation[0] . "' hidden />
                                                    <input type='submit' value='Edit' class='btn btn-default' />
                                                </form>
                                            </div>";
                                    }
                                    // Script halts and throws error if exception is caught
                                    catch(PDOException $e) {
                                        echo "
                                        <div>
                                            Error: " . $e->getMessage() . 
                                        "</div>";
                                    }
                                ?>
                            </p>
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
