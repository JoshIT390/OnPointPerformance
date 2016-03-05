<?php
    // Should be ../ in prod
    require_once('../../PHPMailer-master/PHPMailerAutoload.php');
   
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
    $mail->addAddress('rhww.dman@gmail.com', 'Dan Nguyen');     // Add a recipient
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $sendStatus = FALSE;
    } 
    else {
        $sendStatus = TRUE;
    }
