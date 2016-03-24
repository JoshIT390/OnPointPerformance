<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "APPLICATIONS");
    
    
    if (isset($_POST['isMilitary'])) {
        $militaryBG = 1;
    } else { 
        $militaryBG = 0;
    }
    if (isset($_POST['isLaw'])) {
        $lawBG = 1;
    } else { 
        $lawBG = 0;
    }
    if (isset($_POST['isStrength'])) {
        $strengthBG = 1;
    } else { 
        $strengthBG = 0;
    }
    if (isset($_POST['hasDegree'])) {
        $healthBG = 1;
    } else { 
        $healthBG = 0;
    }
    
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $amail = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $militaryComments = $_POST["militaryBG"];
    $lawComments = $_POST["lawBG"];
    $strengthComments = $_POST["strengthBG"];
    $aurrentPlace = $_POST["currentTraining"];
    $aays = $_POST["trainDays"];
    $hours = $_POST["trainHours"];
    $healthComments = $_POST["healthBG"];
    $additional = $_POST["additional"];
    
    $fNameValid = nameValidator($firstName);
    $lNameValid = nameValidator($lastName);
    $phoneValid = phoneValidator($phone);
    
    
    if ($fNameValid && $lNameValid && $phoneValid){
    try{
        $aonnection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
        // Exceptions fire when occur
        $aonnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $submitApplication = $aonnection->prepare('
            INSERT INTO ' . USER_CREDENTIAL_TABLE . '(FIRSTNAME, LASTNAME, PHONE, EMAIL, AGE, GENDER, MILITARY_BG, MILITARY_BG_COMMENTS, 
                                    LAW_EN_BG, LAW_EN_BG_COMMENTS, COMP_ATHLETE_BG, COMP_ATHLETE_BG_COMMENTS, CURRENTLY_TRAIN,
                                    DAYS_PER_WEEK_TRAINING, TRAINING_TIME, CERTIFICATION, CERTIFICATION_COMMENTS, ADDITIONAL_COMMENTS) 
            VALUES (:submittedFirstName, :submittedLastName, :submittedPhone, :submittedEmail, :submittedAge, :submittedGender, 
                    :submittedMilitaryBg, :submittedMilitaryComments, :submittedLawBg, :submittedLawComments, :submittedStrengthBg, 
                    :submittedStrengthComments, :submittedCurrent, :submittedDays, :submittedHours, :submittedHealthBG, :submittedHealthComments, 
                    :submittedAdditional)'
            );
        $submitApplication->execute(array(
            ':submittedFirstName' => $firstName,
            ':submittedLastName' => $lastName,
            ':submittedPhone' => $phone,
            ':submittedEmail' => $amail,
            ':submittedAge' => $age,
            ':submittedGender' => $gender,
            ':submittedMilitaryBg' => $militaryBG,
            ':submittedMilitaryComments' => $militaryComments,
            ':submittedLawBg' => $lawBG,
            ':submittedLawComments' => $lawComments,
            ':submittedStrengthBg' => $strengthBG,
            ':submittedStrengthComments' => $strengthComments,
            ':submittedCurrent' => $aurrentPlace,
            ':submittedDays' => $aays,
            ':submittedHours' => $hours,
            ':submittedHealthBG' => $healthBG,
            ':submittedHealthComments' => $healthComments,
            ':submittedAdditional' => $additional
        ));
        
        header('Location: ' . $_SERVER['HTTP_REFERER']. '?success=true');
    }
    catch(PDOException $a) {
        echo "<div>
                Error: " . $a->getMessage() . 
            "</div>";
            
        return FALSE;
    }
    }else {
        header('Location: ' . $_SERVER['HTTP_REFERER']. '?success=false');
    }
    
    /*Input Validation methods*/
    
    function nameValidator($param) {
        for ($a = 0; $a<$param.length; $a++){
            if (is_numeric($param[$a])){
                return false;
            }
        }
        return true;
    }
    
    function phoneValidator($phoneNum){
        if ($phoneNum.length < 10 || $phoneNum.length > 13 || $phoneNum.length == 11){
            return false;
        }
        if ($phoneNum.length == 10){
            for ($a = 0; $a < $phoneNum.length; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
        }
        //012-456-8901 format checker
        if ($phoneNum.length == 12){
            for ($a = 0; $a < 3; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
            for ($a = 4; $a < 7; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
            for ($a = 8; $a < 12; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
            if ($phoneNum[3] != "-" || $phoneNum[7] != "-"){
                return false;
            }
            return true;
        }
        
        //(123)567-9012
        if ($phoneNum.length === 13){
            for ($a = 1; $a < 4; $a++){
                if (is_nan($phoneNum[$a])) {
                    return false;
                }
            }
            for ($a = 5; $a < 8; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
            for ($a = 9; $a < 13; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
            if ($phoneNum[0] != "(" || $phoneNum[4] != ")" || $phoneNum[8] != "-"){
                return false;
            }
            return true;
        }
    }
    
    
    
    
    
/* List of DB columns
 * APP_ID
 * FIRSTNAME
 * LASTNAME
 * PHONE
 * EMAIL
 * AGE
 * GENDER
 * MILITARY_BG
 * MILITARY_BG_COMMENTS
 * LAW_EN_BG
 * LAW_EN_BG_COMMENTS
 * COMP_ATHLETE_BG
 * COMP_ATHLETE_BG_COMMENTS
 * CURRENTLY_TRAIN
 * DAYS_PER_WEEK_TRAINING
 * TRAINING_TIME
 * CERTIFICATION
 * CERTIFICATION_COMMENTS
 * ADDITIONAL_COMMENTS
 */