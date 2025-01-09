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
    <title>Casual Staff Menu</title>
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
            padding: 30px;
            background-color: #f4f7fa;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: auto;
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

        .report-list-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .report-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
        }

        .report-item {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            flex: 1 1 calc(20% - 16px); /* 5 items per row */
            min-width: 200px;
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

        @media (max-width: 768px) {
            .report-item {
                flex: 1 1 calc(50% - 16px); /* 2 items per row */
            }
        }

        @media (max-width: 576px) {
            .report-item {
                flex: 1 1 100%; /* 1 item per row */
            }
            h1 {
                font-size: 2rem;
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

        .report-item a:focus {
            outline: 3px solid #ffbf47;
        }
    </style>
</head>
<body>

<div class="content">
    <h1>Casual Staff Management Page</h1>
    <p>Select an option from the list to view its details.</p>

    <div class="report-list-container">
        <ul class="report-list">
            <li class="report-item"><a href="add_casual_mgt.php" title="Add a new casual staff member">1. Add Casual Staff</a></li>
            <li class="report-item"><a href="view_casual_staff.php" title="View a list of all casual staff">2. Casual Staff Lists</a></li>
        </ul>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
