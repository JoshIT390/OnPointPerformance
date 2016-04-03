<?php
    $servername = "mysql.dnguyen94.com";
    $username = "ad_victorium";
    $password = "MT8AlJAM";
    $database = "onpoint_performance_center_lower";
    $appID = $_POST["appID"];

    // Create connection
    $conn = mysqli_connect(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "DELETE FROM " . APPLICATIONS_TABLE . " WHERE APP_ID = '" . $appID . "'";
    $result = mysqli_query($conn, $query);
    
    header('Location: https://dnguyen94.com/OnPointPerformance/admin/pages/applications.php?success=true');