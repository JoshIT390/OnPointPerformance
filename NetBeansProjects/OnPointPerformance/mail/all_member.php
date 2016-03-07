<?php
    // Should be ../ in prod
    require_once('../../../PHPMailer-master/PHPMailerAutoload.php');
   
    function sendEmail($emailAddress, $subject, $message) {
        $mail = new PHPMailer();
        $sendStatus;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.dreamhost.com;sub5.dreamhost.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@dnguyen94.com';                 // SMTP username
        $mail->Password = '!P1%r403E*0!';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('noreply@dnguyen94.com', 'OnPoint Performance Center');
        $mail->addAddress($emailAddress);     // Add a recipient
        $mail->addReplyTo('noreply@dnguyen94.com', 'OnPoint Performance Center');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if(!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return FALSE;
        } 
        else {
            return TRUE;
        }
    }
