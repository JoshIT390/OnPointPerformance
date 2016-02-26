<?php

define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");

    # Connect
$connection = mysqli_connect($DB_HOST_NAME, $DB_HOST_NAME, $DB_PASSWORD) or die('Could not connect: ' . mysql_error());
 
# Choose a database
mysql_select_db($DB_NAME) or die('Could not select database');
 
# Perform database query
$query = "SELECT * from ANNOUNCEMENTS ORDER BY CONVERT(DATE, DATEFIELD) ASC";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$row = mysqli_fetch_row($result);
# Print out
/*for ($Count = 0; $Count<3; $Count++) {
    
}

# Filter through rows and echo desired information
while ($row = mysql_fetch_object($result)) {
    echo $row->name;
}*/
echo '$row';