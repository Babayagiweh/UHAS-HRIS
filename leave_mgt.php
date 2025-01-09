<?php
// Include necessary PHP files, such as for database connection (if needed)
include('config.php');
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            background-image: url('bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .content {
            margin: 20px auto;
            max-width: 900px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .content h1 {
            color: #343a40;
            font-size: 2.5rem;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
            margin-bottom: 30px;
        }

        .report-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .report-item {
            width: calc(40% - 16px);
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .report-item a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            display: block;
        }

        .report-item:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .footer {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer p {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<!-- Content Section -->
<div class="content">
    <h1>Leave Management Page</h1>
    <p>Select an option below to proceed:</p>

    <ul class="report-list">
        <li class="report-item"><a href="add_leave.php">Add Approved Leave Request</a></li>
        <li class="report-item"><a href="leave_reports.php">View Detailed Leave Reports</a></li>
    </ul>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Include Bootstrap JS for interactivity -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
