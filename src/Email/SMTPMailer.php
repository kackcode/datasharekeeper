<?php

namespace Kackcode\Datasharekeeper\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SMTPMailer
{

    private $mailer;

    public function __construct($host,$username,$password,$port)
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
        $this->mailer->Port = $port;
    }

    public function sendMail(string $to, string $subject, string $message, string $reply_to,$from,$from_name)
    {
        try {
            $this->mailer->setFrom($from, $from_name);
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
            $this->mailer->Body = $message;
            $this->mailer->addReplyTo($reply_to);

            return $this->mailer->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
