<?php 
    function displayForm() {
        echo 
        '<div class="container">
            <div class="row" style="text-align: center;">
                <div class="col-lg-8">
                    <div class="well bs-component">
                        <form class="form-horizontal" method="post" action="./" id="contact_form">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputName" class="col-lg-2 control-label">
                                        Your name
                                    </label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">
                                        Your email
                                    </label>
                                    <div class="col-lg-5">
                                        <input type="email" class="form-control" name="email" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label">
                                        Your message
                                    </label>
                                    <div class="col-lg-5">
                                        <textarea name="message" class="form-control" rows="4" cols="5" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label"></label>
                                    <div class="col-lg-5">
                                        <div class="g-recaptcha" data-sitekey="6LfnWRgTAAAAAJbrj6wxghHWppYqZK59I02w64ij"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" for="inputEmail" class="col-lg-2 control-label">
                                        <input type="hidden" name="submit" value="TRUE" />
                                        <input type="submit" class="btn btn-primary" value="Send" />
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
    
    function isValid($captcha) {
        $secret = "6LfnWRgTAAAAAOjb5kqADRu_BPY-Ez7KLZwlF7mH";
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret .'&response=' . $captcha);
        $responseData = json_decode($verifyResponse);
        
        if($responseData->success) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function submitEmail($name, $email, $message) {
        include '../mail/contact_form.php';
        
        $detailedMessage = 
                "<b>Name:</b> " . $name . "<br />
                <b>Email:</b> " . $email . "<br /><br />
                <b>Message:</b> <br />" . 
                nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
        
        return sendEmail($name, $email, $detailedMessage);
    }
