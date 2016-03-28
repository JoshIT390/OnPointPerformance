<?php
    // Should be ../../ in prod
    require_once('../../../PHPMailer-master/PHPMailerAutoload.php');
    
    function sendAuditAlert($newUser, $newUserEmail, $newUserRole, $creationTime, $admin) {
        $mail = new PHPMailer();
        $sendStatus;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.dreamhost.com;sub5.dreamhost.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'audit-noreply@dnguyen94.com';                 // SMTP username
        $mail->Password = '2!sNtMmA';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('audit-noreply@dnguyen94.com', 'On Point Performance Center');
        $mail->addAddress('admin@dnguyen94.com');     // Add a recipient
        $mail->addReplyTo('audit-noreply@dnguyen94.com', 'On Point Performance Center');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'New user added';
        $mail->Body    = 
                '<p>'
                     . $newUser . ' (' . $newUserEmail . ') has been added as a/an ' . $newUserRole . ' by ' . $admin . '.' . 
                '</p>
                <p>
                    <small>' . $creationTime . '</small>
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
