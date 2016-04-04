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
                        <h1 class="page-header">Manage Calendar Events</h1>             
                        <?php     
                            include "../../databaseInfo.php";
                            $us_state_abbrevs = array("AK","AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","UT","VA","VI","VT","WA","WI","WV","WY");

                            if (!empty($_POST["name"]) && !empty($_POST["date"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["description"]) && !empty($_POST["forms"])) {
                                if (submitEventInformation(trim($_POST["name"]), $_POST["date"], trim($_POST["city"]), $_POST["state"], trim($_POST["zip"]), $_POST["description"], $_POST["forms"])) {
                                    displayForm("success", $us_state_abbrevs, "", "", "", "", "", "", "");
                                }
                                else {
                                    displayForm("fail", $us_state_abbrevs, $_POST["name"], $_POST["date"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["description"], $_POST["forms"]);
                                }
                            }
                            else {
                                displayForm("", $us_state_abbrevs, "", "", "", "", "", "", "");
                            }

                            function createStateAbbrevOptions($us_state_abbrevs, $submittedState) {
                                $stateAbbrevOptions;

                                foreach ($us_state_abbrevs as &$stateAbbrev) {
                                    if ($stateAbbrev == $submittedState) {
                                        $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '" selected>' . $stateAbbrev . '</option>';
                                    }
                                    else {
                                        $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '">' . $stateAbbrev . '</option>';
                                    }
                                }

                                return $stateAbbrevOptions;
                            }

                            function submitEventInformation($submittedName, $submittedDate, $submittedCity, $submittedState, $submittedZip, $submittedDescription, $submittedForms) {                                    
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $eventSubmit = $connection->prepare(
                                            'INSERT INTO ' . CALENDAR_TABLE . ' (NAME, DATE, CITY, STATE, ZIP, DESCRIPTION, FORMS) 
                                            VALUES (:submittedName, :submittedDate, :submittedCity, :submittedState, :submittedZip, :submittedDescription, :submittedForms)');

                                    $eventSubmit->execute(array(
                                        ':submittedName' => $submittedName,
                                        ':submittedDate' => $submittedDate,
                                        ':submittedCity' => $submittedCity,
                                        ':submittedState' => $submittedState,
                                        ':submittedZip' => $submittedZip,
                                        ':submittedDescription' => $submittedDescription,
                                        ':submittedForms' => $submittedForms
                                    ));
                                }

                                // Script halts and throws error if exception is caught
                                catch(PDOException $e) {
                                    echo "
                                    <div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";

                                    return FALSE;
                                }

                                return TRUE;
                            }

                            function displayForm($status, $us_state_abbrevs, $submittedName, $submittedDate, $submittedCity, $submittedState, $submittedZip, $submittedDescription, $submittedForms) {
                                $message;

                                if ($status == "success") {
                                    $message = 
                                        "<div class='alert alert-dismissible alert-success'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            Event successfully submitted.
                                        </div>";
                                }
                                elseif ($status == "fail") {
                                    $message = 
                                        "<div class='alert alert-dismissible alert-danger'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            There was a problem submitting the event. Please try again.
                                        </div>";
                                }

                                echo
                                    "<h3>Add Event</h3>" . 
                                    $message . 
                                    "<form action='addEvent.php' method='post'>
                                        <div>
                                            Name: <input type='text' name='name' value='" . htmlentities($submittedName, ENT_QUOTES) . "' required />
                                            Date: <input type='date' name='date' placeholder='YYYY-MM-DD' value='" . $submittedDate . "' required />
                                        </div><br />
                                        <div>
                                            City: <input type='text' name='city' value='" . htmlentities($submittedCity, ENT_QUOTES) . "' required />
                                            State:
                                            <select name='state'>" . 
                                                createStateAbbrevOptions($us_state_abbrevs, $submittedState) . 
                                            "</select>
                                            Zip Code: <input type='text' name='zip' value='" . htmlentities($submittedZip, ENT_QUOTES) . "' required />
                                        </div><br />
                                        <div>
                                            Description:<br /> <textarea rows='4' cols='100' name='description' required>" . htmlentities($submittedDescription, ENT_QUOTES) . "</textarea>
                                        </div><br />
                                        <div>
                                            Forms Needed:<br /> <textarea rows='4' cols='100' name='forms' required>" . htmlentities($submittedForms, ENT_QUOTES) . "</textarea>
                                        </div>
                                        <br />
                                        <input type='submit' value='Submit' class='btn btn-default' />
                                    </form><br />";
                            }
                        ?>
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