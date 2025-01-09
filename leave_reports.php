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
    <title>Leave Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Custom Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
        }
        
        .content {
            margin-top: 80px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
            margin-bottom: 30px;
        }

        .report-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .report-item {
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .report-item a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            display: block;
        }

        .report-item:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .report-item a:hover {
            text-decoration: underline;
        }

        /* Footer styling */
        .footer {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Content Section -->
<div class="container">
    <div class="content">
        <h1>Welcome to the Leave Details Page</h1>
        <p>Select an option from the list to view its details.</p>

        <!-- Leave Reports List -->
        <ul class="report-list">
            <li class="report-item"><a href="annual_leave_report.php">1. Approved Annual Leave Reports</a></li>
            <li class="report-item"><a href="maternity_leave_report.php">2. Approved Maternity Leave</a></li>
            <li class="report-item"><a href="casual_leave_report.php">3. Approved Casual Leave</a></li>
            <li class="report-item"><a href="paternity_leave_report.php">4. Approved Paternity Leave</a></li>
        </ul>
    </div>
</div>
<br>
<br>
<br>
<br>
<hr>
<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Include Bootstrap JS for interactivity -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
