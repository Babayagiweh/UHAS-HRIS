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
    <title>Campuses Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            background-image: url('bg.jp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        
        .content {
            padding: 20px;
        }

        .content h1 {
            color: #343a40;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .content p {
            font-size: 1rem;
            color: #555;
            text-align: center;
        }

        .report-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .report-item {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            flex: 1 1 calc(100% - 30px); /* Full width on small screens */
            max-width: calc(33.33% - 30px); /* 3 items per row on large screens */
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
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .report-item {
                max-width: calc(50% - 15px); /* 2 items per row on tablets */
            }
        }

        @media (max-width: 576px) {
            .report-item {
                max-width: calc(100% - 30px); /* 1 item per row on small screens */
            }
        }
    </style>
</head>
<body>
<div class="content">
    <h1>Campuses Page</h1>
    <p>Select a Campus from the list to view its details.</p>
    <div class="report-list-container">
        <ul class="report-list">
            <li class="report-item"><a href="Trafalgar.php">1. Trafalgar Campus</a></li>
            <li class="report-item"><a href="phase1.php">2. Sokode Main Campus Phase 1</a></li>
            <li class="report-item"><a href="phase2.php">3. Sokode Main Campus Phase 2</a></li>
            <li class="report-item"><a href="dave.php">4. Dave Campus</a></li>
            <li class="report-item"><a href="hohoe.php">5. Hohoe Campus</a></li>
            <li class="report-item"><a href="basic_school.php">6. Basic School</a></li>
        </ul>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Include Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
