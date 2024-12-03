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
    $recipientEmail = $_POST['submitsuggestion'];
    $mail->addAddress($recipientEmail);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'I Heard You!';
    $mail->Body    = 'Dear User, <br><br>Thanks For Visiting My Portfolio.! I Heard That You Have Some Sort Of Suggestion And I Hereby Write You This Mail To Find Out More About The Suggestion. So,Please Let Me Know What Is It.<br><br>Thank you! Best regards,<br>Lokesh<br><br><br>NOTE:This Is An Automated Email.However You Can Reply To This Email And I Sahll Revert You Back ASAP.';

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
