<?php
// Start session and check login (optional based on your needs)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>system logs</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }
        .message-container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 50px;
            border-radius: 10px;
            color: #fff;
        }
        .message-container h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .message-container p {
            font-size: 24px;
            margin: 0;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Maintenance Message -->
    <div class="message-container">
        <h1>WEBPAGE WILL BE UPDATED SOON!!!</h1>
        <p>Thank you for your patience.</p>
    </div>

    <!-- Include the UHAS footer -->
    <footer>
        <p>&copy; 2024 University of Health and Allied Sciences | All Rights Reserved</p>
    </footer>
</body>
</html>
