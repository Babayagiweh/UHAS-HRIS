<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// Variables for modal message
$modalMessage = '';
$isSuccess = false;

try {
    // Set PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'uhasbirthdays@gmail.com';  // Your mail address
    $mail->Password = 'rdoyazorakntnxeg';  // Your mail password or app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS encryption
    $mail->Port = 587;  // TCP port to connect to

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize inputs
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        // Define sample birthday messages
        $messages = [
            "Dear $name,\n\nOn behalf of UHAS Management, we wish you a happy birthday. Have a fantastic year ahead filled with joy, success, and good health. We are happy to have you as part of the UHAS team. Have a wonderful day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nHappy birthday! On your special day, we want to take a moment to thank you for your hard work and dedication. We wish you a year ahead full of achievements, good health, and happiness. Enjoy your day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the entire UHAS family, we want to celebrate not just your birthday but the incredible value you bring to the University. Wishing you success, health, and happiness in the coming year. Have a great day!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the UHAS Management, we wish you a happy birthday. May this year be filled with exciting opportunities, growth, and everything you’ve been wishing for. We are so grateful for your contributions and can’t wait to see what you achieve next. Have a great birthday!\n\nFrom: Directorate of Human Resource",
            "Dear $name,\n\nOn behalf of the UHAS Management, we would like to wish you a happy birthday. Your dedication and contributions to the university are truly valued, and we are fortunate to have you as part of the University. May this year bring you continued success, good health, and happiness. Enjoy your special day!\n\nFrom: The UHAS HR TEAM",
            "Dear $name,\n\nHappy Birthday. We hope this year brings you great opportunities and personal achievements. Thank you for your hard work and commitment to excellence. Wishing you a wonderful birthday and a year filled with success and happiness.\n\nFrom: The UHAS HR TEAM",
            "Dear $name,\n\nHappy Birthday! Your expertise and efforts make a significant difference in the success of the UHAS team. On this special day, we celebrate you and wish you a fantastic year ahead, full of growth, joy, and accomplishment. Enjoy your day!\n\nFrom: The UHAS HR TEAM",
            "Dear $name,\n\nWe wish you a happy birthday on behalf of the Management. You are an integral part of our team, and we are grateful for all that you do. May this year bring you success and fulfillment in both your personal and professional endeavors. Have a fantastic day!\n\nFrom: The UHAS HR TEAM",
            "Dear $name,\n\nFrom the Management and the entire UHAS team, we wish you a happy birthday. May this birthday mark the beginning of a new chapter filled with endless possibilities and dreams coming true.\n\nFrom: The UHAS HR TEAM",
            "Dear $name,\n\nHappy birthday! Your contributions are appreciated. On behalf of UHAS Management, we wish you a successful year ahead.\n\nFrom: The UHAS HR TEAM"
        ];

        // Randomly select a birthday message
        $message = $messages[array_rand($messages)];

        // Set the recipient's email and subject
        $mail->setFrom('uhasbirthdays@gmail.com', 'UHAS HR');
        $mail->addAddress($email, $name);  // Recipient email and name
        $mail->Subject = "Happy Birthday, $name!";
        $mail->Body    = $message;

        // Send the email using PHPMailer
        if ($mail->send()) {
            $modalMessage = "Birthday message sent to $name successfully!";
            $isSuccess = true;
        } else {
            $modalMessage = "Failed to send message to $name.";
        }
    }
} catch (Exception $e) {
    $modalMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Message</title>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-radius: 8px;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .modal.show, .modal-overlay.show {
            display: block;
        }
        .modal.success {
            border: 2px solid green;
        }
        .modal.error {
            border: 2px solid red;
        }
        .modal button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Modal Structure -->
    <div id="modal" class="modal <?php echo $isSuccess ? 'success' : 'error'; ?>">
        <p><?php echo $modalMessage; ?></p>
        <button onclick="closeModal()">Close</button>
    </div>
    <div id="modal-overlay" class="modal-overlay"></div>

    <script>
        // Show modal if there's a message
        <?php if (!empty($modalMessage)): ?>
            document.getElementById('modal').classList.add('show');
            document.getElementById('modal-overlay').classList.add('show');
        <?php endif; ?>

        // Function to close the modal
        function closeModal() {
            document.getElementById('modal').classList.remove('show');
            document.getElementById('modal-overlay').classList.remove('show');
            window.location.href = 'home.php'; // Redirect to home.php
        }
    </script>
</body>
</html>