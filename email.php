<?php
// Function to send a recovery email
function sendPasswordRecoveryMail($to, $recoveryLink) {
    $subject = "Password Recovery Request";
    $message = "
    <html>
    <head>
        <title>Password Recovery</title>
    </head>
    <body>
        <p>Dear User,</p>
        <p>We received a request to reset your password. Click the link below to reset it:</p>
        <a href='$recoveryLink'>$recoveryLink</a>
        <p>If you did not request this, please ignore this email.</p>
        <p>Best regards,</p>
        <p>Your Website Team</p>
    </body>
    </html>
    ";

    // To send HTML mail, set Content-type header
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= "From: noreply@yourwebsite.com" . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Recovery email sent successfully!";
    } else {
        echo "Failed to send recovery email.";
    }
}

// Usage example
$email = "user@example.com"; // Replace with the recipient's email
$recoveryLink = "https://yourwebsite.com/recover-password?token=abc123"; // Replace with your recovery URL
sendPasswordRecoveryMail($email, $recoveryLink);
?>