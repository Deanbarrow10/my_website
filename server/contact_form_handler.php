<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Ensure the fields are not empty and the email is valid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        header('Location: ../contact.html?error=1');
        exit;
    }

    // Set your email address
    $recipient = "dean33261@gmail.com"; // Replace with your actual email address

    // Create the email subject and content
    $subject = "New contact from $name";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        header('Location: ../success.html');
        exit;
    } else {
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