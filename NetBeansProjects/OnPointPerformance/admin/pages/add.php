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

    <meta charset="UTF-8">
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
                                include '../../mail/welcome_member.php';
                                include '../../mail/audit_alert.php';
                                include "../../databaseInfo.php";

                                $us_state_abbrevs = array("AK","AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","UT","VA","VI","VT","WA","WI","WV","WY");
                                $relationships = array('Spouse or Significant Other', 'Parent/Guardian', 'Son/Daughter', 'Sibling', 'Friend');

                                // Regular view
                                if (!isset($_POST["submit"])) {
                                    displayForm($us_state_abbrevs, $relationships, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                                }
                                else {
                                    // Account information and manually entered password
                                    if (
                                        !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duesdate"]) && !empty($_POST["street"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"]) &&
                                        (empty($_POST["generatePassword"]) && (!empty($_POST["newPassword1"]) || !empty($_POST["newPassword2"])))
                                    ) {
                                        if (verifyEmail(trim($_POST["email"]))) {
                                            if(verifyPassword($_POST["newPassword1"], $_POST["newPassword2"])) {
                                                if (submitAccountInformation(trim($_POST["fname"]), trim($_POST["lname"]), $_POST["duesdate"], 1, trim($_POST["street"]), trim($_POST["city"]), $_POST["state"], $_POST["zip"], preg_replace("/[^0-9]/", "", trim($_POST["phone"])), trim($_POST["email"]), $_POST["notes"], $_POST["newPassword2"])) {
                                                    if (submitEmergencyContactInformation(trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), preg_replace("/[^0-9]/", "", trim($_POST["emergency_phone"])), $_POST["emergency_relationship"], trim($_POST["email"]))) {
                                                        sendAuditAlert((htmlentities(trim($_POST["fname"]), ENT_QUOTES) . " " . htmlentities(trim($_POST["lname"]), ENT_QUOTES)), htmlentities(trim($_POST["email"]), ENT_QUOTES), "member", date("D M j y G:i:s e"), $_SESSION['admin_username']);
                                                        displayForm($us_state_abbrevs, $relationships, "success_manual", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");                                                        
                                                    }
                                                }
                                                else {
                                                    displayForm($us_state_abbrevs, $relationships, "tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), trim($_POST["email"]), $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                                }
                                            }
                                            else {
                                                displayForm($us_state_abbrevs, $relationships, "fail_password", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), trim($_POST["email"]), $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                            }
                                        }
                                        else {
                                            displayForm($us_state_abbrevs, $relationships, "fail_email", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), "", $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                        }
                                    }
                                    // Account information entered, but no password
                                    elseif (
                                        !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duesdate"]) && !empty($_POST["street"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"]) && 
                                        (empty($_POST["generatePassword"]) && (empty($_POST["newPassword1"]) || empty($_POST["newPassword2"])))
                                    ) {
                                        displayForm($us_state_abbrevs, $relationships, "fail_password", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), trim($_POST["email"]), $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                    }
                                    // Account information and password generator requested
                                    elseif (
                                        !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duesdate"]) && !empty($_POST["street"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"])

                                        && ($_POST["generatePassword"] == TRUE)
                                    ) {
                                        $accountInfoStatus = FALSE;

                                        if (verifyEmail(trim($_POST["email"]))) {
                                            $password = generatePassword();

                                            if (submitAccountInformation(trim($_POST["fname"]), trim($_POST["lname"]), $_POST["duesdate"], 1, trim($_POST["street"]), trim($_POST["city"]), $_POST["state"], $_POST["zip"], preg_replace("/[^0-9]/", "", trim($_POST["phone"])), trim($_POST["email"]), $_POST["notes"], $password)) {
                                                if (submitEmergencyContactInformation(trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), preg_replace("/[^0-9]/", "", trim($_POST["emergency_phone"])), $_POST["emergency_relationship"], trim($_POST["email"]))) {
                                                    if(sendMail(trim($_POST["email"]), $password)) {
                                                        sendAuditAlert((htmlentities(trim($_POST["fname"]), ENT_QUOTES) . " " . htmlentities(trim($_POST["lname"]), ENT_QUOTES)), htmlentities(trim($_POST["email"]), ENT_QUOTES), "member", date("D M j y G:i:s e"), $_SESSION['admin_username']);
                                                        displayForm($us_state_abbrevs, $relationships, "success_auto", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                                                        
                                                    }
                                                    else {
                                                        displayForm($us_state_abbrevs, $relationships, "tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), trim($_POST["email"]), $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                                    }   
                                                }
                                            }
                                            else {
                                                displayForm($us_state_abbrevs, $relationships, "tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), trim($_POST["email"]), $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                            }
                                        }
                                        else {
                                            displayForm($us_state_abbrevs, $relationships, "fail_email", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["duesdate"]), trim($_POST["street"]), trim($_POST["city"]), trim($_POST["state"]), trim($_POST["zip"]), trim($_POST["phone"]), "", $_POST["notes"], trim($_POST["emergency_fname"]), trim($_POST["emergency_lname"]), trim($_POST["emergency_phone"]), trim($_POST["emergency_relationship"]));
                                        }
                                    }
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

                                function createRelationshipsOptions($relationships, $submittedEmergencyContactRelationship) {
                                    $relationshipsOptions;

                                    foreach ($relationships as &$relationship) {
                                        if ($relationship == $submittedEmergencyContactRelationship) {
                                            $relationshipsOptions .= '<option value="' . $relationship . '" selected>' . $relationship . '</option>';
                                        }
                                        else {
                                            $relationshipsOptions .= '<option value="' . $relationship . '">' . $relationship . '</option>';
                                        }
                                    }

                                    return $relationshipsOptions;
                                }

                                function generatePassword() {
                                    $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';                                       
                                    return substr(str_shuffle($password_string), 0, 12);                                       
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
                                            INSERT INTO " . EMERGENCY_CONTACTS_TABLE . "(FIRSTNAME, LASTNAME, PHONE, RELATIONSHIP, MEMBER_ID)
                                            VALUES (:submittedFirstName, :submittedLastName, :submittedPhone, :submittedRelationship, '" . getMemberID($submittedEmail) . "')"
                                        );

                                        $accountInformationUpdate->execute(array(
                                            ':submittedFirstName' => $submittedFirstName,
                                            ':submittedLastName' => $submittedLastName,
                                            ':submittedPhone' => $submittedPhone,
                                            ':submittedRelationship' => $submittedRelationship,
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

                                function submitInformation($submittedFirstName, $submittedLastName, $submittedEmail, $submittedPassword) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $accountInformationUpdate = $connection->prepare(
                                                'INSERT INTO ' . USER_CREDENTIAL_TABLE . ' (FIRSTNAME, LASTNAME, EMAIL, PASSWORD) 
                                                VALUES (:submittedFirstName, :submittedLastName, :submittedEmail, :submittedPassword)');

                                        $accountInformationUpdate->execute(array(
                                            ':submittedFirstName' => $submittedFirstName,
                                            ':submittedLastName' => $submittedLastName,
                                            ':submittedEmail' => $submittedEmail,
                                            ':submittedPassword' => hashPassword($submittedPassword)
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

                                // Applies random salt to inputted password and hashes
                                function hashPassword($password) {
                                    $cost = 10;
                                    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                                    $salt = sprintf("$2a$%02d$", $cost) . $salt;
                                    return crypt($password, $salt);
                                }

                                function verifyPassword($newPassword1, $newPassword2) { 
                                    if ($newPassword1 != $newPassword2) {
                                        return FALSE;
                                    }
                                    else {
                                        // Must be greater than or equal to eight characters and use numbers, lower-case letters, upper-case letters, and special characters
                                        if ((strlen($newPassword1) >= 8) &&  preg_match("#[0-9]+#", $newPassword1) && preg_match("#[a-z]+#", $newPassword1) && preg_match("#[A-Z]+#", $newPassword1) &&  preg_match("#\W+#", $newPassword1)) {
                                            return TRUE;
                                        }
                                        else {
                                            return FALSE;
                                        }
                                    }
                                }

                                function verifyEmail($submittedEmail) {
                                    // No matches in both admin and member tables
                                    if (!findAdminEmailMatch($submittedEmail) && !findMemberEmailMatch($submittedEmail)) {
                                        return TRUE;
                                    }
                                    else {
                                        return FALSE;
                                    }
                                }

                                function findAdminEmailMatch($submittedEmail) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $adminEmailQuery = $connection->prepare('
                                            SELECT EMAIL 
                                            FROM ' . ADMIN_CREDENTIAL_TABLE . ' 
                                            WHERE EMAIL LIKE :submittedEmail'
                                        );

                                        $adminEmailQuery->execute(array(
                                            ':submittedEmail' => $submittedEmail                                                                    
                                        ));

                                        $adminEmail = $adminEmailQuery->fetch(PDO::FETCH_NUM);
                                        return $adminEmail;
                                    }
                                    // Script halts and throws error if exception is caught
                                    catch(PDOException $e) {
                                        echo "
                                        <div>
                                            Error: " . $e->getMessage() . 
                                        "</div>";
                                    }
                                }

                                function findMemberEmailMatch($submittedEmail) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $memberEmailQuery = $connection->prepare('
                                            SELECT MEMBER_EMAIL 
                                            FROM ' . USER_CREDENTIAL_TABLE . ' 
                                            WHERE MEMBER_EMAIL LIKE :submittedEmail'
                                        );

                                        $memberEmailQuery->execute(array(
                                            ':submittedEmail' => $submittedEmail                                                                    
                                        ));

                                        $memberEmail = $memberEmailQuery->fetch(PDO::FETCH_NUM);
                                        return $memberEmail;
                                    }
                                    // Script halts and throws error if exception is caught
                                    catch(PDOException $e) {
                                        echo "
                                        <div>
                                            Error: " . $e->getMessage() . 
                                        "</div>";
                                    }
                                }

                                function displayForm($us_state_abbrevs, $relationships, $status, $submittedFirstName, $submittedLastName, $submittedDuesDate, $submittedStreet, $submittedCity, $submittedState, $submittedZip, $submittedPhone, $submittedEmail, $submittedAdminNotes, $submittedEmergencyFirstName, $submittedEmergencyLastName, $submittedEmergencyPhone, $submittedEmergencyRelationship) {                                   
                                    $notice = "";

                                    if ($status == "success_manual") {
                                        $notice = 
                                            "<div class='alert alert-success alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                User successfully created.
                                            </div>";
                                    }
                                    elseif ($status == "success_auto") {
                                        $notice = 
                                            "<div class='alert alert-success alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                User successfully created. A welcome email with instructions to reset his/her password was sent.
                                            </div>";
                                    }
                                    elseif ($status == "fail_email") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem creating this user. Please choose a different email address and try again.
                                            </div>";
                                    }
                                    elseif ($status == "fail_password") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem creating this user. Please follow the password requirements and try again.
                                            </div>";
                                    }
                                    elseif ($status == "tech_diff") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem creating this user. Please try again.
                                            </div>";
                                    }

                                    echo 
                                        "<form action='add.php' method='post'>
                                                <h3> Add a Member</h3></br>" . 
                                                $notice . 
                                                "<div>
                                                    First Name: <input type='text' name='fname' value='" . htmlentities($submittedFirstName, ENT_QUOTES) . "' required />
                                                    Last Name: <input type='text' name='lname' value='" . htmlentities($submittedLastName, ENT_QUOTES) . "' required />
                                                    Dues End Date: <input type='date' name='duesdate' value='" . $submittedDuesDate . "' required />
                                                </div><br />
                                                <div>
                                                    Street Address: <input type='text' name='street' value='" . htmlentities($submittedStreet, ENT_QUOTES) . "' required />
                                                    City: <input type='text' name='city' value='" . htmlentities($submittedCity, ENT_QUOTES) . "' required />
                                                    State:
                                                    <select name='state'>" . 
                                                        createStateAbbrevOptions($us_state_abbrevs, $submittedState) . 
                                                    "</select>
                                                    Zip Code: <input type='text' name='zip' value='" . htmlentities($submittedZip, ENT_QUOTES) . "' maxlength='5' required />
                                                </div><br />
                                                <div>
                                                    Phone Number: <input type='text' name='phone' value='" . $submittedPhone . "' required />
                                                    Email Address: <input type='text' name='email' value='" . htmlentities($submittedEmail, ENT_QUOTES) . "' required />
                                                </div>
                                                <br />
                                                <div>
                                                    Administrator Notes:
                                                </div>
                                                <div>
                                                    <textarea rows='4' cols='100' name='notes'>" . htmlentities($submittedAdminNotes, ENT_QUOTES) . "</textarea>
                                                </div>
                                                <hr />
                                                <h4> Emergency Contact:</h4>
                                                <div>
                                                    First Name: <input type='text' name='emergency_fname' value='" . htmlentities($submittedEmergencyFirstName, ENT_QUOTES) . "' required />
                                                    Last Name: <input type='text' name='emergency_lname' value='" . htmlentities($submittedEmergencyLastName, ENT_QUOTES) . "' required />
                                                    Phone Number: <input type='text' name='emergency_phone' value='" . htmlentities($submittedEmergencyPhone, ENT_QUOTES) . "' pattern='(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}' maxlength='14' required />                                    
                                                    Relationship:
                                                    <select name='emergency_relationship'>" . 
                                                        createRelationshipsOptions($relationships, $submittedEmergencyRelationship) . 
                                                    "</select>
                                            <hr />
                                            <div>
                                                <h4>Password</h4>
                                                <script type='text/javascript'>
                                                    function ShowHideDiv(generatePassword) {
                                                        var passwordInformation = document.getElementById('passwordInformation');
                                                        passwordInformation.style.display = generatePassword.checked ? 'none' : 'block';
                                                    }
                                                </script>

                                                <div class='checkbox' for='generatePassword'>
                                                    <label>
                                                        <input type='checkbox' name='generatePassword' id='generatePassword' onclick = 'ShowHideDiv(this)' value='TRUE'> Generate password
                                                    </label>
                                                </div><br />
                                                <div id='passwordInformation' style='display: hidden'>
                                                The user's password must be eight or more characters and have at least one of each:
                                                <ul>
                                                    <li>Lower-case letter</li>
                                                    <li>Upper-case letter</li>
                                                    <li>Number</li>
                                                    <li>Special characters</li>
                                                </ul>

                                                Enter the user's password: <input type='password' name='newPassword1'/><br /><br />
                                                Re-enter the user's password: <input type='password' name='newPassword2'/><br /><br />
                                            </div>
                                            <hr />
                                            <div>
                                                <input type='text' name='submit' value='TRUE' hidden>
                                                <input type='submit' class='btn btn-default' value='Submit' />
                                            </div>
                                        </form>";
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
