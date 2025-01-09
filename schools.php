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
    <title>Schools Menu</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .content {
            padding: 20px;
            background-color: #f4f7fa;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 20px auto;
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
            color: #55;
            text-align: center;
            margin-bottom: 30px;
        }

        .report-list-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .report-item {
            flex: 1 1 calc(25% - 20px);
            background-color: #4caf50;
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            min-width: 200px;
            max-width: 250px;
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

        .footer {
            background-color: #28a745;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Content Section -->
<div class="content">
    <h1>Schools Page</h1>
    <p>Select a school from the list to view its details.</p>

    <div class="report-list-container">
        <div class="report-item"><a href="school_of_medicine.php">1. School of Medicine</a></div>
        <div class="report-item"><a href="school_of_dentistry.php">2. School of Dentistry</a></div>
        <div class="report-item"><a href="school_of_nursing_and_midwifery.php">3. School of Nursing and Midwifery</a></div>
        <div class="report-item"><a href="school_of_sports_and_exercise_medicine.php">4. School of Sports and Exercise Medicine</a></div>
        <div class="report-item"><a href="school_of_allied_health_science.php">5. School of Allied Health Science</a></div>
        <div class="report-item"><a href="school_of_basic_and_biomedical_sciences.php">6. School of Basic and Biomedical Sciences</a></div>
        <div class="report-item"><a href="school_of_pharmacy.php">7. School of Pharmacy</a></div>
        <div class="report-item"><a href="fred_n_binka_school_of_public_health.php">8. Fred N. Binka School of Public Health</a></div>
    </div>
</div>
<br>
<br>
<br>
<hr>
<!-- Footer -->
<div class="footer">
    <p>&copy; 2025 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Include Bootstrap JS for interactivity -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
