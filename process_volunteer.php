<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Point directly to your src folder instead of vendor
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hp_field'])) exit("Spam detected.");

    $name    = htmlspecialchars($_POST['volunteer-name']);
    $email   = filter_var($_POST['volunteer-email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['volunteer-subject']);
    $msg     = htmlspecialchars($_POST['volunteer-message']);
    
    $file = $_FILES['volunteer-cv'];
    $upload_dir = "uploads/cvs/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $path = $upload_dir . time() . "_" . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $path)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'mail.littlefeet.co.ke'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'volunteer@littlefeet.co.ke';
            $mail->Password   = 'Volunteer@2030';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('volunteer@littlefeet.co.ke', 'Little Feet');
            $mail->addAddress('volunteer@littlefeet.co.ke');
            $mail->addAttachment($path);

            $mail->isHTML(true);
            $mail->Subject = "Volunteer: $subject";
            $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><p>$msg</p>";

            $mail->send();
            echo "Success! Your application has been sent.";
        } catch (Exception $e) {
            echo "Email error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Upload failed. Check folder permissions.";
    }
}
?>