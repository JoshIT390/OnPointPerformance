<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Apply</title>
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../">On Point Performance Center</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="../">Home</a></li>
                        <li><a href="../about/">About Us</a></li>
                        <li class="active"><a><span class="sr-only">(current)</span>Apply</a></li>
                        <li><a href="../events/">Events</a></li>
                        <li><a href="../merchandise/">Merchandise</a></li>
                        <li><a href="../contact/">Contact Us</a></li>
                    </ul>    
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if (isset($_SESSION['member_username'])){
                                echo '<li><a href="../members">' . $_SESSION['member_username'] . '</a></li>';
                                echo '<li><a href="../login/logout.php">Logout</a></li>';
                            }
                            if (isset($_SESSION['admin_username'])){
                                echo '<li><a href="../admin">' . $_SESSION['admin_username'] . '</a></li>';
                                echo '<li><a href="../login/logout.php">Logout</a></li>';                            
                            }
                            elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                echo '<li><a href="../login">Log In</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- 
        first name
        last name
        gender
        age (number)
        phone number
        email
        military background
            checkbox and comment box
        police background
            checkbox and comment box
        strength background
            checkbox and comment box
        degree/cert physical therapy's
            checkbox and comment box
        where do you train
        How often do you train
        what time do you train
        comment box for additional
        -->
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3"></div>
          <div class="col-lg-6">
              <?php 
                if ($_GET["success"] == true){
                    echo '<div class="alert alert-dismissible alert-success">
                            <strong>Success!</strong> Your application has been submitted.
                        </div>';
                }
              ?>
            <div class="well bs-component">
                <form class="form-horizontal" action="submitApp.php" method="post">
                <fieldset>
                <legend>Application for membership</legend>
                <!-- FIRST NAME -->
                <div class="form-group">
                    <label for="inputFirstName" class="col-lg-2 control-label">First Name</label>
                    <div class="col-lg-8">
                        <input type="text" name="firstName" class="form-control" id="inputFirstName" placeholder="First Name" required>
                    </div>
                </div>
                <!-- LAST NAME -->
                <div class="form-group">
                    <label for="inputLastName" class="col-lg-2 control-label">Last Name</label>
                    <div class="col-lg-8">
                        <input type="text" name="lastName" class="form-control" id="inputLastName" placeholder="Last Name" required>
                    </div>
                </div>
                <!-- GENDER -->
                <div class="form-group">
                    <label for="inputGender" class="col-lg-2 control-label">Gender</label>
                    <div class="col-lg-8">
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="inputGender" value="Male" checked="checked">
                                Male
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="inputGender" value="Female">
                                Female
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Age -->
                <div class="form-group">
                    <label for="inputAge" class="col-lg-2 control-label">Age</label>
                    <div class="col-lg-8">
                        <input type="text" name="age" class="form-control" id="inputAge" placeholder="" required>
                    </div>
                </div>
                <!-- Phone Number -->
                <div class="form-group">
                    <label for="inputPhone" class="col-lg-2 control-label">Phone Number</label>
                    <div class="col-lg-8">
                        <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="555-555-5555" required>
                    </div>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
                    <div class="col-lg-8">
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="example@example.com" required>
                    </div>
                </div>
                <!-- Military Background -->
                <div class="form-group">
                    <label for="isMilitary" class="col-lg-2 control-label">Military</label>
                    <div class="col-lg-8" style="text-align: left;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="isMilitary">Do You have a Military background? </label>
                        </div>
                        <label for="inputMilitary">If yes, what is your Military background?</label>
                        <textarea class="form-control" rows="3" id="inputMilitary" name="militaryBG"></textarea>
                    </div>
                </div>
                <!-- Law Enforcement Background -->
                <div class="form-group">
                    <label for="isLaw" class="col-lg-2 control-label">Law Enforcement</label>
                    <div class="col-lg-8">
                        <div class="checkbox">
                            <label><input type="checkbox" name="isLaw">Do You have a Law Enforcement background?</label>
                        </div>
                        <label for="inputLaw">If yes, what is your Law Enforcement background?</label>
                        <textarea class="form-control" rows="3" id="inputLaw" name="lawBG"></textarea>
                    </div>
                </div>
                <!-- Competitive Background -->
                <div class="form-group">
                    <label for="isStrength" class="col-lg-2 control-label">Strength</label>
                    <div class="col-lg-8">
                        <div class="checkbox">
                            <label><input type="checkbox" name="isStrength">Are you an competitive Strength Athlete?</label>
                        </div>
                        <label for="inputStrength">If yes, what is your Competitive Strength Training background</label>
                        <textarea class="form-control" rows="3" id="inputStrength" name="strengthBG"></textarea>
                    </div>
                </div>
                <!-- Health Background -->
                <div class="form-group">
                    <label for="hasDegree" class="col-lg-2 control-label">Health Knowledge</label>
                    <div class="col-lg-8">
                        <div class="checkbox">
                            <label><input type="checkbox" name="hasDegree">Do You have a Degree or Certification regarding sports health/training?</label>
                        </div>
                        <label for="inputDegree">If yes, what is your Degree or Certification?</label>
                        <textarea class="form-control" rows="3" id="inputDegree" name="healthBG"></textarea>
                    </div>
                </div>
                <!-- Current Training-->
                <div class="form-group">
                    <label for="currentTraining" class="col-lg-2 control-label">Current Training</label>
                    <div class="col-lg-8">
                        <label>Where do you currently train?</label>
                        <select multiple="" name="currentTraining" class="form-control" required>
                            <option value="Chain">Chain Gym</option>
                            <option value="Private">Private Gym</option>
                            <option value="Crossfit">Crossfit Gym</option>
                            <option value="Home">Home</option>
                            <option value="Military/Police">Military/Police Facility</option>
                        </select>
                    </div>
                </div>
                <!-- Training Days -->
                <div class="form-group">
                    <label for="trainDays" class="col-lg-2 control-label">How often do you train?</label>
                    <div class="col-lg-8">
                        <label>How many days do you usually train per week?</label>
                        <select multiple="" name="trainDays" class="form-control" required>
                            <option value="1-2">1-2</option>
                            <option value="3-4">3-4</option>
                            <option value="5-6">5-6</option>
                            <option value="Everyday">Everyday</option>
                        </select>
                    </div>
                </div>
                <!-- Training Hours -->
                <div class="form-group">
                    <label for="trainHours" class="col-lg-2 control-label">What time of the day do you train?</label>
                    <div class="col-lg-8">
                        <label>What time of day do you typically train</label>
                        <select multiple="" name="trainHours" class="form-control" required>
                            <option value="Morning">Morning (4am-10am)</option>
                            <option value="Midday">Midday (10am-4pm)</option>
                            <option value="Evening">Evening (4pm-10pm)</option>
                            <option value="Night">Night (10pm-4am)</option>
                        </select>
                    </div>
                </div>
                <!-- Additional Information -->
                <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">Additional Info</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" rows="3" id="textArea" name="additional"></textarea>
                    </div>
                </div>
                
                <div>
                    <input type='submit' value='Submit' class='btn btn-default'>
                </div>
            </form>  
        </div>
        </div>
        </div>
                <div class="col-lg-3"></div>
        </div>
        
        
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>
