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
                        <h1 class="page-header">Add Admin</h1>
                            <p>
                                <?php
                                    include '../../mail/welcome_admin.php';
                                
                                    define("DB_HOST_NAME", "mysql.dnguyen94.com");
                                    define("DB_USER_NAME", "ad_victorium");
                                    define("DB_PASSWORD", "MT8AlJAM");
                                    define("DB_NAME", "onpoint_performance_center_lower");
                                    define("USER_CREDENTIAL_TABLE", "ADMIN_USERS");
                                    define("USER_CREDENTIAL_TABLE2", "MEMBER_ACCOUNT");

                                    // Regular view
                                    if (!isset($_POST["submit"])) {
                                        displayForm("", "", "", "");
                                    }
                                    else {
                                        // Account information and manually entered password
                                        if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && (empty($_POST["generatePassword"]) && (!empty($_POST["newPassword1"]) || !empty($_POST["newPassword2"])))) {
                                            if (verifyEmail(trim($_POST["email"]))) {
                                                if(verifyPassword($_POST["newPassword1"], $_POST["newPassword2"])) {
                                                    if (submitInformation(trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"]), $_POST["newPassword1"])) {
                                                        displayForm("success_manual", "", "", "");
                                                    }
                                                    else {
                                                        displayForm("tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"]));
                                                    }
                                                }
                                                else {
                                                    displayForm("fail_password", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"]));
                                                }
                                            }
                                            else {
                                                displayForm("fail_email", trim($_POST["fname"]), trim($_POST["lname"]), "");
                                            }
                                        }
                                        // Account information entered, but no password
                                        if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && (empty($_POST["generatePassword"]) && (empty($_POST["newPassword1"]) || empty($_POST["newPassword2"])))) {
                                            displayForm("fail_password", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"]));
                                        }
                                        // Account information and password generator requested
                                        elseif (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && ($_POST["generatePassword"] == TRUE)) {
                                            $accountInfoStatus = FALSE;
                                            
                                            if (verifyEmail(trim($_POST["email"]))) {
                                                $password = generatePassword();
                                                
                                                if (submitInformation(trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"]), $password)) {
                                                    if(sendMail(trim($_POST["email"]), $password)) {
                                                        displayForm("success_auto", "", "", "");
                                                    }
                                                    else {
                                                        displayForm("tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"])); 
                                                    }                                                    
                                                }
                                                else {
                                                    displayForm("tech_diff", trim($_POST["fname"]), trim($_POST["lname"]), trim($_POST["email"])); 
                                                }
                                            }
                                            else {
                                                displayForm("fail_email", trim($_POST["fname"]), trim($_POST["lname"]), "");
                                            }
                                        }
                                    }
                                    
                                    function generatePassword() {
                                        $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';                                       
                                        return substr(str_shuffle($password_string), 0, 12);                                       
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
                                            if ((strlen($newPassword1) < 8) &&  !preg_match("#[0-9]+#", $newPassword1) && !preg_match("#[a-z]+#", $newPassword1) && !preg_match("#[A-Z]+#", $newPassword1) &&  !preg_match("#\W+#", $newPassword1)) {
                                                return FALSE;
                                            }
                                            else {
                                                return TRUE;
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
                                                FROM ' . USER_CREDENTIAL_TABLE . ' 
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
                                                FROM ' . USER_CREDENTIAL_TABLE2 . ' 
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

                                    function displayForm($status, $submittedFirstName, $submittedLastName, $submittedEmail) {
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
                                                    There was a problem creating this user. Please choose a different email address.
                                                </div>";
                                        }
                                        elseif ($status == "fail_password") {
                                            $notice = 
                                                "<div class='alert alert-danger alert-dismissable'>
                                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    There was a problem creating this user. Please follow the password requirements.
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
                                            "<form action='addadmin.php' method='post'>
                                                <div>
                                                    <h3> Add Admin</h3></br>" . 
                                                    $notice . 
                                                    "First Name: <input type='text' name='fname' value='" . $submittedFirstName . "' required /><br /><br />
                                                    Last Name: <input type='text' name='lname' value='" . $submittedLastName . "' required /><br /><br />
                                                    Email Address: <input type='email' name='email' value='" . $submittedEmail . "' required />
                                                </div>
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
                                                    <input type='submit' class='btn btn-default' value='Submit*' />
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