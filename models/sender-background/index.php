<?php

    header('Content-type: text/html; charset=utf-8');
    require_once 'connection.php';
    require 'class.phpmailer.php';
    require 'Exception.php';
    require 'class.smtp.php';

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "eugene271216@gmail.com";
    $mail->Password = "eugene1994";

    $mail->setFrom('eugene271216@gmail.com','Admin statistics page');
    $mail->addAddress('eugenevaleska1994@gmail.com');

    $mail->Subject = 'Statistics';
    $mail->Body = "Количество посещений страницы localhost/index.php за день: $count";
    echo '<br>';
    $result = $mail->send();
    echo $result ? "yes" : "no";
    $mail->SmtpClose();