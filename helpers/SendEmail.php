<?php
namespace coloco\helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmail{
    public static function sendEmail(string $reciever,string $subject,string $body):void{
        try{

    
            $mail = new PHPMailer(true);
            
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '830699f99d7a38';
            $mail->Password = '153833a9a6ce16';
        
            $mail->setFrom('team@coloco.com', 'Hamza Sehouli');           
            $mail->addAddress($reciever);
               
            // $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            
               
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}