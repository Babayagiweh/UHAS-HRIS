<?php 
// Include necessary PHP files
include('config.php');
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSS Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
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
            margin-bottom: 30px;
        }

        .report-list-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .report-item {
            flex: 1 1 calc(20% - 16px);
            min-width: 200px;
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

        .report-item a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .report-item {
                flex: 1 1 calc(50% - 16px);
            }
        }

        @media (max-width: 576px) {
            .report-item {
                flex: 1 1 100%;
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
    <h1>National Service Personnel Management | Internship Page</h1>
    <p>Select an option from the list to view its details.</p>

    <div class="report-list-container">
        <ul class="report-list" style="padding: 0; list-style: none; margin: 0; display: flex; flex-wrap: wrap; gap: 20px;">
            <li class="report-item">
                <a href="add_nss.php" title="Add new NSS staff" aria-label="Add NSS Staff">1. Add NSS Staff</a>
            </li>
            <li class="report-item">
                <a href="nss_staff_list.php" title="View NSS staff details" aria-label="View NSS Staff Details">2. NSS Personnel Detail List</a>
            </li>
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
