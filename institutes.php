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
    <title>Institutes Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
            margin-top: 60px; /* Space for fixed header (if any) */
            background-color: #f4f7fa;
            border-radius: 8px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
        }
         p1 {
            font-size: 1.2rem;
            color: white;
            text-align: center;
            
        }

        .report-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 0;
            list-style: none;
        }

        .report-item {
            flex: 1 1 calc(33.333% - 16px); /* 3 items per row */
            max-width: 300px;
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
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

        .footer {
    background-color: green;
    color: white;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}


        @media (max-width: 992px) {
            .report-item {
                flex: 1 1 calc(50% - 16px); /* 2 items per row */
            }
        }

        @media (max-width: 576px) {
            .report-item {
                flex: 1 1 100%; /* 1 item per row */
            }

            h1 {
                font-size: 1.5rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Content Section -->
<div class="content">
    <h1>Institutes Page</h1>
    <p>Select an institute from the list to view its details.</p>

    <!-- Institutes List -->
    <ul class="report-list">
        <li class="report-item"><a href="Institute_of_Health_Research.php">1. Institute of Health Research</a></li>
        <li class="report-item"><a href="Institute_of_Traditional_and_Alternative_Medicine.php">2. Institute of Traditional and Alternative Medicine</a></li>
    </ul>
</div>

<!-- Footer -->
<div class="footer">
    <p1>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Include Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
