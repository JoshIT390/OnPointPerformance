<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    
    
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
    $email = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $militaryComments = $_POST["militaryBG"];
    $lawComments = $_POST["lawBG"];
    $strengthComments = $_POST["strengthBG"];
    $currentPlace = $_POST["currentTraining"];
    $days = $_POST["trainDays"];
    $hours = $_POST["trainHours"];
    $healthComments = $_POST["healthBG"];
    $additional = $_POST["additional"];
    
    
    try{
        $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
        // Exceptions fire when occur
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $submitApplication = $connection->prepare('
            INSERT INTO APPLICATIONS (FIRSTNAME, LASTNAME, PHONE, EMAIL, AGE, GENDER, MILITARY_BG, MILITARY_BG_COMMENTS, 
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
        
        header('Location: ' . $_SERVER['HTTP_REFERER']. '?success=true');
    }
    catch(PDOException $e) {
        echo "<div>
                Error: " . $e->getMessage() . 
            "</div>";
            
        return FALSE;
    }