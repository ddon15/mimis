<?php 

include '../Repository/SmsGateway.php';

// $smsGateway = new SmsGateway('joyjanetwins@gmail.com', 'joyjane');

// $deviceID = 28113;
// $number = '+639195532617';
// $message = 'Testing!';

$smsGateway = new SmsGateway('mardz_zuinky@yahoo.com', 'mariden20');

$deviceID = 28186;
$number = '+639330010744';
$message = 'Hello Marda! Your requested overtime for tomorrow has been approved.';

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
