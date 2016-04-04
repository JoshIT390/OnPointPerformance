<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
    define("USER_CREDENTIAL_TABLE2", "ADMIN_USERS");
    
    if (empty($_POST["submit"]) && empty($_POST["g-recaptcha-response"]) && empty($_POST["username"])) {
        displayForm("");
    }
    if (!empty($_POST["submit"]) && (empty($_POST["g-recaptcha-response"]) || empty($_POST["username"]))) {
        displayForm("incomplete");
    }
    elseif (!empty($_POST["submit"]) && !empty($_POST["g-recaptcha-response"]) && !empty($_POST["username"])) {
        if (isValid($_POST["g-recaptcha-response"])) {
            if (checkExistence(trim($_POST["username"])) == admin) {
                if (automatedPasswordReset(trim($_POST["username"]), "admin")) {
                    displayForm("success");
                }
                else {
                    displayForm("tech_diff");
                }
            }
            elseif (checkExistence(trim($_POST["username"])) == member) {
                if (automatedPasswordReset(trim($_POST["username"]), "member")) {
                    displayForm("success");
                }
                else {
                    displayForm("tech_diff");
                }
            }
            else {
                displayForm("nonexistant");
            }
        }
        else {
            displayForm("verfication_prob");
        }
    }

    function isValid($captcha) {
        $secret = "6LfnWRgTAAAAAOjb5kqADRu_BPY-Ez7KLZwlF7mH";
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret .'&response=' . $captcha);
        $responseData = json_decode($verifyResponse);
        
        if($responseData->success) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function checkExistence($username) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $adminEmailQuery = $connection->prepare('SELECT EMAIL FROM ' . USER_CREDENTIAL_TABLE2 . ' WHERE EMAIL LIKE :username');
            $adminEmailQuery->execute(array('username' => $username));
            
            $adminEmailResult = $adminEmailQuery->fetch();
            // If no matches
            if (!$adminEmailResult) {
                $memberEmailQuery = $connection->prepare('SELECT MEMBER_EMAIL FROM ' . USER_CREDENTIAL_TABLE . ' WHERE MEMBER_EMAIL LIKE :username');
                $memberEmailQuery->execute(array('username' => $username));
                $memberEmailResult = $memberEmailQuery->fetch();
                if (!$memberEmailResult) {
                    return FALSE;
                }
                else {
                    return "member";
                }
            }
            else {
                return "admin";
            }
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
    
    function automatedPasswordReset($username, $role) {
        include '../mail/password_reset.php';
        $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
        $password = substr(str_shuffle($password_string), 0, 12);

        if (submitPassword($password, $username, $role)) {
            sendMail($username, $password);
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    function submitPassword($newPassword, $username, $role) {
        $table;
        $column;
        
        if ($role == "member") {
            $table = USER_CREDENTIAL_TABLE;
            $column = "MEMBER_EMAIL";
        }
        if ($role == "admin") {
            $table = USER_CREDENTIAL_TABLE2;
            $column = "EMAIL";
        }
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare(
                    'UPDATE ' . $table . ' SET PASSWORD = :submittedPassword 
                    WHERE ' . $column . ' = :submittedEmail');

            $accountInformationUpdate->execute(array(
                ':submittedPassword' => hashPassword($newPassword),
                ':submittedEmail' => $username
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
    
    // Outputs login form with username and password fields - passes to index.php
    function displayForm($status) {
        $errorBanner;
        
        if ($status == "nonexistant") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-warning'>
                    That user does not exist in our system.
                </div>";
        }
        elseif ($status == "verification_prob") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-warning'>
                    There has been a problem with our verification process. Please try again.
                </div>";
        }
        elseif ($status == "tech_diff") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-warning'>
                    There has been a problem with submission. Please try again.
                </div>";
        }
        elseif ($status == "incomplete") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-warning'>
                    Please make sure all fields are complete and try again.
                </div>";
        }
        elseif ($status == "success") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-success'>
                    An email with a temporary password has been sent to your email address.
                </div>";
        }
        
        echo '
            <div class="container">
                <div class="row-fluid">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="well bs-component">
                            <form class="form-horizontal" method="post" action="./" id="sign_in">
                                <fieldset>
                                    <legend style="font-weight: bold; color:#ffffff">PASSWORD RESET</legend>' . 
                                    $errorBanner . 
                                    '<div class="form-group">
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="Username" class="form-control" id="inputUsername" name="username" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAALZJREFUOBFjYKAANDQ0rGWiQD9IqzgL0BQ3IKMXiB8AcSKQ/waIrYDsKUD8Fir2pKmpSf/fv3+zgPxfzMzMSbW1tbeBbAaQC+b+//9fB4h9gOwikCAQTAPyDYHYBciuBQkANfcB+WZAbPP37992kBgIUOoFBiZGRsYkIL4ExJvZ2NhAXmFgYmLKBPLPAfFuFhaWJpAYEBQC+SeA+BDQC5UQIQpJYFgdodQLLyh0w6j20RCgUggAAEREPpKMfaEsAAAAAElFTkSuQmCC&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10">
                                            <div class="g-recaptcha" data-sitekey="6LfnWRgTAAAAAJbrj6wxghHWppYqZK59I02w64ij"></div>
                                        </div>
                                    </div><br />
                                    <div style="text-align: right">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <input type="hidden" name="submit" value="TRUE" />
                                            <input type="submit" class="btn btn-default" value="Reset" />
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>';
    }
?>