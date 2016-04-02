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

                                $us_state_abbrevs = array("AK","AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","UT","VA","VI","VT","WA","WI","WV","WY");
                                $relationships = array('Spouse or Significant Other', 'Parent/Guardian', 'Son/Daughter', 'Sibling', 'Friend');

                                // Regular view
                                if (!isset($_POST["submit"])) {
                                    displayAccountForm("", $us_state_abbrevs, $relationships);
                                    displayPasswordForm("");
                                }
                                else {
                                    // Account information submitted
                                    if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duedate"]) && !empty($_POST["status"]) && !empty($_POST["address"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"]) && (empty($_POST["automatedPasswordReset"]) && empty($_POST["newPassword1"]) && empty($_POST["newPassword2"]))) {
                                        if (verifyEmail(trim($_POST["email"]))) {
                                            if (
                                                submitAccountInformation($_POST["fname"], $_POST["lname"], $_POST["duedate"], $_POST["status"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], preg_replace("/[^0-9]/", "", $_POST["phone"]), $_POST["email"], $_POST["notes"], $_POST["adminnotes"], $_POST["buttonMemberID"]) &&
                                                submitEmergencyContactInformation($_POST["emergency_fname"], $_POST["emergency_lname"], preg_replace("/[^0-9]/", "", $_POST["emergency_phone"]), $_POST["emergency_relationship"], $_POST["buttonMemberID"])
                                            ) {
                                                displayAccountForm("success", $us_state_abbrevs, $relationships);
                                                displayPasswordForm("");
                                            }
                                            else {
                                                displayAccountForm("tech_diff", $us_state_abbrevs, $relationships);
                                                displayPasswordForm("");
                                            }
                                        }
                                        else {
                                            displayAccountForm("fail", $us_state_abbrevs, $relationships);
                                            displayPasswordForm("");
                                        }
                                    }
                                    // Account information and/or new password submitted
                                    elseif (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duedate"]) && !empty($_POST["status"]) && !empty($_POST["address"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"]) && (empty($_POST["automatedPasswordReset"]) && (!empty($_POST["newPassword1"]) || !empty($_POST["newPassword2"])))) {
                                        if (verifyEmail(trim($_POST["email"]))) {
                                            if (
                                                submitAccountInformation($_POST["fname"], $_POST["lname"], $_POST["duedate"], $_POST["status"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], preg_replace("/[^0-9]/", "", $_POST["phone"]), $_POST["email"], $_POST["notes"], $_POST["adminnotes"], $_POST["buttonMemberID"]) &&
                                                submitEmergencyContactInformation($_POST["emergency_fname"], $_POST["emergency_lname"], preg_replace("/[^0-9]/", "", $_POST["emergency_phone"]), $_POST["emergency_relationship"], $_POST["buttonMemberID"])
                                            ) {
                                                displayAccountForm("success", $us_state_abbrevs, $relationships);
                                            }
                                            else {
                                               displayAccountForm("tech_diff", $us_state_abbrevs, $relationships); 
                                            }
                                        }
                                        else {
                                            displayAccountForm("fail", $us_state_abbrevs, $relationships);
                                        }

                                        if (verifyPassword($_POST["newPassword1"], $_POST["newPassword2"])) {
                                             if (submitPassword($_POST["newPassword1"])) {
                                                 displayPasswordForm("manual");
                                             }
                                             else {
                                                displayPasswordForm("tech_diff"); 
                                             }
                                        }
                                        else {
                                            displayPasswordForm("fail");
                                        }
                                    }
                                    // Account information and/or automated password reset option requested
                                    elseif (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["duedate"]) && !empty($_POST["status"]) && !empty($_POST["address"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["emergency_fname"]) && !empty($_POST["emergency_lname"]) && !empty($_POST["emergency_phone"]) && !empty($_POST["emergency_relationship"]) && ($_POST["automatedPasswordReset"] == TRUE)) {
                                        $accountInfoStatus = FALSE;

                                        if (verifyEmail(trim($_POST["email"]))) {
                                            if (
                                                submitAccountInformation($_POST["fname"], $_POST["lname"], $_POST["duedate"], $_POST["status"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], preg_replace("/[^0-9]/", "", $_POST["phone"]), $_POST["email"], $_POST["notes"], $_POST["adminnotes"], $_POST["buttonMemberID"]) &&
                                                submitEmergencyContactInformation($_POST["emergency_fname"], $_POST["emergency_lname"], preg_replace("/[^0-9]/", "", $_POST["emergency_phone"]), $_POST["emergency_relationship"], $_POST["buttonMemberID"])
                                            ) {
                                                displayAccountForm("success", $us_state_abbrevs, $relationships);
                                                $accountInfoStatus = TRUE;
                                            }
                                            else {
                                                displayAccountForm("tech_diff", $us_state_abbrevs, $relationships); 
                                            }

                                            if ($accountInfoStatus) {
                                                if (automatedPasswordReset()) {
                                                    displayPasswordForm("success_automated");
                                                }
                                                else {
                                                    displayPasswordForm("tech_diff_automated");
                                                }
                                            }
                                            else {
                                                displayPasswordForm("verify_account_info");
                                            }
                                        }
                                        else {
                                            displayAccountForm("fail", $us_state_abbrevs, $relationships);
                                        }
                                    }
                                }

                                // Create dropdown of states with user's state pre-selected
                                function createStateAbbrevOptions($us_state_abbrevs, $memberState) {
                                    $stateAbbrevOptions;

                                    foreach ($us_state_abbrevs as &$stateAbbrev) {
                                        if ($stateAbbrev == $memberState) {
                                            $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '" selected>' . $stateAbbrev . '</option>';
                                        }
                                        else {
                                            $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '">' . $stateAbbrev . '</option>';
                                        }
                                    }

                                    return $stateAbbrevOptions;
                                }

                                function createRelationshipsOptions($relationships, $emergencyContactRelationship) {
                                    $relationshipsOptions;

                                    foreach ($relationships as &$relationship) {
                                        if ($relationship == $emergencyContactRelationship) {
                                            $relationshipsOptions .= '<option value="' . $relationship . '" selected>' . $relationship . '</option>';
                                        }
                                        else {
                                            $relationshipsOptions .= '<option value="' . $relationship . '">' . $relationship . '</option>';
                                        }
                                    }

                                    return $relationshipsOptions;
                                }

                                function automatedPasswordReset() {
                                    include '../../mail/password_reset.php';
                                    $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                                    $password = substr(str_shuffle($password_string), 0, 12);

                                    if (submitPassword($password)) {
                                        sendMail(trim($_POST["email"]), $password);
                                        return TRUE;
                                    }
                                    else {
                                        return FALSE;
                                    }
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
                                            Error: " . $e->getMessage() . 
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
                                            UPDATE ' . EMERGENCY_CONTACTS_TABLE . ' 
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

                                function submitPassword($newPassword) {
                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $accountInformationUpdate = $connection->prepare(
                                                'UPDATE ' . USER_CREDENTIAL_TABLE . ' SET PASSWORD = :submittedPassword 
                                                WHERE MEMBER_ID = :memberID');

                                        $accountInformationUpdate->execute(array(
                                            ':submittedPassword' => hashPassword($newPassword),
                                            ':memberID' => $_POST["buttonMemberID"]
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
                                    if (!findMemberEmailMatch($submittedEmail) && !findAdminEmailMatch($submittedEmail)) {
                                        return TRUE;
                                    }
                                    else {
                                        return FALSE;
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
                                            WHERE MEMBER_ID != :memberID AND MEMBER_EMAIL LIKE :submittedEmail'
                                        );

                                        $memberEmailQuery->execute(array(
                                            ':memberID' => $_POST["buttonMemberID"],
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

                                function displayAccountForm($status, $us_state_abbrevs, $relationships) {
                                    $notice = "";

                                    if ($status == "success") {
                                        $notice = 
                                            "<div class='alert alert-success alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Account and emergency contact information updated.
                                            </div>";
                                    }
                                    elseif ($status == "fail") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Account information not updated. Please choose a different email address.
                                            </div>";
                                    }
                                    elseif ($status == "tech_diff") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem updating the account information. Please try again.
                                            </div>";
                                    }

                                    try {
                                        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                        // Exceptions fire when occur
                                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $accountInformationQuery = $connection->query('
                                            SELECT M.MEMBER_ID, M.MEMBER_EMAIL, M.FIRSTNAME, M.LASTNAME, M.ADDRESS, M.CITY, M.STATE, M.ZIP, M.PHONE, M.NOTES, M.ADMIN_NOTES, M.PASSWORD, M.DUEDATE, M.ACTIVESTATUS, ME.FIRSTNAME, ME.LASTNAME, ME.PHONE, ME.RELATIONSHIP, ME.EMERGENCY_CONTACT_ID 
                                            FROM ' . USER_CREDENTIAL_TABLE . ' M INNER JOIN ' . EMERGENCY_CONTACTS_TABLE . ' ME ON ME.MEMBER_ID = M.MEMBER_ID
                                            WHERE M.MEMBER_ID = '. $connection->quote($_POST["buttonMemberID"])
                                        );

                                        $accountInformation = $accountInformationQuery->fetch(PDO::FETCH_NUM);

                                        echo 
                                            "<form action='edit.php' method='post'>
                                                <h3> Editing " . $accountInformation[2] . " " . $accountInformation[3] . "</h3></br>" . 
                                                $notice . 
                                                "<input type='text' name='buttonMemberID' value='" . $_POST["buttonMemberID"] . "' hidden>
                                                <table style='width:75%'>
                                                    <tr>
                                                        <td>First Name: <input type='text' name='fname' value='" . htmlentities($accountInformation[2], ENT_QUOTES) . "' required /></td>
                                                        <td>Last Name: <input type='text' name='lname' value='" . htmlentities($accountInformation[3], ENT_QUOTES) . "'  required /></td>
                                                        <td>Dues Paid Until: <input type='date' name='duedate' value='" . $accountInformation[12] . "' required /></td>
                                                        <td>Member Status: <select name='status' >
                                                            <option value='active'>Active</option>
                                                            <option value='inactive'";
                                                            if ($accountInformation[13] == '0') {
                                                                echo "selected>Inactive</option> </select> </td></tr>";
                                                            }
                                                            else { 
                                                                echo ">Inactive</option> </select> </td></tr>";
                                                            }
                                                        echo
                                                        "<tr>
                                                            <td> </br>Street Address: <input type='text' name='address' value='" . htmlentities($accountInformation[4], ENT_QUOTES) . "'  required></td>
                                                            <td></br>City: <input type='text' name='city' value='" . htmlentities($accountInformation[5], ENT_QUOTES) . "' required></td>
                                                            <td>
                                                                </br>State: 
                                                                <select name='state' required>" . 
                                                                    createStateAbbrevOptions($us_state_abbrevs, $accountInformation[6]) . 
                                                                "</select>
                                                            </td>
                                                            <td></br>Zip Code: <input type='text' name='zip' value='" . $accountInformation[7] . "' required /></td>
                                                        </tr>
                                                        <tr>
                                                            <td> </br>Phone Number: <input type='text' name='phone' value='" . preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $accountInformation[8]) . "' pattern='(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}' maxlength='14' required/></td>
                                                            <td></br>Email Address: <input type='text' name='email' value='" . htmlentities($accountInformation[1], ENT_QUOTES) . "' required></td>
                                                        </tr>
                                                    </table>
                                                    <br />
                                                    <div style='width:50%'>
                                                        Member Viewable Notes:</br> 
                                                        <textarea rows='4' cols='100' name='notes'>" . htmlentities($accountInformation[9], ENT_QUOTES) . "</textarea>
                                                    </div>
                                                    <div style='width:50%'>
                                                        Administrator Notes:</br>
                                                        <textarea rows='4' cols='100' name='adminnotes'>" . htmlentities($accountInformation[10], ENT_QUOTES) . "</textarea>
                                                    </div>
                                                    <hr />
                                                    <h4>Emergency Contact</h4>
                                                    <table style='width:50%'>
                                                        <tr>
                                                                <td>First Name: <input type='text' name='emergency_fname' value='" . htmlentities($accountInformation[14], ENT_QUOTES) . "' required /></td>
                                                                <td>Last Name: <input type='text' name='emergency_lname' value='" . htmlentities($accountInformation[15], ENT_QUOTES) . "'  required /></td>
                                                                <td>Phone Number: <input type='text' name='emergency_phone' value='" . preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $accountInformation[16]) . "' pattern='(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}' maxlength='14' required/></td>
                                                                <td>Relationship <select name='emergency_relationship'>" . createRelationshipsOptions($relationships, $accountInformation[17]) . "</select></td>
                                                        </tr>
                                                    </table>
                                                    <hr />";
                                    }
                                    // Script halts and throws error if exception is caught
                                    catch(PDOException $e) {
                                        echo "
                                        <div>
                                            Error: " . $e->getMessage() . 
                                        "</div>";
                                    }
                                }

                                function displayPasswordForm($status) {
                                    $notice = "";

                                    if ($status == "manual") {
                                        $notice = 
                                            "<div class='alert alert-success alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Password updated.
                                            </div>";
                                    }
                                    elseif ($status == "fail") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Password not updated. Please make sure you follow the password requirements.
                                            </div>";
                                    }
                                    elseif ($status == "tech_diff") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem updating the password. Please try again.
                                            </div>";
                                    }
                                    elseif ($status == "success_automated") {
                                        $notice = 
                                            "<div class='alert alert-success alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Automated password update performed.
                                            </div>";
                                    }
                                    elseif ($status == "tech_diff_automated") {
                                        $notice = 
                                            "<div class='alert alert-danger alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                There was a problem with the automated password update. Please try again.
                                            </div>";
                                    }

                                    echo 
                                                "<div>
                                                    <h4>Password</h4>" . 
                                                    $notice . 
                                                    "<script type='text/javascript'>
                                                        function ShowHideDiv(automatedPasswordReset) {
                                                            var passwordInformation = document.getElementById('passwordInformation');
                                                            passwordInformation.style.display = automatedPasswordReset.checked ? 'none' : 'block';
                                                        }
                                                    </script>

                                                    <div class='checkbox' for='automatedPasswordReset'>
                                                        <label>
                                                            <input type='checkbox' name='automatedPasswordReset' id='automatedPasswordReset' onclick = 'ShowHideDiv(this)' value='TRUE'> Automated password reset
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

                                                    Enter the user's new password: <input type='password' name='newPassword1' /><br /><br />
                                                    Re-enter the user's new password: <input type='password' name='newPassword2' /><br /><br />
                                                </div>
                                            </div>
                                            <hr />
                                            <div>
                                                <input type='text' name='submit' value='TRUE' hidden>
                                                <input type='submit' class='btn btn-default' value='Save changes' />
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