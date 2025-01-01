<?php

namespace Kackcode\Datasharekeeper\Email;

class Mailer
{
    public static function sendMail(string $from, string $to, string $subject, string $replyTo, string $message): bool
    {
        $headers = "From: $from\r\n";
        $headers .= "Reply-To: " . strip_tags($replyTo) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($to, $subject, $message, $headers);
    }
}
