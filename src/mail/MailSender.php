<?php
require 'PHPMailer/PHPMailerAutoload.php';

class MailSender
{

    private $mail = null;

    /**
     * MailSender constructor.
     * @param $sender
     * @param $sender_pass
     */
    function __construct($sender, $sender_pass)
    {
        try {
            $this->mail = new PHPMailer();
            $this->mail->IsSmtp();
            $this->mail->SMTPDebug = 0;
            $this->mail->SMTPAuth = true;
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Host = "mail.stuba.sk";
            $this->mail->Port = 587;
            $this->mail->Username = $sender;
            $this->mail->Password = $sender_pass;
            $this->mail->SetFrom($sender);
            $this->mail->Encoding = 'base64';
            $this->mail->CharSet = 'utf-8';
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @return bool
     */
    function send($to, $subject, $message)
    {
        try {
            $this->mail->IsHTML(false);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->AddAddress($to);
            return $this->mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            return false;
        }
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @return bool
     */
    function sendHTML($to, $subject, $message)
    {
        try {
            $this->mail->IsHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->AddAddress($to);
            return $this->mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            return false;
        }
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $path
     * @param $name
     * @return bool
     */
    function send_attachment($to, $subject, $message, $path, $name)
    {
        try {
            $this->mail->IsHTML(false);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->AddAddress($to);
            $this->mail->addAttachment($path, $name);

            return $this->mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            return false;
        }
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $path
     * @param $name
     * @return bool
     */
    function sendHTML_attachment($to, $subject, $message, $path, $name)
    {
        try {
            $this->mail->IsHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->AddAddress($to);
            $this->mail->addAttachment($path, $name);

            return $this->mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            return false;
        }
    }

    /**
     * @return string
     */
    function getError()
    {
        return $this->mail->ErrorInfo;
    }

    /**
     * @param $sender
     * @param $sender_pass
     */
    function setSender($sender, $sender_pass)
    {
        $this->mail->Username = $sender;
        $this->mail->Password = $sender_pass;
    }
}