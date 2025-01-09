<?php
include('config.php');

// Check if staff_id is passed via the URL
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Fetch staff details from the database
    $query = $con->prepare("SELECT * FROM staff WHERE staff_id = :staff_id");
    $query->bindParam(':staff_id', $staff_id);
    $query->execute();

    if ($query->rowCount() > 0) {
        $staff = $query->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<script>alert('No staff found with the given ID.'); window.location='index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid access!'); window.location='index.php';</script>";
    exit();
}

// Code for printing logic
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            text-align: center;
            width: 100%;
        }
        .content {
            margin: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="uhas_logo.png" alt="UHAS Logo" width="100">
        <h2>University of Health and Allied Sciences</h2>
        <h4>Human Resources Department</h4>
        <p>Staff Details Report - <?php echo date('F, Y'); ?></p>
    </div>

    <div class="content">
        <h3>Staff Information</h3>
        <table class="table">
            <tr><th>Full Name</th><td><?php echo $staff['full_name']; ?></td></tr>
            <tr><th>Staff ID</th><td><?php echo $staff['staff_id']; ?></td></tr>
            <tr><th>Title</th><td><?php echo $staff['title']; ?></td></tr>
            <tr><th>Gender</th><td><?php echo $staff['gender']; ?></td></tr>
            <tr><th>Phone</th><td><?php echo $staff['phone']; ?></td></tr>
            <tr><th>Email</th><td><?php echo $staff['email_official']; ?></td></tr>
            <!-- Add more fields as needed -->
        </table>
    </div>

    <div class="footer">
        <button onclick="window.print()">Print</button>
    </div>
</body>
</html>
