<?php
    // Should be ../../ in prod
    require_once('../../../PHPMailer-master/PHPMailerAutoload.php');
    
    function sendMail($email, $password) {
        define("LOGIN_LINK", "https://dnguyen94.com/OnPointPerformance/login/");
        $mail = new PHPMailer();
        $sendStatus;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.dreamhost.com;sub5.dreamhost.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'support@dnguyen94.com';                 // SMTP username
        $mail->Password = 'd99TLcpi&FTv';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('support@dnguyen94.com', 'On Point Performance Center');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo('support@dnguyen94.com', 'On Point Performance Center');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Your password has been reset';
        $mail->Body    = 
                '<p>
                    Your username is: ' . $email . 
                '<p>
                    Your temporary password is: ' . $password . 
                '</p>
                <p>
                    Please log in using your temporary password at <a href="' . LOGIN_LINK . '">' . LOGIN_LINK . '</a> and change your password.
                </p>
                <p>
                    Thanks, <br />
                    On Point Performance Center
                </p>';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $sendStatus = FALSE;
        } 
        else {
            $sendStatus = TRUE;
        }
    }
