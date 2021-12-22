<?php

namespace App\Utils;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    private object $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function sendMail(array $data)
    {
        try {
            //Server settings
            $this->mail->setLanguage('fr');
            $this->mail->CharSet = 'UTF-8';
            $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
            $this->mail->isSMTP();
            $this->mail->Host       = 'mail.infomaniak.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'contact@jonathan-secher.site';
            $this->mail->Password   = 'veuYYhAvecHukMGrwHFRLWTWEnKbXTj8No5JKKK5f7MNbCYhJDWKAxaAiK5hmtyt';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port       = 465;

            //Recipients
            $this->mail->setFrom($data['email'], $data['firstname'] . ' ' . $data['lastname']);
            $this->mail->addAddress('secher.jonathan@gmail.com', 'Jonathan Secher');
            $this->mail->addReplyTo($data['email'], $data['fullname']);

            //Content
            $this->mail->isHTML(false);
            $this->mail->Subject = 'Contact - Blog JS';
            $this->mail->Body    = $data['message'];

            $this->mail->send();
            echo 'Message envoyé avec succès';
        } catch (Exception $e) {
            echo "Echec de l'envoi. Erreur : {$this->mail->ErrorInfo}";
        }
    }
}
