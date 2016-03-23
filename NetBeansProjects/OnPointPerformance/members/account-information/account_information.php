<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
    define("USER_CREDENTIAL_TABLE2", "ADMIN_USERS");
    
    $us_state_abbrevs = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY');
    
    // Create dropdown of states with user's state pre-selected
    function createStateAbbrevOptions($us_state_abbrevs, $memberState) {
        $stateAbbrevOptions;
                
        foreach ($us_state_abbrevs as &$stateAbbrev) {
            if ($stateAbbrev == $memberState) {
                $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '" selected>' . $stateAbbrev . '</option>';
            }
            else {
                $stateAbbrevOptions .= '<option value="' . $stateAbbrev . '">' . $stateAbbrev . '</option>';
            }
        }
        
        return $stateAbbrevOptions;
    }
    
    function displayAccountInformation($username, $us_state_abbrevs) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformation = $connection->prepare('SELECT FIRSTNAME, LASTNAME, ADDRESS, CITY, STATE, ZIP, PHONE, MEMBER_EMAIL FROM ' . USER_CREDENTIAL_TABLE . 
                                                       ' WHERE MEMBER_EMAIL = :username');
            $accountInformation->bindParam(':username', $username);
            $accountInformation->execute();
            
            $accountInformationResult = $accountInformation->fetch();
            
            echo 
            '<div class="row-fluid">
                <form method="post" action="./" id="account_update">
                    <div>
                        First name <input type="text" name="firstName" value="' . $accountInformationResult[0] . '" required/><br /><br />
                        Last name <input type="text" name="lastName" value="' . $accountInformationResult[1] . '" required/><br /><br />
                        Address <input type="text" name="address" value="' . $accountInformationResult[2] . '" required/><br /><br />
                        City <input type="text" name="city" value="' . $accountInformationResult[3] . '"/ required/><br /><br />
                        State <select name="state">' . createStateAbbrevOptions($us_state_abbrevs, $accountInformationResult[4]) . '</select><br /><br />
                        Zip code <input type="number" name="zip" value="' . $accountInformationResult[5] . '" maxlength="5" required/><br /><br />
                        Phone number <input type="tel" name="phone" value="' . $accountInformationResult[6] . '" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" maxlength="13" required/><br /><br />
                        Email <input type="email" name="email" value="' . $accountInformationResult[7] . '" required/><br /><br />
                        <input type="hidden" name="submit" value="TRUE">
                        <input type="submit" value="Save changes" />
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
    
    function findAdminEmailMatch($submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $adminEmailQuery = $connection->prepare('
                SELECT EMAIL 
                FROM ' . USER_CREDENTIAL_TABLE2 . ' 
                WHERE EMAIL LIKE :submittedEmail'
            );

            $adminEmailQuery->execute(array(
                ':submittedEmail' => $submittedEmail                                                                    
            ));

            $adminEmail = $adminEmailQuery->fetch(PDO::FETCH_NUM);
            return $adminEmail;
        }
        // Script halts and throws error if exception is caught
        catch(PDOException $e) {
            echo "
            <div>
                Error: " . $e->getMessage() . 
            "</div>";
        }
    }

    function findMemberEmailMatch($submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $memberEmailQuery = $connection->prepare('
                SELECT MEMBER_EMAIL 
                FROM ' . USER_CREDENTIAL_TABLE . ' 
                WHERE MEMBER_EMAIL LIKE :submittedEmail'
            );

            $memberEmailQuery->execute(array(
                ':submittedEmail' => $submittedEmail                                                                    
            ));

            $memberEmail = $memberEmailQuery->fetch(PDO::FETCH_NUM);
            return $memberEmail;
        }
        // Script halts and throws error if exception is caught
        catch(PDOException $e) {
            echo "
            <div>
                Error: " . $e->getMessage() . 
            "</div>";
        }
    }
    
    function verifyEmail($submittedEmail) {
        // No matches in both admin and member tables
        if (!findAdminEmailMatch($submittedEmail) && !findMemberEmailMatch($submittedEmail)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    function submitAccountInformation($username, $submittedFirstName, $submittedLastName, $submittedAddress, $submittedCity, $submittedState, $submittedZip, $submittedPhone, $submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . USER_CREDENTIAL_TABLE . ' SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, ADDRESS = :submittedAddress, City = :submittedCity, State = :submittedState, ZIP = :submittedZip, PHONE = :submittedPhone, MEMBER_EMAIL = :submittedEmail 
                                                              WHERE MEMBER_EMAIL = :username');
            $accountInformationUpdate->execute(array(
                ':submittedFirstName' => $submittedFirstName,
                ':submittedLastName' => $submittedLastName,
                ':submittedAddress' => $submittedAddress,
                ':submittedCity' => $submittedCity,
                ':submittedState' => $submittedState,
                ':submittedZip' => $submittedZip,
                ':submittedPhone' => $submittedPhone,
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