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
    
    <!-- Inline Forms -->
    <link href="inline.css" rel="stylesheet">

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
                            <h3><a href="add.php">Add a Member</a></h3>
                            <h3> Search for a Member:</h3>
                            <form action="index.php" method="post">
                                First Name: <input type="text" name="search_fname" />
                                Last Name: <input type="text" name="search_lname" /> 
                                Email: <input type="text" name="search_email" />
                                Member Status: 
                                    <select name="search_status"> 
                                        <option value="all" selected>All</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option> 
                                    </select> 
                                <input type='submit' value='Search' class='btn btn-default' />
                            </form>
                            
                            <?php
                                include "../../databaseInfo.php";
                                
                                if (isset($_POST["memberID"]) && isset($_POST["memberName"]) && isset($_POST["memberEmail"])) {                                   
                                    if ((deleteEmergencyContact($_POST["memberID"])) && (deleteMember($_POST["memberID"]))) {
                                        generatePage("success", $_POST["memberName"], $_POST["memberEmail"]);
                                    }
                                    else {
                                        generatePage("fail", $_POST["memberName"], $_POST["memberEmail"]);
                                    }
                                }
                                else {
                                    generatePage("", "", "");
                                }

                                function deleteEmergencyContact($memberID) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $deleteQuery = $connection->query('
                                            DELETE FROM ' . EMERGENCY_CONTACTS_TABLE . ' 
                                            WHERE MEMBER_ID = '. $connection->quote($memberID)
                                        );
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
                                
                                function deleteMember($memberID) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $deleteQuery = $connection->query('
                                            DELETE FROM ' . USER_CREDENTIAL_TABLE . ' 
                                            WHERE MEMBER_ID = '. $connection->quote($memberID)
                                        );
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
                                
                                function generatePage($status, $deleteMemberName, $deleteMemberEmail) {
                                    $message;
                                    $searchStatusString = "";
                                    
                                    if ($status == "success") {
                                        $message = 
                                            '<div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . 
                                                $deleteMemberName . ' (' . $deleteMemberEmail . ') was deleted successfully.
                                            </div>';
                                    }
                                    elseif ($status == "fail") {
                                        $message = 
                                            '<div class="alert alert-danger alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                There was a problem deleting ' . $deleteMemberName . ' (' . $deleteMemberEmail . '). Please try again.
                                            </div>';
                                    }
                                    
                                    if ($_POST["search_status"] == "inactive") {
                                        $searchStatusString = " AND ACTIVESTATUS = 0";
                                    }
                                    elseif ($_POST["search_status"] == "active") {
                                        $searchStatusString = " AND ACTIVESTATUS = 1";
                                    }
                                    
                                    try {
                                        $membersQuery;

                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        // Default view or member status search only
                                        if (empty($_POST["search_fname"]) && empty($_POST["search_lname"]) && empty($_POST["search_email"])) {   
                                            if (empty($_POST["search_status"]) || $_POST["search_status"] == "all") {
                                                $membersQuery = $connection->query(
                                                    'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                    FROM ' . USER_CREDENTIAL_TABLE . 
                                                    ' ORDER BY LASTNAME');
                                            }
                                            elseif ($_POST["search_status"] == "inactive") {
                                                $membersQuery = $connection->query(
                                                    'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                    FROM ' . USER_CREDENTIAL_TABLE . 
                                                    ' WHERE ACTIVESTATUS = 0 
                                                    ORDER BY LASTNAME');
                                            }
                                            elseif ($_POST["search_status"] == "active") {
                                                $membersQuery = $connection->query(
                                                    'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                    FROM ' . USER_CREDENTIAL_TABLE . 
                                                    ' WHERE ACTIVESTATUS = 1 
                                                    ORDER BY LASTNAME');
                                            }
                                        }
                                        // First name search
                                        elseif (!empty($_POST["search_fname"]) && empty($_POST["search_lname"]) && empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE FIRSTNAME LIKE :searchedFirstName' . $searchStatusString);

                                            $searchedFirstName = '%' . trim($_POST["search_fname"]) . '%';
                                            $membersQuery->bindParam(':searchedFirstName', $searchedFirstName);
                                            $membersQuery->execute();
                                        }
                                        // Last name search
                                        elseif (empty($_POST["search_fname"]) && !empty($_POST["search_lname"]) && empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE LASTNAME LIKE :searchedLastName' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedLastName = '%' . trim($_POST["search_lname"]) . '%';
                                            $membersQuery->bindParam(':searchedLastName', $searchedLastName);
                                            $membersQuery->execute();
                                        }
                                        // Email search
                                        elseif (empty($_POST["search_fname"]) && empty($_POST["search_lname"]) && !empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE MEMBER_EMAIL LIKE :searchedEmail' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedEmail = '%' . trim($_POST["search_email"]) . '%';
                                            $membersQuery->bindParam(':searchedEmail', $searchedEmail);
                                            $membersQuery->execute();
                                        }
                                        // First and last name search
                                        elseif (!empty($_POST["search_fname"]) && !empty($_POST["search_lname"]) && empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE FIRSTNAME LIKE :searchedFirstName AND LASTNAME LIKE :searchedLastName' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedFirstName = '%' . trim($_POST["search_fname"]) . '%';
                                            $searchedLastName = '%' . trim($_POST["search_lname"]) . '%';
                                            $membersQuery->execute(array(
                                                ':searchedFirstName' => $searchedFirstName,
                                                ':searchedLastName' => $searchedLastName
                                            ));
                                        }
                                        // First name and email search
                                        elseif (!empty($_POST["search_fname"]) && empty($_POST["search_lname"]) && !empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID  
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE FIRSTNAME LIKE :searchedFirstName AND MEMBER_EMAIL LIKE :searchedEmail' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedFirstName = '%' . trim($_POST["search_fname"]) . '%';
                                            $searchedEmail = '%' . trim($_POST["search_email"]) . '%';
                                            $membersQuery->execute(array(
                                                ':searchedFirstName' => $searchedFirstName,
                                                ':searchedEmail' => $searchedEmail
                                            ));
                                        }
                                        // Last name and email search
                                        elseif (empty($_POST["search_fname"]) && !empty($_POST["search_lname"]) && !empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID 
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE LASTNAME LIKE :searchedLastName AND MEMBER_EMAIL LIKE :searchedEmail' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedLastName = '%' . trim($_POST["search_lname"]) . '%';
                                            $searchedEmail = '%' . trim($_POST["search_email"]) . '%';
                                            $membersQuery->execute(array(
                                                ':searchedLastName' => $searchedLastName,
                                                ':searchedEmail' => $searchedEmail
                                            ));
                                        }
                                        // First name, last name, and email search
                                        elseif (!empty($_POST["search_fname"]) && !empty($_POST["search_lname"]) && !empty($_POST["search_email"])) {
                                            $membersQuery = $connection->prepare(
                                                'SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS, MEMBER_ID  
                                                FROM ' . USER_CREDENTIAL_TABLE . '
                                                WHERE FIRSTNAME LIKE :searchedFirstName AND LASTNAME LIKE :searchedLastName AND MEMBER_EMAIL LIKE :searchedEmail' . $searchStatusString . 
                                                ' ORDER BY LASTNAME');

                                            $searchedFirstName = '%' . trim($_POST["search_fname"]) . '%';
                                            $searchedLastName = '%' . trim($_POST["search_lname"]) . '%';
                                            $searchedEmail = '%' . trim($_POST["search_email"]) . '%';
                                            $membersQuery->execute(array(
                                                ':searchedFirstName' => $searchedFirstName,
                                                ':searchedLastName' => $searchedLastName,
                                                ':searchedEmail' => $searchedEmail
                                            ));
                                        }

                                        $members = $membersQuery->fetchAll(PDO::FETCH_ASSOC);

                                        echo 
                                            "<br /><br />" . 
                                            $message . 
                                            "<div>Returned " . ($membersQuery->rowCount()) . " row(s)</div>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Email Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Dues Paid Until</th>
                                                        <th>Member Status</th>
                                                        <th>Management</th>
                                                    </tr>
                                                </thead>";

                                        while($member = array_shift($members)){
                                            $formattedActiveStatus = "Active";
                                            if ($member[ACTIVESTATUS] == 0) $formattedActiveStatus = "Inactive";
                                            
                                            echo 
                                                "<tr>
                                                    <td>" . $member[FIRSTNAME] . "</td>
                                                    <td>" . $member[LASTNAME] . "</td>
                                                    <td><a href='mailto:" . $member[MEMBER_EMAIL] . "'>" . $member[MEMBER_EMAIL] . "</a></td>
                                                    <td>" . preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $member[PHONE]) . "</td>
                                                    <td>" . $member[DUEDATE] . "</td>
                                                    <td>" . $formattedActiveStatus . "</td>
                                                    <td>
                                                        <form action='view.php' method='post'>
                                                            <input type='text' name='buttonMemberID' value='" . $member["MEMBER_ID"] . "' hidden />
                                                            <input type='submit' class='btn btn-primary' value='View' />
                                                        </form>
                                                        <form action='edit.php' method='post'>
                                                            <input type='text' name='buttonMemberID' value='" . $member["MEMBER_ID"] . "' hidden />
                                                            <input type='submit' class='btn btn-primary' value='Edit' />
                                                        </form>
                                                        <form action='index.php' method='post'>
                                                            <input type='text' name='memberID' value='" . htmlentities($member[MEMBER_ID], ENT_QUOTES) . "' hidden />
                                                            <input type='text' name='memberName' value='" . htmlentities($member[FIRSTNAME], ENT_QUOTES) . " " . htmlentities($member[LASTNAME], ENT_QUOTES) . "' hidden />
                                                            <input type='text' name='memberEmail' value='" . htmlentities($member[MEMBER_EMAIL], ENT_QUOTES) . "' hidden />
                                                            <input type='submit' class='btn btn-warning' value='Delete' />
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }

                                        echo "</table>";
                                    }
                                    // Script halts and throws error if exception is caught
                                    catch(PDOException $e) {
                                        echo "
                                        <div>
                                            Error: " . $e->getMessage() . 
                                        "</div>";
                                    }
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
