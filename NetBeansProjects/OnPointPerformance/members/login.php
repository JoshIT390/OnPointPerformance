<?php
    define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    define("USER_CREDENTIAL_TABLE", "MEMBER_ACCOUNT");

    // If first time logging in or inputted incorrect credentials
    if (!isset($_SESSION["member_username"]) && !isset($_SESSION["member_password"])) {
        if (!isset($_POST["username"]) && !isset($_POST["password"])) {
            echo outputLoginForm() . "\n";
        }
        else {
            // Saves username and password to session cookie if inputted correctly
            if (checkLogin(trim($_POST["username"]), $_POST["password"])) {
                $_SESSION['member_username'] = trim($_POST["username"]);
            }
            // Error if not inputted correctly
            else {
                echo "
                <div>
                    Your username or password is incorrect. Please re-enter your credentials.
                </div>" . outputLoginForm() . "\n";
            }
        }   
    }
    
    // Outputs login form with username and password fields - passes to index.php
    function outputLoginForm() {
        return '
        <div>
            <form method="post" action="./" id="sign_in">
                <div>
                    Username <input type="text" name="username" /><br /><br />
                    Password <input type="password" name="password" /><br /><br />
                    <input type="submit" value="Login" />
                </div>
            </form>
        </div>';
    }

    // Checks inputted credentials against credentials in database, throws error if there's a login/connection issue
    function checkLogin($username, $password) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $passwordQuery = $connection->prepare('SELECT PASSWORD FROM ' . USER_CREDENTIAL_TABLE . ' WHERE MEMBER_EMAIL = :username');
            $passwordQuery->execute(array('username' => $username));
            
            $passwordResult = $passwordQuery->fetch();
            // If no matches

            if (!$passwordResult) {
                return FALSE;
            }
            else {
                // Checks to see if applying hashed password as salt onto inputted password and hashing equals to hashed password
                if (crypt($password, $passwordResult[0]) === $passwordResult[0]) {
                    return TRUE;
                }
                else {
                    return FALSE;
                }
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
?>