<?php
    include "../../../databaseInfo.php";
    
    function displayAccountInformation($username, $status) {
        $message;

        if ($status == "success") {
            $message = 
                '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Account information successfully updated.
                </div>';
        }        
        elseif ($status == "fail_email") {
            $message = 
                '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    There was a problem saving the account information. Please select a different email address and try again.
                </div>';
        }
        elseif ($status == "fail") {
            $message = 
                '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    There was a problem saving the account information. Please try again.
                </div>';
        }
        
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformation = $connection->prepare('SELECT FIRSTNAME, LASTNAME, EMAIL FROM ' . ADMIN_CREDENTIAL_TABLE . ' WHERE EMAIL = :username');
            $accountInformation->bindParam(':username', $username);
            $accountInformation->execute();
            
            $accountInformationResult = $accountInformation->fetch();
            
            echo 
            $message . 
            '<div>
                    <form method="post" action="./" id="account_update">
                        <div>
                            First name: <input type="text" name="firstName" value="' . htmlentities($accountInformationResult[0], ENT_QUOTES) . '" required/><br /><br />
                            Last name: <input type="text" name="lastName" value="' . htmlentities($accountInformationResult[1], ENT_QUOTES) . '" required/><br /><br />
                            Email: <input type="email" name="email" value="' . htmlentities($accountInformationResult[2], ENT_QUOTES) . '" required/><br /><br />
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
        
        return TRUE;
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
                FROM ' . ADMIN_CREDENTIAL_TABLE . ' 
                WHERE EMAIL LIKE :submittedEmail AND EMAIL != "' . $_SESSION['admin_username'] . '"'
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
            
            return FALSE;
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
    
    function submitAccountInformation($username, $submittedFirstName, $submittedLastName, $submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . ADMIN_CREDENTIAL_TABLE . ' SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, EMAIL = :submittedEmail WHERE EMAIL = :username');
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
        
        return TRUE;
    }