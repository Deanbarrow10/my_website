<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        header('Location: ../contact.html?error=1');
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                   // Disable verbose debug output
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                   // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'dean33261@gmail.com';              // SMTP username
        $mail->Password   = 'spdr iskc sxyz dfvu';              // SMTP password (use an app password if 2FA is enabled)
        $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('dean33261@gmail.com');              // Add a recipient

        // Content
        $mail->isHTML(false);                                   // Set email format to plain text
        $mail->Subject = 'New contact from ' . $name;
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        http_response_code(200);
        header('Location: ../success.html');
        exit;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        http_response_code(500);
        header('Location: ../contact.html?error=2');
        exit;
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
    exit;
}
?>