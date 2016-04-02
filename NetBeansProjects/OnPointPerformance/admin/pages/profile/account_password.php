<?php
    include "../../../databaseInfo.php";
    
    function displayPasswordForm($status) {
        $message;

        if ($status == "fail") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    A technical issue occurred during submission. Please try again.
                </div>";
        }
        elseif ($status == "success") {
            $message = 
                "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    Password successfully saved.
                </div>";
        }
        elseif ($status == "fail_current_password") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    That password is incorrect. Please try again.
                </div>";
        }
        elseif ($status == "fail_new_password_match") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    The two passwords entered for your new password must match. Please try again.
                </div>";
        }
        elseif ($status == "fail_new_password_requirements") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    Your new password must follow the requirements below. Please try again.
                </div>";
        }            
        
        echo 
        $message . 
        '<div>
            Your new password must be eight or more characters and have at least one of each:
            <ul>
                <li>Lower-case letter</li>
                <li>Upper-case letter</li>
                <li>Number</li>
                <li>Special characters</li>
            </ul><br />
            <form method="post" action="./" id="account_update">
                Enter your current password: <input type="password" name="currentPassword" /><br /><br />                            
                Enter your new password: <input type="password" name="newPassword1" /><br /><br />
                Re-enter your new password: <input type="password" name="newPassword2" /><br /><br />
                <input type="submit" class="btn btn-default" value="Save changes" />
            </form>
        </div>';
    }

    function getStoredPassword($username) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $passwordQuery = $connection->prepare('SELECT PASSWORD FROM ' . ADMIN_CREDENTIAL_TABLE . ' WHERE EMAIL = :username');
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
    
    function checkCurrentPassword($username, $currentPassword) { 
        // Checks to see if applying hashed password as salt onto inputted password and hashing equals to hashed password
        if (crypt($currentPassword, getStoredPassword($username)) !== getStoredPassword($username)) {
            return false;
        }
        else {
            return true;
        }
    }
    
    function checkNewPasswordMatch($newPassword1, $newPassword2) { 
        if ($newPassword1 != $newPassword2) {
            return false;
        }
        else {
            return true;
        }
    }

    function checkNewPasswordRequirements($newPassword) { 
        // Must be greater than or equal to eight characters and use numbers, lower-case letters, upper-case letters, and special characters
        if ((strlen($newPassword) >= 8) &&  preg_match("#[0-9]+#", $newPassword) && preg_match("#[a-z]+#", $newPassword) && preg_match("#[A-Z]+#", $newPassword) &&  preg_match("#\W+#", $newPassword)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    function submitPassword($username, $newPassword) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . ADMIN_CREDENTIAL_TABLE . ' SET PASSWORD = :newPassword WHERE EMAIL = :username');
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
        
        return TRUE;
    }
    
    // Applies random salt to inputted password and hashes
    function hashPassword($password) {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return crypt($password, $salt);
    }