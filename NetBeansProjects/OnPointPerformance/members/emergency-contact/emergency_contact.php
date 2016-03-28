<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");
    define("USER_EMERGENCY_CONTACT_TABLE", "MEMBER_EMERGENCY_CONTACTS");
    
    $relationships = array('Spouse or Significant Other', 'Parent/Guardian', 'Son/Daughter', 'Sibling', 'Friend');
    
    // Create dropdown of states with user's state pre-selected
    function createRelationshipsOptions($relationships, $emergencyContactRelationship) {
        $relationshipsOptions;
                
        foreach ($relationships as &$relationship) {
            if ($relationship == $emergencyContactRelationship) {
                $relationshipsOptions .= '<option value="' . $relationship . '" selected>' . $relationship . '</option>';
            }
            else {
                $relationshipsOptions .= '<option value="' . $relationship . '">' . $relationship . '</option>';
            }
        }
        
        return $relationshipsOptions;
    }

    function displayEmergencyContact($username, $relationships) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $emergencyContactQuery = $connection->query('
                SELECT ME.FIRSTNAME, ME.LASTNAME, ME.PHONE, ME.RELATIONSHIP, ME.EMERGENCY_CONTACT_ID 
                FROM ' . USER_CREDENTIAL_TABLE . ' M INNER JOIN ' . USER_EMERGENCY_CONTACT_TABLE . ' ME ON ME.MEMBER_ID = M.MEMBER_ID
                WHERE M.MEMBER_EMAIL = '. $connection->quote($username)
            );
            
            $emergencyContact = $emergencyContactQuery->fetch();

            echo 
            '<div class="row-fluid">
                <div class="well bs-component">
                <form method="post" action="./" id="emergency_contact_update">
                    <div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">First name</label>
                            <div class="col-lg-8">
                                <input type="text" name="firstName" value="' . $emergencyContact[0] . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Last name</label>
                            <div class="col-lg-8">
                                <input type="text" name="lastName" value="' . $emergencyContact[1] . '" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Phone number</label>
                            <div class="col-lg-8">
                                <input type="tel" name="phone" value="' . $emergencyContact[2] . '" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" maxlength="13" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Relationship</label>
                            <div class="col-lg-8">
                                <select name="relationship">' . createRelationshipsOptions($relationships, $emergencyContact[3]) . '</select>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="emergencyContactID" value="' . $emergencyContact[4] . '" />   
                            <input type="hidden" name="submit" value="TRUE" />
                            <input type="submit" value="Save changes" />
                        </div>
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
    
    function submitEmergencyContact($submittedFirstName, $submittedLastName, $submittedPhone, $submittedRelationship, $emergencyContactID) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $accountInformationUpdate = $connection->prepare('
                UPDATE ' . USER_EMERGENCY_CONTACT_TABLE . ' 
                SET FIRSTNAME = :submittedFirstName, LASTNAME = :submittedLastName, PHONE = :submittedPhone, RELATIONSHIP = :submittedRelationship 
                WHERE EMERGENCY_CONTACT_ID = :emergencyContactID'
            );
            
            $accountInformationUpdate->execute(array(
                ':submittedFirstName' => $submittedFirstName,
                ':submittedLastName' => $submittedLastName,
                ':submittedPhone' => $submittedPhone,
                ':submittedRelationship' => $submittedRelationship,
                ':emergencyContactID' => $emergencyContactID
            ));
        }
        
        // Script halts and throws error if exception is caught
        catch(PDOException $e) {
            echo "
            <div>
                Error2: " . $e->getMessage() . 
            "</div>";
            
            return FALSE;
        }
    }