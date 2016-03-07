<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "ADMIN_USERS");
    
    
    function displayAccountInformation($username) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformation = $connection->prepare('SELECT FIRSTNAME, LASTNAME, EMAIL FROM ' . USER_CREDENTIAL_TABLE . ' WHERE EMAIL = :username');
            $accountInformation->bindParam(':username', $username);
            $accountInformation->execute();
            
            $accountInformationResult = $accountInformation->fetch();
            
            echo 
            '<div>
                    <form method="post" action="./" id="account_update">
                        <div>
                            First name: <input type="text" name="firstName" value="' . $accountInformationResult[0] . '" required/><br /><br />
                            Last name: <input type="text" name="lastName" value="' . $accountInformationResult[1] . '" required/><br /><br />
                            Email: <input type="email" name="email" value="' . $accountInformationResult[2] . '" required/><br /><br />
                            <input type="hidden" name="accountInfoSubmit" value="TRUE">
                            <input type="submit" class="btn btn-default" value="Save changes" />
                        </div>
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
    
    function submitAccountInformation($username, $submittedFirstName, $submittedLastName, $submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . USER_CREDENTIAL_TABLE . ' SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, EMAIL = :submittedEmail WHERE EMAIL = :username');
            $accountInformationUpdate->execute(array(
                ':submittedFirstName' => $submittedFirstName,
                ':submittedLastName' => $submittedLastName,
                ':submittedEmail' => $submittedEmail,
                ':username' => $username
            ));
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