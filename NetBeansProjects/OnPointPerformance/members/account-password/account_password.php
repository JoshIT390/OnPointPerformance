<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
    
    function displayPasswordForm($status) {
        $message = "";
        
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
                    Your new password must follow the requirements above. Please try again.
                </div>";
        }      
        
        echo 
        '<div class="row-fluid">
            <div class="well bs-component">
                <legend style="font-weight: bold; color:#ffffff">PASSWORD</legend>
                Your new password must be eight or more characters and have at least one each:
                <ul>
                    <li>Lower-case letter</li>
                    <li>Upper-case letter</li>
                    <li>Number</li>
                    <li>Special characters</li>
                </ul><br />' . 
                $message . 
                '<form method="post" action="./" id="account_update">
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Enter your current password</label>
                        <div class="col-lg-7">
                            <input type="password" name="currentPassword" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Enter your new password</label>
                        <div class="col-lg-7">
                            <input type="password" name="newPassword1" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Re-enter your new password</label>
                        <div class="col-lg-7">
                            <input type="password" name="newPassword2" class="form-control" />
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Save changes" class="btn btn-default" />
                    </div>
                </form>
            </div>
        </div>';
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
        
        return TRUE;
    }
    
    // Applies random salt to inputted password and hashes
    function hashPassword($password) {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return crypt($password, $salt);
    }