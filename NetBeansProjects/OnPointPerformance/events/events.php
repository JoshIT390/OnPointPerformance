<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    
    try{
        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
        // Exceptions fire when occur
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $query = $connection->prepare('SELECT * FROM CALENDAR WHERE DATE >= cast((now()) as date) ORDER BY DATE asc');
        $query->execute();
    }
    catch(PDOException $e) {
        echo "<div>
                Error: " . $e->getMessage() . 
            "</div>";
            
        return FALSE;
    }
    
    /* ["CALENDAR_ID"]=> [0]
     * ["NAME"]=> [1]
     * ["DATE"]=> [2]
     * ["CITY"]=> [3]
     * ["STATE"]=> [4]
     * ["ZIP"]=> [5]
     * ["DESCRIPTION"]=> [6]
     * ["FORMS"]=> [7]
     */
    
    $results = $query->fetchAll();
    $iterations = ceil(sizeof($results) / 3);
    
    for ($c1=0; $c1<$iterations; $c1++){
        echo "<div class='row'>";
        for ($c2=0; $c2 < 3; $c2++){ 
            $index = 3*$c1+$c2;
            $row = $results[$index];
            if ($row != NULL){
            echo    "<div class='col-lg-4'>"
                        . "<div class='panel panel-danger'>"
                            . "<div class='panel-heading'>"
                                . "<h3>" . $row[1] . "</h3>"
                            . "</div>"
                            . "<div class='panel-body'>"
                                . "<p>Date: " . $row[2] . "</p>"
                                . "<p>Location: " . $row[3] . ", " . $row[4] . " " . $row[5] . "</p>"
                                . "<p>Form needed: " . $row[7] . "</p>"
                                . "<p>Description: " . $row[6] . "</p>"
                            . "</div>"
                        . "</div>"
                    . "</div>";
            }
        }
        echo "</div>";
    }