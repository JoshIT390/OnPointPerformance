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
                        <h1 class="page-header">Announcements</h1>
                        <p>  
                            <?php/*
                                include "../../databaseInfo.php";

                                // Create connection
                                $conn = mysqli_connect(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
                                $annID=$_POST['annID'];
                                // Check connection
                                if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                }
                                $result = mysqli_query($conn, "SELECT TITLE, DATE, DESCRIPTION FROM " . ANNOUNCEMENTS_TABLE . " WHERE ANN_ID='" . $annID . "';");
                                if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                        echo'<form action="updateAnnouncement.php" method="post">
                                        <p>Title: <input type="text" name="title" value="'.$row["TITLE"].'"/>
                                        Date: <input type="text" name="date" placeholder="YYYY-MM-DD" value="'.$row["DATE"].'"/></p>
                                        <p>Description: <input type="text" name="description" value="'.$row["DESCRIPTION"].'"/></p>
                                        <p><input type="hidden" name="annID" value="'.$annID.'"/></p>
                                        <p><input type="submit" value="Update"/></p>
                                        </form>';

                                        }
                                }
                                $result->close();*/
                            ?>
                        </p>
                        
                        <?php
                            include "../../databaseInfo.php";
                        
                            define("TARGET_DIR", "../../images/");
                            $currentStoredImageName = getCurrentStoredImageName();
                            
                            if (!empty($_POST["title"]) && !empty($_POST["date"]) && !empty($_POST["description"]) && (!empty($_POST["imgDescription"]) && empty($_FILES["imgUpload"]["name"]))) {
                                if (submitInformation(trim($_POST["title"]), trim($_POST["description"]), $_POST["date"], "", trim($_POST["imgDescription"]))) {
                                    displayInfoForm("success");
                                    displayImageForm("success_info");
                                }
                                else {
                                    displayInfoForm("fail_submit");
                                    displayImageForm("fail_info");
                                }
                            }
                            elseif (!empty($_POST["title"]) && !empty($_POST["date"]) && !empty($_POST["description"]) && (!empty($_POST["imgDescription"]) && !empty($_FILES["imgUpload"]["name"]))) {
                                if (checkExtension(pathinfo($_FILES["imgUpload"]["name"], PATHINFO_EXTENSION))) {    
                                    if (!checkFileExists($_FILES["imgUpload"]["name"], $currentStoredImageName)) {
                                        if (file_exists(TARGET_DIR . $currentStoredImageName)) unlink(TARGET_DIR . $currentStoredImageName);

                                        if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], TARGET_DIR . $_FILES["imgUpload"]["name"])) {
                                            if (submitInformation(trim($_POST["title"]), trim($_POST["description"]), $_POST["date"], $_FILES["imgUpload"]["name"], trim($_POST["imgDescription"]))) {
                                                displayInfoForm("success");
                                                displayImageForm("success_upload");
                                            }
                                            else {
                                                unlink('../../images/' . basename( $_FILES["imgUpload"]["name"]));
                                                displayInfoForm("fail_submit");
                                                displayImageForm("fail_upload");
                                            }
                                        }
                                        else {
                                            displayInfoForm("");
                                            displayImageForm("fail_upload");
                                        }
                                    }
                                    else {
                                        displayInfoForm("");
                                        displayImageForm("fail_image_exist");
                                    }
                                }
                                else {
                                    displayInfoForm("");
                                    displayImageForm("fail_image_ext");
                                }    
                            }
                            else {
                                displayInfoForm("");
                                displayImageForm("");
                            }
                            
                            function getCurrentStoredImageName() {
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $imageNameQuery = $connection->query(
                                            'SELECT IMG_URL 
                                            FROM ' . ANNOUNCEMENTS_TABLE . ' 
                                            WHERE ANN_ID = ' . $connection->quote($_POST["annID"]));

                                    $imageName = $imageNameQuery->fetch(PDO::FETCH_ASSOC);

                                    return $imageName[IMG_URL];
                                }

                                // Script halts and throws error if exception is caught
                                catch(PDOException $e) {
                                    echo "
                                    <div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";

                                    return FALSE;
                                }
                            }
                            
                            function checkFileExists($submittedFileName, $currentFileName) {
                                $files = scandir(TARGET_DIR);
                                
                                // Returns TRUE if the file exists and is being used by another announcement
                                foreach ($files as &$file) {
                                    if (strcmp($file, $submittedFileName) == 0) {
                                        if (strcmp($file, $currentFileName) != 0) return TRUE;
                                    }
                                }
                                
                                return FALSE;
                            }
                            
                            function checkExtension($fileExtension) {
                                if (strcasecmp($fileExtension, "jpg") != 0) {
                                    if (strcasecmp($fileExtension, "jpeg") != 0) {
                                        if (strcasecmp($fileExtension, "png") != 0) {
                                            if (strcasecmp($fileExtension, "gif") != 0) {
                                                return FALSE;
                                            }
                                        }
                                        else {
                                            return TRUE;
                                        }
                                    }
                                    else {
                                        return TRUE;
                                    }
                                }
                                else {
                                    return TRUE;
                                }
                            }
                        
                            function submitInformation($submittedTitle, $submittedDescription, $submittedDate, $submittedFilePath, $submittedFileDescription) {                                                                
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    if (!empty($submittedFilePath)) {
                                        $announcementSubmit = $connection->prepare(                                   
                                                'UPDATE ' . ANNOUNCEMENTS_TABLE . ' 
                                                SET TITLE = :submittedTitle, DESCRIPTION = :submittedDescription, DATE = :submittedDate, IMG_URL = :submittedFilePath, IMG_ALT = :submittedFileDescription 
                                                WHERE ANN_ID = :annID');

                                        $announcementSubmit->execute(array(
                                            ':submittedTitle' => $submittedTitle,
                                            ':submittedDescription' => $submittedDescription,
                                            ':submittedDate' => $submittedDate,
                                            ':submittedFilePath' => $submittedFilePath,
                                            ':submittedFileDescription' => $submittedFileDescription,
                                            ':annID' => $_POST["annID"]
                                        ));
                                    }
                                    elseif (empty($submittedFilePath)) {
                                        $announcementSubmit = $connection->prepare(                                   
                                                'UPDATE ' . ANNOUNCEMENTS_TABLE . ' 
                                                SET TITLE = :submittedTitle, DESCRIPTION = :submittedDescription, DATE = :submittedDate, IMG_ALT = :submittedFileDescription 
                                                WHERE ANN_ID = :annID');

                                        $announcementSubmit->execute(array(
                                            ':submittedTitle' => $submittedTitle,
                                            ':submittedDescription' => $submittedDescription,
                                            ':submittedDate' => $submittedDate,
                                            ':submittedFileDescription' => $submittedFileDescription,
                                            ':annID' => $_POST["annID"]
                                        ));
                                    }
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
                            
                            function displayInfoForm($status) {
                                $notice = "";

                                if ($status == "success") {
                                    $notice = 
                                        "<div class='alert alert-success alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Announcement information successfully changed.
                                        </div>";
                                }
                                elseif ($status == "fail_submit") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            There was a problem making changes to the announcement information. Please try again.
                                        </div>";
                                }
                                
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $formDataQuery = $connection->query(
                                            'SELECT TITLE, DATE, DESCRIPTION 
                                            FROM ' . ANNOUNCEMENTS_TABLE . ' 
                                            WHERE ANN_ID = ' . $connection->quote($_POST["annID"]));

                                    $formData = $formDataQuery->fetch(PDO::FETCH_ASSOC);
                                
                                    echo 
                                        '<div>  
                                            <h3>Editing "' . $formData[TITLE] . '"</h3><br />' .
                                            $notice . '
                                            <form action="editAnnouncement.php" method="post" enctype="multipart/form-data">
                                                Title: <input type="text" name="title" value="' . htmlentities($formData[TITLE], ENT_QUOTES) . '" required /><br /><br />
                                                Date: <input type="date" name="date" placeholder="YYYY-MM-DD" value="' . htmlentities($formData[DATE], ENT_QUOTES) . '" required /><br /><br />
                                                Description:<br />
                                                <textarea rows="4" cols="100" name="description">' . htmlentities($formData[DESCRIPTION], ENT_QUOTES) . '</textarea>
                                                <hr />';
                                }

                                // Script halts and throws error if exception is caught
                                catch(PDOException $e) {
                                    echo "
                                    <div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";

                                    return FALSE;
                                }
                            }
                            
                            function displayImageForm($status) {
                                $notice = "";

                                if ($status == "success") {
                                    $notice = 
                                        "<div class='alert alert-success alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Image description successfully changed.
                                        </div>";
                                }
                                elseif ($status == "success_upload") {
                                    $notice = 
                                        "<div class='alert alert-success alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Image and image description successfully changed.
                                        </div>";
                                }
                                elseif ($status == "fail_image_exist") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            The uploaded image already exists. Please choose a different image or rename your image and try again.
                                        </div>";
                                }
                                elseif ($status == "fail_image_ext") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            The uploaded image is not a supported format. Please choose a different image or convert your image to the below requirements and try again.
                                        </div>";
                                }
                                elseif ($status == "fail_info") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            There was a problem with changing the image description. Please try again.
                                        </div>";
                                }
                                elseif ($status == "fail_upload") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            There was a problem with the image upload. Please try again.
                                        </div>";
                                }
                                
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $imageDescriptionQuery = $connection->query(
                                            'SELECT IMG_ALT 
                                            FROM ' . ANNOUNCEMENTS_TABLE . ' 
                                            WHERE ANN_ID = ' . $connection->quote($_POST["annID"]));

                                    $imageDescription = $imageDescriptionQuery->fetch(PDO::FETCH_ASSOC);
                                    
                                    echo 
                                            $notice . '
                                                <div>
                                                    <h4>Image Upload</h4>
                                                    Requirements:
                                                    <ul>
                                                        <li>Square image</li>
                                                        <li>JPG, JPEG, PNG, or GIF format</li>
                                                        <li>Not already being used by other announcements</li><br />
                                                    </ul>  
                                                    <input type="file" name="imgUpload" id="imageUpload" />
                                                </div><br />
                                                <div>
                                                    Image Description: <input type="text" name="imgDescription" value="' . htmlentities($imageDescription[IMG_ALT], ENT_QUOTES) . '" required />
                                                </div>
                                                <hr />
                                                <input type="text" name="annID" value="' . $_POST["annID"] . '" hidden />
                                                <input type="submit" value="Save changes" class="btn btn-default" />
                                            </form>
                                        </div>';
                                }

                                // Script halts and throws error if exception is caught
                                catch(PDOException $e) {
                                    echo "
                                    <div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";

                                    return FALSE;
                                }
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