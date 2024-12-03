<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$emailUsername = $_ENV['EMAIL_USERNAME'];
$emailPassword = $_ENV['EMAIL_PASSWORD'];
$ccEmail = $_ENV['MY_EMAIL'];



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
    $recipientEmail = $_POST['email'];
    $mail->addAddress($recipientEmail,);
    $mail->addCC($ccEmail);




    $name = $_POST['name']; 
    $companyname= $_POST['companyname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $message = $_POST['message'];

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'I Heard You!';
    $mail->Body    = 'We Have Recieved Your Contact Form Submmision With The Below Details:<br><br>' . 
                     'Name: ' . $name . '<br>' .
                     'Company Name (IF PROVIDED):' .$companyname .'<br>' .
                     'Email: ' . $email . '<br>' .
                     'Phone Number (IF PROVIDED):' .$phonenumber.'<br>' .
                     'Message: ' . $message. '<br><br><br><br>'.
                     '<b>DISCLAIMER: THIS EMAIL MAY CONTAIN PRIVILEGED INFORMATION AND IS INTENDED SOLELY FOR THE ADDRESSEE, AND ANY DISCLOSURE OF THIS INFORMATION IS STRICTLY PROHIBITED,AND MAY BE UNLAWFUL.IF YOU HAVE RECEIVED THIS MAIL BY MISTAKE,PLEASE INFORM THE SENDER IMMEDIATELY AND DELETE THIS MAIL. ANY INFORMATION EXPRESSED IN THIS MAIL DOES NOT NECESSARILY REFLECT THE VIEWSS OF LOKESH.PLEASE NOTE THAT ANY VIEWS OR OPINIONS PRESENTED IN THIS EMAIL ARE SOLELY THOSE OF THE AUTHOR AND DO NOT NECESSARILY REPRESENT THOSE OF THE LOKESH. THE RECIPIENT SHOULD CHECK THIS EMAIL AND ANY ATTACHMENTS FOR THE PRESENCE OF VIRUSES.THE SENDER DECLARES THAT NO LIABILITY CAN BE CAST UPON THE SENDER FOR ANY ERROR OR OMISSIONS IN THE CONTENTS OF THE MESSAGE THAT ARISE, AS A RESULT OF EMAIL TRANSMISSION AND FURTHER DECLARES THAT THE SENDER CANNOT BE MADE LIABLE FOR ANY LOSS SUFFERED BY ANY PERSON, ON ACCOUNT OF HAVING ACTED UPON ANY MESSAGES WHICH IS VITIATED BY ERROR, OMMISIONS OR INTERCEPTION.</b>'
                     ;

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
