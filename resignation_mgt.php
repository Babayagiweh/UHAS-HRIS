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
    <title>Resignation Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Custom Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 30px;
            background-color: #f4f7fa;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: #343a40;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
        }

        .report-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .report-item {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            flex: 1 1 calc(20% - 16px); /* Flexbox for responsive layout */
            min-width: 180px;
        }

        .report-item a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            display: block;
        }

        .report-item:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .report-item a:hover {
            text-decoration: underline;
        }

        /* Media Queries for responsive design */
        @media (max-width: 768px) {
            .report-item {
                flex: 1 1 calc(50% - 16px); /* 2 items per row */
            }
        }

        @media (max-width: 576px) {
            .report-item {
                flex: 1 1 100%; /* 1 item per row on small screens */
            }

            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 1rem;
            }
        }

        .footer {
            background-color: green;
            color: white;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Focus state for accessibility */
        .report-item a:focus {
            outline: 3px solid #ffbf47; /* Yellow outline to make it noticeable */
        }
    </style>
</head>
<body>

<!-- Content Section -->
<div class="content">
    <h1>Welcome to the Resignation Management Page</h1>
    <p>Select an option from the list to view its details.</p>

    <!-- Resignation List -->
    <div class="report-list-container">
        <ul class="report-list">
            <li class="report-item"><a href="add_resignation.php" title="Add Approved Resignations">1. Add Approved Resignations</a></li>
            <li class="report-item"><a href="resignations_reports.php" title="View Detailed Resignation Lists">2. Detail Resignations Lists</a></li>
        </ul>
    </div>
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
