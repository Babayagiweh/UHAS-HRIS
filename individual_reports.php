<?php 
include("header.php");
include('config.php'); // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #198754;
            color: #fff;
        }
        .btn {
            margin: 2px;
        }
        .header-logo {
            width: 100px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center text-success">Staff Management</h1>
    <div class="text-end mb-3">
        <a href="add_staff.php" class="btn btn-primary">Add New Staff</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>S/No</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Campus</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    // Corrected the SQL query (removed trailing comma after campus field)
                    $stmt = $con->prepare("SELECT staff_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, gender, designation, department, campus, date_of_birth FROM staff ORDER BY staff_id ASC");
                    $stmt->execute();
                    $staff_list = $stmt->fetchAll();
                    $s_no = 1;

                    foreach ($staff_list as $staff) {
                        // Calculate age based on date_of_birth
                        $birthdate = new DateTime($staff['date_of_birth']);
                        $currentDate = new DateTime();
                        $age = $birthdate->diff($currentDate)->format('%y');
            ?>
            <tr>
                <td><?php echo $s_no++; ?></td>
                <td><?php echo $staff['staff_id']; ?></td>
                <td><?php echo $staff['full_name']; ?></td>
                <td><?php echo $staff['gender']; ?></td>
                <td><?php echo $staff['designation']; ?></td>
                <td><?php echo $staff['department']; ?></td>
                <td><?php echo $staff['campus']; ?></td>
                <td><?php echo $age; ?></td>
                <td>
                    <a href="view_staff.php?staff_id=<?php echo $staff['staff_id']; ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit_staff.php?staff_id=<?php echo $staff['staff_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="print_staff.php?staff_id=<?php echo $staff['staff_id']; ?>" class="btn btn-success btn-sm">Print</a>
                </td>
            </tr>
            <?php 
                    } // End of foreach
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
