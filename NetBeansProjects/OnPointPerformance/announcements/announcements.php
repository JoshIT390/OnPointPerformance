<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    
    try{
    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
    // Exceptions fire when occur
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = $connection->prepare('SELECT * FROM ANNOUNCEMENT ORDER BY DATE desc');
    $query->execute();
    //$result = $query->fetch_row();
    //var_dump($result);
    }
    catch(PDOException $e) {
            echo "
            <div>
                Error: " . $e->getMessage() . 
            "</div>";
            
            return FALSE;
        }
    /*  Output from query instance structure
        ["ANN_ID"]=> [0]
        ["DESCRIPTION"]=> [1]
        ["TITLE"]=> [2]
        ["DATE"]=> [3]
        ["ACTIVESTATUS"]=> [4]
     *  ["IMG_URL"]=> [5] 
     *  ["IMG_ALT"]=> [6]
      */  
        
        
    for ($count=0; $count<3; $count++) {
        try{
            $result = $query->fetch();
            if ($result == NULL){ break;}
            echo "<div class='row-fluid'>"
                    . "<div class='col-lg-3'>"
                        //todo: replace this with img url
                        . "<img src='" . $result[5] . "' alt='" . $result[6] . "' >"
                    . "</div>"
                    . "<div class='col-lg-9'>"
                        . "<div class='jumbotron'>"
                            . "<h1>" . $result[2] . "</h1>"
                            . "<p> Description: \n" . $result[1] . "</p>"
                            . "<p> Date: " . $result[3] . "</p>"
                        . "</div>"
                    . "</div>"
                . "</div>";
            
        }catch(OutOfBoundsException $e){
            $count = 10; //exit loop
        }
    }