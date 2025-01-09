<?php
// Set the header to output an HTML page
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Under Construction</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            text-align: center;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }

        .message-box {
            background-color: rgba(30, 127, 54, 0.8); /* UHAS green with transparency */
            padding: 20px 40px;
            border-radius: 12px;
        }

        .message-box h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .message-box p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .footer {
            background-color: #FCD116; /* UHAS yellow */
            color: #1E7F36; /* UHAS green */
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-weight: bold;
        }

        a {
            color: #FCD116;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message-box">
            <h1>Page Under Construction</h1>
            <p>The webpage will be updated soon. Please check back later!</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 University of Health and Allied Sciences (UHAS) | All Rights Reserved</p>
    </div>

    <!-- Include Bootstrap JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
