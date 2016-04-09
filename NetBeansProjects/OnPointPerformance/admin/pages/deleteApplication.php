<?php
    $servername = "onpointPerformancecenter.com";
    $username = "oppcowner";
    $password = "8K(eFzSE1Gi!";
    $database = "onpoint_performance_center";
    $appID = $_POST["appID"];

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $query = "DELETE FROM APPLICATIONS WHERE APP_ID=" . $appID . ";";
    $result = mysqli_query($conn, $query);
    
    header('Location: https://onpointperformancecenter.com/admin/pages/applications.php?success=true');
    
    ?>