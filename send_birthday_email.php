<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Set PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.////////';  // Set the SMTP server to Gmail
    $mail->SMTPAuth = true;
    $mail->Username = '';  // Your mail address
    $mail->Password = '';  // Your mail password or app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS encryption
    $mail->Port = 587;  // TCP port to connect to

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $name = $_POST['name'];

        // Define sample birthday messages
        $messages = [
            "Dear $name,\n\nOn behalf of UHAS Management, we wish you a happy birthday. Have a fantastic year ahead filled with joy, success, and good health. We are happy to have you as part of the UHAS team. Have a wonderful day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nHappy birthday! On your special day, we want to take a moment to thank you for your hard work and dedication. We wish you a year ahead full of achievements, good health, and happiness. Enjoy your day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the entire UHAS family, we want to celebrate not just your birthday but the incredible value you bring to the University. Wishing you success, health, and happiness in the coming year. Have a great day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the UHAS Management, we wish you a happy birthday. May this year be filled with exciting opportunities, growth, and everything you’ve been wishing for. We are so grateful for your contributions and can’t wait to see what you achieve next. Have a great birthday!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the UHAS Management, we would like to wish you a happy birthday. Your dedication and contributions to the university are truly valued, and we are fortunate to have you as part of the University. May this year bring you continued success, good health, and happiness. Enjoy your special day!\n\nFrom: The UHAS HR Team",
            "Dear $name,\n\nHappy Birthday. We hope this year brings you great opportunities and personal achievements. Thank you for your hard work and commitment to excellence. Wishing you a wonderful birthday and a year filled with success and happiness.\n\nFrom: The UHAS HR Team",
            "Dear $name,\n\nHappy Birthday! Your expertise and efforts make a significant difference in the success of the UHAS team. On this special day, we celebrate you and wish you a fantastic year ahead, full of growth, joy, and accomplishment. Enjoy your day!\n\nFrom: The UHAS HR Team",
            "Dear $name,\n\nWe wish you a happy birthday on behalf of the Management. You are an integral part of our team, and we are grateful for all that you do. May this year bring you success and fulfillment in both your personal and professional endeavors. Have a fantastic day!\n\nFrom: The UHAS HR Team",
            "Dear $name,\n\nFrom the Management and the entire UHAS team, we wish you a happy birthday. May this birthday mark the beginning of a new chapter filled with endless possibilities and dreams coming true.\n\nFrom: The UHAS HR Team",
            "Dear $name,\n\nHappy birthday! Your contributions are appreciated. On behalf of UHAS Management, we wish you a successful year ahead.\n\nFrom: The UHAS HR Team"
        ];

        // Randomly select a birthday message
        $message = $messages[array_rand($messages)];

        // Set the recipient's email and subject
        $mail->setFrom('hr@uhas.edu.gh', 'UHAS HR');
        $mail->addAddress($email, $name);  // Recipient email and name
        $mail->Subject = "Happy Birthday, $name!";
        $mail->Body    = $message;

        // Send the email using PHPMailer
        if ($mail->send()) {
            echo "Birthday message sent to $name successfully!";
        } else {
            echo "Failed to send message to $name.";
        }
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
