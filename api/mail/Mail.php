<?php

include_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail
{
    private static $instance;
    private $client;

    private function __construct()
    {
        $configFile = __DIR__.'/config.php';
        if(!file_exists($configFile)){
            throw new \Exception('Config file not found');
        }

        $config = include $configFile;
        $this->iniClient($config);

    }

    private function iniClient($config)
    {
        if(!$this->client){
            $this->client = new PHPMailer();
            $this->client->CharSet = 'UTF-8';

            // Настройки SMTP
            $this->client->isSMTP();
            $this->client->SMTPAuth = true;
            $this->client->SMTPDebug = intval($config['debug']) ?? 0;

            $this->client->Host = $config['host'];
            $this->client->Port = $config['port'];
            $this->client->Username = $config['login'];
            $this->client->Password = $config['password'];

            $this->client->setFrom('no-reply@ostrovfortov.com', 'Остров фортов');

        }
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function send($to, $subject, $message, $bcc = '')
    {
        $this->client->clearAddresses();
        if(is_array($to)){
            foreach ($to as $address) {
                $this->client->addAddress($address);
            }
        } else {
            $this->client->addAddress($to);
        }

        if($bcc){
            if(is_array($bcc)){
                foreach ($bcc as $address) {
                    $this->client->addBCC($address);
                }
            } else {
                $this->client->addBCC($bcc);
            }
        }

        $this->client->Subject = $subject;

        $this->client->msgHTML($message);

        return $this->client->send();

    }

}