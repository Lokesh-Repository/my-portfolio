<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$emailUsername = $_ENV['EMAIL_USERNAME'];
$emailPassword = $_ENV['EMAIL_PASSWORD'];



// Create a new PHPMailer instance
$mail = new PHPMailer(true);
$response = ['success' => false, 'message' => ''];

try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $emailUsername;
    $mail->Password   = $emailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('wesoft.rf.gd@gmai.com', 'Lokesh');
    $recipientEmail = $_POST['sendresumeemail'];
    $mail->addAddress($recipientEmail);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Lokesh Resume';
    $mail->Body    = 'Dear User, <br><br>Thanks For Considering My Resume To The Post.! I Am Personally Glad To Share You My Resume Soon.<br><br>Best regards,<br>Lokesh<br><br>NOTE:This Is An Automated Email The Actuall Resume Will Be Sent Soon In An Separate Email.';

    $mail->send();
    $response['success'] = true;
    $response['message'] = 'Kindlly Check Your Inbox Please.';
    header("Location: index.html");
    exit;
} catch (Exception $e) {
    $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
