<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// These paths must point to the 'src' folder as seen in your file explorer
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot spam protection
    if (!empty($_POST['honeypot'])) exit("Spam detected.");

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $fname = htmlspecialchars($_POST['first-name'] ?? '');
    $lname = htmlspecialchars($_POST['last-name'] ?? '');
    $msg   = htmlspecialchars($_POST['message'] ?? '');

    if (!$email || empty($fname) || empty($msg)) {
        exit("Please fill all required fields correctly.");
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.littlefeet.co.ke'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@littlefeet.co.ke';
        $mail->Password   = 'Littlefeet@2030';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('info@littlefeet.co.ke', 'Little Feet');
        $mail->addAddress('info@littlefeet.co.ke'); 
        $mail->addReplyTo($email, "$fname $lname");

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<b>Name:</b> $fname $lname<br><b>Email:</b> $email<br><br><b>Message:</b><br>" . nl2br($msg);

        $mail->send();
        echo 'Success! Your message has been sent.';
    } catch (Exception $e) {
        // This will tell us EXACTLY why the 500 error is happening
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>