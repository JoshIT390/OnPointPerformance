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
						<p><h3><a href="add.html">Add a Member</a></h3>
						 <h3> Search for a Member:</h3>
							<form action="memberlist.php" method="post">
							First Name: <input type="text" name="fname">
							Last Name: <input type="text" name="lname"> 
							Email: <input type="text" name="email"> 
							Member Status: <select name="status"> 
							<option value="all">All</option>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option> </select> 
							<input type="submit" value="Submit"> </form></br> </br> 
							<?php
							$servername = "mysql.dnguyen94.com";
							$username = "ad_victorium";
							$password = "MT8AlJAM";
							$database = "onpoint_performance_center_lower";

							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
							$result = mysqli_query($conn, "SELECT FIRSTNAME, LASTNAME, MEMBER_EMAIL, PHONE, DUEDATE, ACTIVESTATUS FROM MEMBER_ACCOUNT;");
							printf("Returned %d row(s).", $result->num_rows);
							echo "<table style='width:100%'><tr><td>First Name</td><td>Last Name</td><td>Email Address</td><td>Phone Number</td><td>Dues Paid Until</td><td>Member Status</td></tr>";
							if ($result->num_rows > 0) {
								// output data of each row
								while($row = $result->fetch_assoc()) {
								if ($row["ACTIVESTATUS"] == 1){
									$status = "Active";
								}
								else if($row["ACTIVESTATUS"] == 0){
									$status = "Inactive";
								}
								echo "<tr> <td>". $row["FIRSTNAME"]. "</td> <td> ". $row["LASTNAME"]. "</td> <td> <a href='mailto:" . $row["MEMBER_EMAIL"] . "'>" . $row["MEMBER_EMAIL"] . " </a></td> <td>" . $row["PHONE"] . "</td> <td>" . $row["DUEDATE"] . "</td> <td>" . $status . "</td> </tr>";
								}
							}
							$result->close();
							
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
