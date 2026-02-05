<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// 1. SETTINGS - Replace with your REAL credentials from Daraja
$consumerKey = 'YOUR_CONSUMER_KEY'; 
$consumerSecret = 'YOUR_CONSUMER_SECRET';
$BusinessShortCode = '174379'; // Sandbox default
$Passkey = 'YOUR_PASSKEY';

// 2. FORMAT PHONE NUMBER (Converts 07... to 2547...)
$phone = $data['phone'];
if (strpos($phone, '0') === 0) {
    $phone = '254' . substr($phone, 1);
}

$amount = $data['amount'];
$timestamp = date('YmdHis');
$password = base64_encode($BusinessShortCode . $Passkey . $timestamp);

// 3. GET ACCESS TOKEN
$curl = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
$result = json_decode(curl_exec($curl));
$access_token = $result->access_token;

// 4. INITIATE STK PUSH
$stk_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$payload = [
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $phone,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $phone,
    'CallBackURL' => 'https://yourdomain.com/callback.php',
    'AccountReference' => 'LittleFeet',
    'TransactionDesc' => 'Donation'
];

$curl = curl_init($stk_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Authorization:Bearer '.$access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($curl);
echo $response; // This shows you Safaricom's exact error message
?>