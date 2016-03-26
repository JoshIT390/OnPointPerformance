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
							/*$servername = "mysql.dnguyen94.com";
							$username = "ad_victorium";
							$password = "MT8AlJAM";
							$database = "onpoint_performance_center_lower";
                                                        $memberid = $_POST["random"];
                                                        $fname = $_POST["fname"];
                                                        $lname = $_POST["lname"];
                                                        $duedate = $_POST["duedate"];
                                                        $status = $_POST["status"];
                                                        $address = $_POST["address"];
                                                        $city = $_POST["city"];
                                                        $state = $_POST["state"];
                                                        $zip = $_POST["zip"];
                                                        $phone = $_POST["phone"];
                                                        $email = $_POST["email"];
                                                        $notes = $_POST["notes"];
                                                        $adminnotes = $_POST["adminnotes"];
                                                        if ($status == 'active'){
                                                            $status ="1";
                                                        }
                                                        if ($status == 'inactive'){
                                                            $status = "0";
                                                        }
							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
                                                        }
                                                        $query = "UPDATE MEMBER_ACCOUNT SET FIRSTNAME='$fname', LASTNAME='$lname', DUEDATE='$duedate', ACTIVESTATUS='$status', ADDRESS='$address', CITY='$city', STATE='$state', ZIP='$zip', PHONE='$phone', MEMBER_EMAIL='$email', NOTES='$notes', ADMIN_NOTES='$adminnotes' WHERE MEMBER_ID='$memberid';";
                                                        $result = mysqli_query($conn, $query);
                                                        if (!$result){
                                                            die('Invalid query: ' . mysql_error());
                                                        }
                                                        else{
                                                            echo "Update Successful</br>";
                                                            echo "If you'd like to go back to viewing the member please click here: <form action='view.php' method='post'><input type='text' name='random' value='$memberid' hidden><input type='submit' value='View'> </form>";
                                                        }*/
							?> 
                                                    
                                                        <?php
                                                            define("DB_HOST_NAME", "mysql.dnguyen94.com");
                                                            define("DB_USER_NAME", "ad_victorium");
                                                            define("DB_PASSWORD", "MT8AlJAM");
                                                            define("DB_NAME", "onpoint_performance_center_lower");
                                                            define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
                                                            define("USER_EMERGENCY_CONTACT_TABLE", "MEMBER_EMERGENCY_CONTACTS");
                                                            
                                                            if (submitAccountInformation($_POST["fname"], $_POST["lname"], $_POST["duedate"], $_POST["status"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["email"], $_POST["notes"], $_POST["adminnotes"], $_POST["random"])) {
                                                                if (submitEmergencyContactInformation($_POST["emergency_fname"], $_POST["emergency_lname"], $_POST["emergency_phone"], $_POST["emergency_relationship"], $_POST["random"])) {
                                                                    echo "Update Successful</br>";
                                                                    echo "If you'd like to go back to viewing the member please click here: <form action='view.php' method='post'><input type='text' name='random' value='" . $_POST["random"] . "' hidden><input type='submit' value='View'> </form>";
                                                                }
                                                                else {
                                                                    echo "Account information saved, but a problem has occurred with saving emergency contact information.";
                                                                }
                                                            }
                                                            else {
                                                                echo "A problem has occurred with saving account information. Emergency contact information was not saved";
                                                            }
                                                            
                                                            function submitAccountInformation($submittedFirstName, $submittedLastName, $submittedDueDate, $submittedStatus, $submittedAddress, $submittedCity, $submittedState, $submittedZip, $submittedPhone, $submittedEmail, $submittedNotes, $submittedAdminNotes, $memberID) {
                                                                $status;
                                                                
                                                                if ($submittedStatus == 'active'){
                                                                    $status ="1";
                                                                }
                                                                if ($submittedStatus == 'inactive'){
                                                                    $status = "0";
                                                                }
                                                                
                                                                try {
                                                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                                                    // Exceptions fire when occur
                                                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                    $accountInformationUpdate = $connection->prepare('
                                                                        UPDATE ' . USER_CREDENTIAL_TABLE . ' 
                                                                        SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, DUEDATE = :submittedDueDate, ACTIVESTATUS = :submittedActiveStatus, ADDRESS = :submittedAddress, City = :submittedCity, State = :submittedState, ZIP = :submittedZip, PHONE = :submittedPhone, MEMBER_EMAIL = :submittedEmail, NOTES = :submittedNotes, ADMIN_NOTES = :submittedAdminNotes 
                                                                        WHERE MEMBER_ID = :memberID');
                                                                    
                                                                    $accountInformationUpdate->execute(array(
                                                                        ':submittedFirstName' => $submittedFirstName,
                                                                        ':submittedLastName' => $submittedLastName,
                                                                        ':submittedDueDate' => $submittedDueDate,
                                                                        ':submittedActiveStatus' => $status,
                                                                        ':submittedAddress' => $submittedAddress,
                                                                        ':submittedCity' => $submittedCity,
                                                                        ':submittedState' => $submittedState,
                                                                        ':submittedZip' => $submittedZip,
                                                                        ':submittedPhone' => $submittedPhone,
                                                                        ':submittedEmail' => $submittedEmail,
                                                                        ':submittedNotes' => $submittedNotes,
                                                                        ':submittedAdminNotes' => $submittedAdminNotes,
                                                                        ':memberID' => $memberID
                                                                    ));
                                                                }

                                                                // Script halts and throws error if exception is caught
                                                                catch(PDOException $e) {
                                                                    echo "
                                                                    <div>
                                                                        Error1: " . $e->getMessage() . 
                                                                    "</div>";

                                                                    return FALSE;
                                                                }
                                                                
                                                                return TRUE;
                                                            }
                                                            
                                                            function submitEmergencyContactInformation($submittedFirstName, $submittedLastName, $submittedPhone, $submittedRelationship, $memberID) {
                                                                try {
                                                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                                                    // Exceptions fire when occur
                                                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                    $accountInformationUpdate = $connection->prepare('
                                                                        UPDATE ' . USER_EMERGENCY_CONTACT_TABLE . ' 
                                                                        SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, PHONE = :submittedPhone, RELATIONSHIP = :submittedRelationship 
                                                                        WHERE MEMBER_ID = :memberID'
                                                                    );

                                                                    $accountInformationUpdate->execute(array(
                                                                        ':submittedFirstName' => $submittedFirstName,
                                                                        ':submittedLastName' => $submittedLastName,
                                                                        ':submittedPhone' => $submittedPhone,
                                                                        ':submittedRelationship' => $submittedRelationship,
                                                                        ':memberID' => $memberID
                                                                    ));
                                                                }

                                                                // Script halts and throws error if exception is caught
                                                                catch(PDOException $e) {
                                                                    echo "
                                                                    <div>
                                                                        Error2: " . $e->getMessage() . 
                                                                    "</div>";

                                                                    return FALSE;
                                                                }
                                                                
                                                                return TRUE;
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