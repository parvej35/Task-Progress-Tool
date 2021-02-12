<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include 'PHPMailer/src/Exception.php';
    include 'PHPMailer/src/PHPMailer.php';
    include 'PHPMailer/src/SMTP.php';

    include 'MailBodyHTMLContent.php';

    class Email {

        function buildMailAndSend($receiver_name, $receiver_email, $page_url, $mail_type, $data) {

            $isSent = false;

            $mailBodyHTMLContent = new MailBodyHTMLContent();

            // Instantiation and passing [ICODE]true[/ICODE] enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Set mailer to use SMTP

                $mail->SMTPDebug = 0;
                // 0 = off (for production use, No debug messages)
                // 1 = client messages
                // 2 = client and server messages

                //$mail->Host       = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
                $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers

                $mail->SMTPAuth   = "true";                                   // Enable SMTP authentication

                $mail->SMTPSecure = 'ssl';

//                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
//                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                $mail->Port       = 465;                                    // SSL port to connect to
//              $mail->Port       = 587;                                    // TCP port to connect to

                $mail->Username   = 'horekhobor@gmail.com';                     // SMTP username
                $mail->Password   = 'mail@8793';                               // SMTP password

                //Recipients
                $mail->setFrom('horekhobor@gmail.com', 'Task Progress Tool');
                $mail->addAddress($receiver_email, $receiver_name);     // Add a recipient
//                 $mail->addAddress("'".$receiver_email."'");               // Name is optional
//                 $mail->addAddress('parvej35@yahoo.com');               // Name is optional
                // $mail->addReplyTo('technovalleyit@gmail.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // Attachments
                //$mail->addAttachment('/home/cpanelusername/attachment.txt');         // Add attachments
                //$mail->addAttachment('/home/cpanelusername/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML

                if($mail_type == "ACCOUNT_ACTIVATION") { //send mail to registered user after signup to activate the account

                    $mail->Subject = 'Verify Your Account';
                    $mail->Body    = $mailBodyHTMLContent->generateAccountVerificationMailBodyTemplate($receiver_name, $page_url);

                } else if($mail_type == "RECHARGE_VERIFICATION") { //send mail to admin when a new recharge information added

                    $mail->Subject = 'New Recharge Information';
                    $mail->Body    = $mailBodyHTMLContent->generateRechargeVerificationMailBodyTemplate($page_url, $data);

                } else if($mail_type == "ACCOUNT_CREATION_NOTICE") { //send mail to admin when a new account created

                    $mail->Subject = "New User Registered [".$data['name']."]";
                    $mail->Body    = $mailBodyHTMLContent->generateUserRegistrationNotificationMailBodyTemplate($page_url, $data);

                }

                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if($mail->send()) {
                   $isSent = true;
                } else {
                    $isSent = false;
                }

                $mail->smtpClose();

            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $isSent = false;
                $mail->smtpClose();
            }

            return $isSent;

            //return $mailBodyHTMLContent->generateMailBodyTemplate();
        }

    }