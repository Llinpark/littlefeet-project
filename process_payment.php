<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if ($data['status'] === 'COMPLETED') {
    $log = "User: " . $data['name'] . " | Amount: " . $data['amount'] . " | ID: " . $data['id'] . PHP_EOL;
    file_put_contents('donations.txt', $log, FILE_APPEND);
    echo json_encode(["message" => "Payment logged successfully"]);
}
?>