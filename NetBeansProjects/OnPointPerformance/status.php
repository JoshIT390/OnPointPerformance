<?php
    include "../databaseInfo.php";
    
    try{
    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
    // Exceptions fire when occur
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = $connection->prepare('SELECT MEMBER_EMAIL, DUEDATE FROM ' . MEMBER_ACCOUNT);
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
    $date = new DateTime('NOW');
    date_add($date, date_interval_create_from_date_string('14 days'));
        
    $emaillist = array();    
    for ($count=0; $count<($query->rowCount()); $count++) {
        try{
            $result = $query->fetch();
            if ($result[1] == $date->format('Y-m-d') ){
                array_push($emaillist, $result[0]);
            }
            if ($result == NULL){ break;}
            
        }catch(OutOfBoundsException $e){
            $count = 10; //exit loop
        }
    }
    foreach($emaillist as $email){
        mail($email, 'Your On Point Performance Center Membership is Expiring in Two Weeks', 'Hello,  This is a reminder that in two weeks your Membership at On Point Performance Center will expire unless you pay for more time.',
        'From: noreply@onpointperformancecenter.com');
    }