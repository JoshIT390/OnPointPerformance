<?php
    include "../../databaseInfo.php";
    
    $us_state_abbrevs = array("AK","AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","UT","VA","VI","VT","WA","WI","WV","WY");
    
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
    
    function displayAccountInformation($username, $us_state_abbrevs, $status) {
        $message = "";
        
        if ($status == "fail") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    A technical issue occurred during submission. Please try again.
                </div>";
        }
        if ($status == "fail_email") {
            $message = 
                "<div class='alert alert-dismissible alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    That email address has already been taken. Please try again with a different email address.
                </div>";
        }
        elseif ($status == "success") {
            $message = 
                "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    Account information successfully saved.
                </div>";
        }
        
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformation = $connection->prepare('SELECT FIRSTNAME, LASTNAME, ADDRESS, CITY, STATE, ZIP, PHONE, MEMBER_EMAIL, NOTES FROM ' . USER_CREDENTIAL_TABLE . 
                                                       ' WHERE MEMBER_EMAIL = :username');
            $accountInformation->bindParam(':username', $username);
            $accountInformation->execute();
            
            $accountInformationResult = $accountInformation->fetch();
            
            echo 
            '<div class="row-fluid">
                <div class="well bs-component">
                    <form method="post" action="./" id="account_update">
                        <legend style="font-weight: bold; color:#ffffff">ACCOUNT INFORMATION</legend>' . 
                        $message . 
                        '<div class="form-group row">
                            <label class="col-lg-2 control-label">First name </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" name="firstName" value="' . htmlentities($accountInformationResult[0], ENT_QUOTES) . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Last name </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" name="lastName" value="' . htmlentities($accountInformationResult[1], ENT_QUOTES) . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Address </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" name="address" value="' . htmlentities($accountInformationResult[2], ENT_QUOTES) . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">City </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" name="city" value="' . htmlentities($accountInformationResult[3], ENT_QUOTES) . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">State </label>
                            <div class="col-lg-6">
                                <select class="form-control" name="state">' . createStateAbbrevOptions($us_state_abbrevs, $accountInformationResult[4]) . '</select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Zip code </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="number" name="zip" value="' . $accountInformationResult[5] . '" maxlength="5" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Phone number </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="tel" name="phone" value="' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $accountInformationResult[6]) . '" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" maxlength="14" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Email </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="email" name="email" value="' . htmlentities($accountInformationResult[7], ENT_QUOTES) . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Notes </label>
                            <div class="col-lg-6">
                                <textarea class="form-control" rows="5" name="notes">' . $accountInformationResult[8] . '</textarea>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="submit" value="TRUE">
                            <input type="submit" value="Save changes" class="btn btn-default" />
                        </div>
                    </form>
                </div>
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
                FROM ' . ADMIN_CREDENTIAL_TABLE . ' 
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
                WHERE MEMBER_EMAIL LIKE :submittedEmail AND MEMBER_EMAIL != "' . $_SESSION['member_username'] . '"'
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
    
    function submitAccountInformation($username, $submittedFirstName, $submittedLastName, $submittedAddress, $submittedCity, $submittedState, $submittedZip, $submittedPhone, $submittedNotes, $submittedEmail) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('UPDATE ' . USER_CREDENTIAL_TABLE . ' SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, ADDRESS = :submittedAddress, City = :submittedCity, State = :submittedState, ZIP = :submittedZip, PHONE = :submittedPhone, NOTES = :submittedNotes, MEMBER_EMAIL = :submittedEmail 
                                                              WHERE MEMBER_EMAIL = :username');
            $accountInformationUpdate->execute(array(
                ':submittedFirstName' => $submittedFirstName,
                ':submittedLastName' => $submittedLastName,
                ':submittedAddress' => $submittedAddress,
                ':submittedCity' => $submittedCity,
                ':submittedState' => $submittedState,
                ':submittedZip' => $submittedZip,
                ':submittedPhone' => $submittedPhone,
                ':submittedNotes' => $submittedNotes,
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