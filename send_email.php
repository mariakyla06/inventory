<?php
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");

function sendEmployeeEmail($MAIL_TO, $PASSWORD, $RECEIVER_NAME){
    $mailTo = $MAIL_TO;

    $body = "   <h1>Welcome! $MAIL_TO</h1>
    <p>You have been successfully registered in our system. We're excited to have you on board!</p>
    <br> <hr>
    <p>This is you password: $PASSWORD</p>
    <br> <hr>
    <p>Best Regards,</p>
    <p>CVSU GENERAL TRIAS SUPPLY DEPARTMENT </p>";


    $mail = new PHPMailer\PHPMailer\PHPMailer();
    // $mail->SMTPDebug = 3;
    $mail->isSMTP();
    $mail->Host = "mail.smtp2go.com";
    $mail->SMTPAuth = true;

    $mail->Username = "supplyims.online";
    $mail->Password = "password";
    $mail->SMTPSecure = "tls";

    $mail->Port = "2525";
    $mail->From = "admin@supplyims.Online";
    $mail->FromName = "Cvsu Supply Department";
    $mail->addAddress($mailTo, $RECEIVER_NAME );

    $mail->isHTML('true');
    $mail->Subject = "Account Creation in SupplyIMS";
    $mail->Body = $body;
    $mail->AltBody = "Alt Body";

    if(!$mail->send()){
        return 500;
        // echo "Mailer Error :". $mail->ErrorInfo;
    }else{
        return 200;
        // echo "Message Sent";
    }
}


?>
