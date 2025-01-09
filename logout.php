<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
    <script>
        // Function to display the popup notification
        function showLogoutMessage() {
            // Display the notification message
            alert("You have been successfully logged out. Do have a greate day Admin!");
            
            // Redirect to the home page after the message
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 2000); // 2 seconds delay
        }
    </script>
</head>
<body onload="showLogoutMessage()">
    <!-- This body will automatically trigger the script on page load -->
</body>
</html>
