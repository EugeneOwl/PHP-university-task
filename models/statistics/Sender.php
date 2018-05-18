<?php

header('Content-type: text/html; charset=utf-8');
$pathToBackground = "models/sender-background/";//home/eugene/PhpstormProjects/PHP-university-task/models/sender-background
require_once $pathToBackground . 'connection.php';
require_once $pathToBackground . 'class.phpmailer.php';
require_once $pathToBackground . 'Exception.php';
require_once $pathToBackground . 'class.smtp.php';

class Sender
{
    private $ownerEmail = "eugene271216@gmail.com";
    private $ownerPassword = "eugene1994";

    public function sendMail(string $receiver, string $message, string $senderName, string $topic): bool
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $this->ownerEmail;
        $mail->Password = $this->ownerPassword;

        $mail->setFrom($this->ownerEmail, $senderName);
        $mail->addAddress($receiver);

        $mail->Subject = $topic;
        $mail->Body = $message;
        $result = $mail->send();
        $mail->SmtpClose();
        return $result;
    }
}