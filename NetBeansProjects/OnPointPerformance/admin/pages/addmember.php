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
                <a class="navbar-brand" href="index.html">On Point Performance Administration Page</a>
            </div>
             <!-- /.navbar-header -->
             
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
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
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Member Management</a>
                        </li>
                        <li>
                            <a href="calendar.php"><i class="fa fa-table fa-fw"></i> Manage Calendar</a>
                        </li>
                        <li>
                            <a href="email.php"><i class="fa fa-edit fa-fw"></i> Email Members</a>
                        </li>
						<li>
                            <a href="applications.php"><i class="fa fa-edit fa-fw"></i> View Applications</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Website Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="bannerm.php">Front Page Banner</a>
                                </li>
                                <li>
                                    <a href="announcementsm.php">Front Page Announcements</a>
                                </li>
								<li>
                                    <a href="formsm.php">Forms</a>
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
						<p><!--
							</*?php
                                                        function hashPassword($password) {
                                                            $cost = 10;
                                                            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                                                            $salt = sprintf("$2a$%02d$", $cost) . $salt;
                                                            return crypt($password, $salt);
                                                        }
							$servername = "mysql.dnguyen94.com";
							$username = "ad_victorium";
							$password = "MT8AlJAM";
							$database = "onpoint_performance_center_lower";
                                                        $fname = $_POST["fname"];
                                                        $lname = $_POST["lname"];
                                                        $duedate = $_POST["duesdate"];
                                                        $status = $_POST["status"];
                                                        $address = $_POST["street"];
                                                        $city = $_POST["city"];
                                                        $state = $_POST["State"];
                                                        $zip = $_POST["zip"];
                                                        $phone = $_POST["phone"];
                                                        $email = $_POST["email"];
                                                        $notes = $_POST["notes"];
                                                        $passwordz = $_POST["password"];
							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
                                                        }
                                                        $hash = hashPassword($passwordz);
                                                        $query = "INSERT INTO MEMBER_ACCOUNT(FIRSTNAME, LASTNAME, DUEDATE, ACTIVESTATUS, ADDRESS, CITY, STATE, ZIP, PHONE, MEMBER_EMAIL, PASSWORD) VALUES ('$fname', '$lname', '$duedate', '1', '$address', '$city', '$state', '$zip', '$phone', '$email', '$hash');";
                                                        $result = mysqli_query($conn, $query);
                                                        if (!$result){
                                                            die('Invalid query: ' . mysql_error());
                                                        }
                                                        else{
                                                            echo "Successfully added member</br>";
                                                        }*/
							?> -->
                                                    
                                                        <?php
                                                            define("DB_HOST_NAME", "mysql.dnguyen94.com");
                                                            define("DB_USER_NAME", "ad_victorium");
                                                            define("DB_PASSWORD", "MT8AlJAM");
                                                            define("DB_NAME", "onpoint_performance_center_lower");
                                                            define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
                                                            define("USER_EMERGENCY_CONTACT_TABLE", "MEMBER_EMERGENCY_CONTACTS");
                                                            
                                                            if (submitAccountInformation($_POST["fname"], $_POST["lname"], $_POST["duesdate"], '1', $_POST["street"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["email"], $_POST["notes"], $_POST["password"])) {
                                                                if (submitEmergencyContactInformation($_POST["emergency_fname"], $_POST["emergency_lname"], $_POST["emergency_phone"], $_POST["emergency_relationship"], $_POST["email"])) {
                                                                    echo "Successfully added member</br>";
                                                                }
                                                                else {
                                                                    echo "Account information saved, but a problem has occurred with saving emergency contact information.";
                                                                }
                                                            }
                                                            else {
                                                                echo "A problem has occurred with saving account information. Emergency contact information was not saved";
                                                            }
                                                            
                                                            function hashPassword($password) {
                                                                $cost = 10;
                                                                $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                                                                $salt = sprintf("$2a$%02d$", $cost) . $salt;
                                                                return crypt($password, $salt);
                                                            }
                                                            
                                                            function getMemberID($email) {
                                                                try {
                                                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                                                    // Exceptions fire when occur
                                                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                    $memberIDQuery = $connection->query('
                                                                        SELECT MEMBER_ID 
                                                                        FROM ' . USER_CREDENTIAL_TABLE . ' 
                                                                        WHERE MEMBER_EMAIL = '. $connection->quote($email)
                                                                    );

                                                                    $memberID = $memberIDQuery->fetch();
                                                                    return $memberID[0];
                                                                }
                                                                // Script halts and throws error if exception is caught
                                                                catch(PDOException $e) {
                                                                    echo "
                                                                    <div>
                                                                        Error3: " . $e->getMessage() . 
                                                                    "</div>";
                                                                    
                                                                    return FALSE;
                                                                }
                                                            }
                                                            
                                                            function submitAccountInformation($submittedFirstName, $submittedLastName, $submittedDueDate, $submittedStatus, $submittedAddress, $submittedCity, $submittedState, $submittedZip, $submittedPhone, $submittedEmail, $submittedAdminNotes, $submittedPassword) {
                                                                try {
                                                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                                                    // Exceptions fire when occur
                                                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                    $accountInformationUpdate = $connection->prepare('
                                                                        INSERT INTO ' . USER_CREDENTIAL_TABLE . '(FIRSTNAME, LASTNAME, DUEDATE, ACTIVESTATUS, ADDRESS, CITY, STATE, ZIP, PHONE, MEMBER_EMAIL, ADMIN_NOTES, PASSWORD) 
                                                                        VALUES (:submittedFirstName, :submittedLastName, :submittedDueDate, :submittedActiveStatus, :submittedAddress, :submittedCity, :submittedState, :submittedZip, :submittedPhone, :submittedEmail, :submittedAdminNotes, :submittedPassword)'
                                                                    );
                                                                    
                                                                    $accountInformationUpdate->execute(array(
                                                                        ':submittedFirstName' => $submittedFirstName,
                                                                        ':submittedLastName' => $submittedLastName,
                                                                        ':submittedDueDate' => $submittedDueDate,
                                                                        ':submittedActiveStatus' => $submittedStatus,
                                                                        ':submittedAddress' => $submittedAddress,
                                                                        ':submittedCity' => $submittedCity,
                                                                        ':submittedState' => $submittedState,
                                                                        ':submittedZip' => $submittedZip,
                                                                        ':submittedPhone' => $submittedPhone,
                                                                        ':submittedEmail' => $submittedEmail,
                                                                        ':submittedAdminNotes' => $submittedAdminNotes,
                                                                        ':submittedPassword' => hashPassword($submittedPassword)
                                                                    ));
                                                                    var_dump($connection->lastInsertId);
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
                                                            
                                                            function submitEmergencyContactInformation($submittedFirstName, $submittedLastName, $submittedPhone, $submittedRelationship, $submittedEmail) {
                                                                try {
                                                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                                                    // Exceptions fire when occur
                                                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                    $accountInformationUpdate = $connection->prepare("
                                                                        INSERT INTO " . USER_EMERGENCY_CONTACT_TABLE . "(FIRSTNAME, LASTNAME, PHONE, RELATIONSHIP, MEMBER_ID)
                                                                        VALUES (:submittedFirstName, :submittedLastName, :submittedPhone, :submittedRelationship, '" . getMemberID($submittedEmail) . "')"
                                                                    );

                                                                    $accountInformationUpdate->execute(array(
                                                                        ':submittedFirstName' => $submittedFirstName,
                                                                        ':submittedLastName' => $submittedLastName,
                                                                        ':submittedPhone' => $submittedPhone,
                                                                        ':submittedRelationship' => $submittedRelationship,
                                                                    ));
                                                                    
                                                                    echo "submitEmergencyContact" . time();
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