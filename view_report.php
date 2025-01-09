<?php
// Include the database connection
include('config.php');

// Check if the report ID is set in the URL
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];
    
    // Query to fetch the report details
    $query = "SELECT * FROM staff WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $report_id, PDO::PARAM_INT);
    $stmt->execute();
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$report) {
        die('Report not found');
    }
} else {
    die('No report selected');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #3d9c2b;
            color: white;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #1e7d22;
        }
        .footer {
            background-color: #3d9c2b;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center">
        <h1><?php echo htmlspecialchars($report['title']); ?></h1>
        <p class="lead"><?php echo htmlspecialchars($report['description']); ?></p>
    </div>

    <div>
        <!-- Here you can include the actual content of the report -->
        <h4>Report Content:</h4>
        <p><?php echo htmlspecialchars($report['content']); ?></p>
    </div>

    <div class="text-center">
        <a href="report.php" class="btn btn-custom">Back to Reports List</a>
    </div>
</div>

<!-- UHAS Footer -->
<div class="footer">
    <p>&copy; 2024 University of Health and Allied Sciences (UHAS). All Rights Reserved.</p>
</div>

</body>
</html>
