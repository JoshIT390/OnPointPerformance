<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
                      
    
    define("COMMENT", $_POST["adminComments"]);
    define("APP_ID", $_POST["appID"]);
    
    echo $appID . ", " . $comments;
                         
    try{
        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
        // Exceptions fire when occur
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $updateAppComment = $connection->prepare('UPDATE APPLICATIONS SET ADMIN_COMMENTS=' . COMMENT . ' WHERE APP_ID =' . APP_ID);
        $updateAppComment->execute();
        //array(':appID' => $appID, ':comments' => $comments)
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    catch(PDOException $e) {
        echo "<div>
                Error: " . $e->getMessage() . 
            "</div>";
            
        return FALSE;
    }