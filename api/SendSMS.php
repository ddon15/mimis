<?php

class SendSMS
{   
    public $regMail;
    public $regName;

    public $deviceId;
    public $options;
    public $number;
    public $message;

    public $connSmsGateway;

    /*
     * Build Dependencies
     */
    public function __construct(){
        // include '../Repository/SmsGateway.php';
        require_once dirname(__FILE__).'\../Repository/SmsGateway.php';

        $this->regMail = "joyjanetwins@gmail.com";
        $this->regName = "joyjane";
    
        $this->connSmsGateway = new SmsGateway($this->regMail, $this->regName);
    }
    //device ID
    public function getDeviceId(){
        $this->deviceId = 28113;
        return $this->deviceId;
    }
    //options
    public function getOptions(){
        $options = [
            'send_at' => strtotime('+1 minute'), // Send the message in 10 minutes
            'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
        ];
        $this->options = $options;
        return $this->options;
    }
    //number
    public function setNumber($number){
        $this->number = $number;
        return $this->number;
    }
    public function getNumber(){
        return $this->number;
    }
    //message
    public function setMessage($message){
        $this->message = $message;
        return $this->message;
    }
    public function getMessage(){
        return $this->message;
    }

    public function sendSMS(){
        
        $result = $this->connSmsGateway->sendMessageToNumber($this->getNumber(), $this->getMessage(), $this->getDeviceId(), $this->getOptions());
        return $result;
    }

}