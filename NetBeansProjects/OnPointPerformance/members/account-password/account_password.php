<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
    
    function displayPasswordForm($username) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //$passwordQuery = $connection->prepare('SELECT PASSWORD FROM ' . USER_CREDENTIAL_TABLE . ' WHERE MEMBER_EMAIL = :username');
            //$passwordQuery->execute(array('username' => $username));

            $accountInformation = $connection->prepare('SELECT FIRSTNAME, LASTNAME, ADDRESS, CITY, STATE, ZIP, PHONE, MEMBER_EMAIL, PASSWORD FROM ' . USER_CREDENTIAL_TABLE . ' WHERE MEMBER_EMAIL = :username');
            $accountInformation->bindParam(':username', $username);
            $accountInformation->execute();
            
            $accountInformationResult = $accountInformation->fetch();
            
            echo 
            '<div>
                Your new password must be eight or more characters and have at least one each:
                <ul>
                    <li>Lower-case letter</li>
                    <li>Upper-case letter</li>
                    <li>Number</li>
                    <li>Special characters</li>
                </ul>
                <form method="post" action="./" id="account_update">
                    Enter your current password <input type="password" name="currentPassword" /><br /><br />                            
                    Enter your new password <input type="password" name="newPassword1" /><br /><br />
                    Re-enter your new password <input type="password" name="newPassword2" /><br /><br />
                    <input type="submit" value="Save changes" />
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

    function getStoredPassword($username) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $passwordQuery = $connection->prepare('SELECT PASSWORD FROM ' . USER_CREDENTIAL_TABLE . ' WHERE MEMBER_EMAIL = :username');
            $passwordQuery->execute(array('username' => $username));
            
            $passwordResult = $passwordQuery->fetch();
            return $passwordResult[0];
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
    
    function checkPassword($username, $currentPassword, $newPassword1, $newPassword2) { 
        // Checks to see if applying hashed password as salt onto inputted password and hashing equals to hashed password
        if (crypt($currentPassword, getStoredPassword($username)) !== getStoredPassword($username)) {
            echo 
            "<div>
                Wrong password. Please re-enter your current password.
            </div>";
            return false;
        }
        else {
            if ($newPassword1 != $newPassword2) {
                echo
                "<div>
                    Your new passwords don't match. Please re-enter your new password.
                </div>";
                return false;
            }
            else {
                // Must be greater than or equal to eight characters and use numbers, lower-case letters, upper-case letters, and special characters
                if ((strlen($newPassword1) < 8) &&  !preg_match("#[0-9]+#", $newPassword1) && !preg_match("#[a-z]+#", $newPassword1) && !preg_match("#[A-Z]+#", $newPassword1) &&  !preg_match("#\W+#", $newPassword1)) {
                    echo 
                    "<div>
                        Please follow the password instructions above.
                    </div>";
                    return false;
                }
                else {
                    return true;
                }
            }
        }
    }
    
    function submitPassword($username, $newPassword) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . USER_CREDENTIAL_TABLE . ' SET PASSWORD = :newPassword WHERE MEMBER_EMAIL = :username');
            $accountInformationUpdate->execute(array(
                ':newPassword' => hashPassword($newPassword),
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
    
    // Applies random salt to inputted password and hashes
    function hashPassword($password) {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return crypt($password, $salt);
    }