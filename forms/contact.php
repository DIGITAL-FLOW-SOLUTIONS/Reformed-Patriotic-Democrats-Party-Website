<?php
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

session_start(); 

  $receiving_email_address = "";
  $from_name = "";
  $from_email = "";
  $subject = "";
  $raw = "";


 // Collect and sanitize form inputs
$receiving_email_address = "repaparty@gmail.com";
$from_name  = trim($_POST['name']);
$from_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$subject    = trim($_POST['subject']);
$raw        = $_POST['message'];

// convert newlines to <br>  
$safe = htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
$message = nl2br($safe);


  // Create a new PHPMailer instance
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'mail.repa.co.ke';
$mail->SMTPAuth = true;
$mail->Username = 'membership@repa.co.ke';
$mail->Password = 'REPA#@456gh$';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;


// Set the sender and recipient
$mail->Sender = 'bounces@repa.co.ke';
$mail->setFrom('membership@repa.co.ke', $subject);
$mail->addReplyTo($from_email, $from_name);
$mail->addAddress($receiving_email_address);

$mail->isHTML(true);

$mail->Subject = 'New Contact Form Submission: ' . $subject;

// HTML body
$mail->Subject = 'New Contact Form Submission: ' . htmlspecialchars($subject, ENT_QUOTES);
$mail->Body    = <<<EOD
<!DOCTYPE html>
<html>
  <body style="font-family:Arial,sans-serif;line-height:1.5;color:#333;">
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$from_name}<br>
       <strong>Email:</strong> <a href="mailto:{$from_email}">{$from_email}</a><br>
       <strong>Subject:</strong> {$subject}</p>
    <hr>
    <p>{$message}</p>
    <hr>
    <p style="font-size:12px;color:#777;">
      This email was generated automatically by your website.
    </p>
  </body>
</html>
EOD;

$mail->AltBody = "New contact form submission:\n\n"
    . "Name: {$from_name}\n"
    . "Email: {$from_email}\n"
    . "Subject: {$subject}\n\n"
    . strip_tags($message);

if ( $mail->send() ) {
    // JS is checking for exactly “OK”
    echo 'OK';
} else {
    // you can also set a 500 HTTP status if you like:
    http_response_code(500);
    // JS will throw this string as an error
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>
