<?php
/*
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
          
    $appID = $_POST["appID"];
    try{
        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
        // Exceptions fire when occur
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'DELETE FROM APPLICATIONS WHERE APP_ID=' . $appID;
        $connection->execute($query);
    }
    catch(PDOException $e) {
        echo "<div>
                Error: " . $e->getMessage() . 
            "</div>";
            
        return FALSE;
    }
    $results = $query->fetchAll();
 * */
    $servername = "mysql.dnguyen94.com";
    $username = "ad_victorium";
    $password = "MT8AlJAM";
    $database = "onpoint_performance_center_lower";
                                                       
    $appID = $_POST["appID"];                      
    echo $appID;
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "DELETE FROM APPLICATIONS WHERE APP_ID='.$appID.' ;";
    $result = mysqli_query($conn, $query);
														
    if (!$result){
        die('Invalid query: ' . mysql_error());
    }
    else{
        //echo "Successfully deleted event!</br>";
        var_dump($result);
    }