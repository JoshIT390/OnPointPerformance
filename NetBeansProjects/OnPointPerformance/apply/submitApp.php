<?php
    include "../databaseInfo.php";
    
    /* Using session to pass variables */
    if(session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    
    /* Reset Errors if there was previous attempt 
    if(isset($_SESSION['appErrors'])){
        $_SESSION['appErrors'] = NULL;
    }*/
    
    /* convert checkbox selection into tiny int to match DB*/
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
    
    /* get input data from post*/
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $age = intval($_POST["age"]);
    $gender = $_POST["gender"];
    $militaryComments = $_POST["militaryBG"];
    $lawComments = $_POST["lawBG"];
    $strengthComments = $_POST["strengthBG"];
    $currentPlace = $_POST["currentTraining"];
    $days = $_POST["trainDays"];
    $hours = $_POST["trainHours"];
    $healthComments = $_POST["healthBG"];
    $additional = $_POST["additional"];
    
    /* Check for valid input */
    $fNameValid = nameValidator($firstName);
    $lNameValid = nameValidator($lastName);
    $phoneValid = phoneValidator($phone);
    $ageValid = ageValidator($age);
    
    
    if ($fNameValid && $lNameValid && $phoneValid && $ageValid){
        try{
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $submitApplication = $connection->prepare('
                INSERT INTO ' . APPLICATIONS_TABLE . '(FIRSTNAME, LASTNAME, PHONE, EMAIL, AGE, GENDER, MILITARY_BG, MILITARY_BG_COMMENTS, 
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
                ':submittedEmail' => $email,
                ':submittedAge' => $age,
                ':submittedGender' => $gender,
                ':submittedMilitaryBg' => $militaryBG,
                ':submittedMilitaryComments' => $militaryComments,
                ':submittedLawBg' => $lawBG,
                ':submittedLawComments' => $lawComments,
                ':submittedStrengthBg' => $strengthBG,
                ':submittedStrengthComments' => $strengthComments,
                ':submittedCurrent' => $currentPlace,
                ':submittedDays' => $days,
                ':submittedHours' => $hours,
                ':submittedHealthBG' => $healthBG,
                ':submittedHealthComments' => $healthComments,
                ':submittedAdditional' => $additional
            ));
            
            /* Sets form errors to not show errors on valid submit, after an invalid submit */
            if (isset($_SESSION['appErrors'])){
                $errorArray = [
                    "fNameError" => $fNameValid,
                    "lNameError" => $lNameValid,
                    "phoneError" => $phoneValid,
                    "ageError" => $ageValid
                ];
        
                $_SESSION['appErrors'] = $errorArray;
            }
            header('Location: https://dnguyen94.com/OnPointPerformance/apply/index.php?success=true');
        }catch(PDOException $e) {
            echo "<div>
                    Error: " . $e->getMessage() . 
                "</div>";
            
            return FALSE;
        }
    }else {
        /* Make an array for correct/incorrect values*/
        $errorArray = [
            "fNameError" => $fNameValid,
            "lNameError" => $lNameValid,
            "phoneError" => $phoneValid,
            "ageError" => $ageValid
        ];
        
        
        $_SESSION['appErrors'] = $errorArray;
        
        header('Location: https://dnguyen94.com/OnPointPerformance/apply/index.php?success=false');
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
        /*
        $valid = false;
        if ($phoneNum.length < 10 || $phoneNum.length > 13 || $phoneNum.length == 11){
            return false;
        }
        
        if ($phoneNum.length === 10){
            $valid = phoneNum10($phoneNum);
        }
        
        if ($phoneNum.length === 12){
            $valid = phoneNum12($phoneNum);
        }
        
        if ($phoneNum.length === 13){
            $valid = phoneNum13($phoneNum);
        }
        return $valid;
         */
        
        if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phoneNum ) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function phoneNum10($phoneNum){
        if ($phoneNum.length == 10){
            for ($a = 0; $a < $phoneNum.length; $a++){
                if (is_nan($phoneNum[$a])){
                    return false;
                }
            }
        }
    }
    /*
    function phoneNum12($phoneNum){
        //123-567-9012
        if ($phoneNum.length == 12){
            for ($a = 0; $a < 3; $a++){
                if (is_nan($phoneNum[$a])){return false;}
            }
            for ($b = 4; $b < 7; $b++){
                if (is_nan($phoneNum[$b])){return false;}
            }
            for ($c = 8; $c < 12; $c++){
                if (is_nan($phoneNum[$c])){return false;}
            }
            if ($phoneNum[3] != '-' || $phoneNum[7] != '-'){
                return false;
            }
            return true;
        }
    }
    
    function phoneNum13($phoneNum){
        //(123)567-9012
        if ($phoneNum.length === 13){
            for ($a = 1; $a < 4; $a++){
                if (is_nan($phoneNum[$a])) {return false;}
            }
            for ($b = 5; $b < 8; $b++){
                if (is_nan($phoneNum[$b])){return false;}
            }
            for ($c = 9; $c < 13; $c++){
                if (is_nan($phoneNum[$c])){return false;}
            }
            if ($phoneNum[0] != '(' || $phoneNum[4] != ')' || $phoneNum[8] != '-'){
                return false;
            }
            return true;
        }
    }
    */
    function ageValidator($ageNum) {
        if ($ageNum < 1 || $ageNum > 99){
            return false;
        }
        return true;
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