<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// NO composer / vendor
require_once __DIR__ . "/PHPMailer/Exception.php";
require_once __DIR__ . "/PHPMailer/PHPMailer.php";
require_once __DIR__ . "/PHPMailer/SMTP.php";

function tb_send_mail($toEmail, $toName, $subject, $htmlBody){
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;

        // sender gmail
        $mail->Username   = "itachiuchiha01635241@gmail.com";

        // app password (16 digit) 
        $mail->Password   = "zfgy ppnx jgmh xaij";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom("itachiuchiha01635241@gmail.com", "TradeBayOTP");
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;

        // actually send
        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}
