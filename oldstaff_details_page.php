<?php
include('db_connect.php');

// Get the department ID from the URL parameter
$department_id = $_GET['dept_id'];

// Fetch staff details based on department ID
$query = "SELECT * FROM staff WHERE dept_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$dept_id]);
$staff_details = $stmt->fetchAll();

// Fetch department name for the header
$dept_query = "SELECT name FROM departments WHERE id = ?";
$dept_stmt = $pdo->prepare($dept_query);
$dept_stmt->execute([$dept_id]);
$department = $dept_stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - <?= $department['name']; ?> | UHAS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">UHAS</a>
    </div>
</nav>

<!-- Staff Table -->
<div class="container my-5">
    <h2 class="text-center mb-4"><?= $department['name']; ?> Staff</h2>
    
    <button id="backButton" class="btn btn-secondary mb-4">Back to Home</button>
    
    <table id="staffTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S/No</th>
                <th>Staff ID</th>
                <th>Title</th>
                <th>Fullname</th>
                <th>Age</th>
                <th>Status</th>
                <th>Campus</th>
                <th>Qualification</th>
                <th>Appointment</th>
                <th>Speciality</th>
                <th>Category</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff_details as $index => $staff): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $staff['staff_id']; ?></td>
                    <td><?= $staff['title']; ?></td>
                    <td><?= $staff['fullname']; ?></td>
                    <td><?= $staff['age']; ?></td>
                    <td><?= $staff['employee_status']; ?></td>
                    <td><?= $staff['campus']; ?></td>
                    <td><?= $staff['highest_qualification']; ?></td>
                    <td><?= $staff['present_appointment']; ?></td>
                    <td><?= $staff['speciality']; ?></td>
                    <td><?= $staff['staff_category']; ?></td>
                    <td><?= $staff['email_official']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Options -->
    <div class="d-flex justify-content-between">
        <button id="printButton" class="btn btn-success">Print</button>
        <button id="exportExcel" class="btn btn-warning">Export to Excel</button>
        <button id="exportPdf" class="btn btn-danger">Export to PDF</button>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 University of Health and Allied Sciences | <a href="https://www.uhas.edu.gh" target="_blank" class="text-white">Visit UHAS</a></p>
</footer>

<script src="scripts.js"></script>
</body>
</html>
