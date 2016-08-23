<?php 

include '../Repository/SmsGateway.php';

$smsGateway = new SmsGateway('joyjanetwins@gmail.com', 'joyjane');

$deviceID = 28113;
$number = '+639195532617';
$message = 'Testing!';

// $options = [];
$options = [
'send_at' => strtotime('+1 minute'), // Send the message in 10 minutes
'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
];

//Please note options is no required and can be left out
$result = $smsGateway->sendMessageToNumber($number, $message, $deviceID, $options);

echo '<pre>';
var_dump($result); 

$result2 = $smsGateway->getDevice($deviceID);
echo '<pre>';
var_dump($result2); 
