<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date and calculate the date for 5 months ago
$current_date = date('Y-m-d');
$date_5_months_ago = date('Y-m-d', strtotime('-5 months', strtotime($current_date)));

// Search and filter logic
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_department = isset($_GET['department']) ? $_GET['department'] : '';
$filter_designation = isset($_GET['designation']) ? $_GET['designation'] : '';
$filter_full_name = isset($_GET['full_name']) ? $_GET['full_name'] : '';

$filter_query = "WHERE date_hired >= '$date_5_months_ago'";
if ($search) {
    $filter_query .= " AND (full_name LIKE '%$search%' OR email_private LIKE '%$search%')";
}
if ($filter_department) {
    $filter_query .= " AND department = '$filter_department'";
}
if ($filter_designation) {
    $filter_query .= " AND designation = '$filter_designation'";
}

// SQL query to fetch data
$sql = "SELECT * FROM staff $filter_query";
$result = $conn->query($sql);

// Fetch distinct departments and designations for filters
$departments = $conn->query("SELECT DISTINCT department FROM staff");
$designations = $conn->query("SELECT DISTINCT designation FROM staff");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newly Recruited Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .uhas-header, footer {
            background-color: green;
            color: white;
        }
        .btn-uhas {
            background-color: green;
            color: white;
        }
        .btn-uhas:hover {
            background-color: #00332c;
        }
        .pagination .page-item.active .page-link {
            background-color: yellow;
            border-color: green;
        }
        .table th {
            background-color: green;
            color: white;
        }
        footer {
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header class="uhas-header text-center p-3">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>NEWLY RECRUITED STAFF</h1>
    (over the past five months)
</header>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-4">
            <form method="GET">
                <input type="text" class="form-control" name="search" placeholder="Search by Name or Email" value="<?= $search; ?>">
            </form>
        </div>
        <div class="col-md-3">
            <form method="GET">
                <select class="form-control" name="department" onchange="this.form.submit()">ytthhhuvuvyvyvyv
                    <option value="">Filter by Department</option>
                    <?php while ($row = $departments->fetch_assoc()): ?>
                        <option value="<?= $row['department']; ?>" <?= $filter_department == $row['department'] ? 'selected' : ''; ?>>
                            <?= $row['department']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>
        <div class="col-md-3">
            <form method="GET">
                <select class="form-control" name="designation" onchange="this.form.submit()">
                    <option value="">Filter by Designation</option>
                    <?php while ($row = $designations->fetch_assoc()): ?>
                        <option value="<?= $row['designation']; ?>" <?= $filter_designation == $row['designation'] ? 'selected' : ''; ?>>
                            <?= $row['designation']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>
        <div class="col-md-2 text-end">
            <button onclick="window.print()" class="btn btn-uhas">Print</button>
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S/No</th>
                    <th>Staff ID</th>
                    <th>Full Name</th>
                    <th>Date Hired</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $sn++; ?></td>
                        <td><?= $row['staff_id']; ?></td>
                        <td><?= $row['full_name']; ?></td>
                        <td><?= $row['date_hired']; ?></td>
                        <td><?= $row['designation']; ?></td>
                        <td><?= $row['department']; ?></td>
                        <td><?= $row['email_private']; ?></td>
                        <td><?= $row['phone']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">No newly recruited staff found within the last 5 months.</div>
    <?php endif; ?>

    <form method="GET" action="export_newly_recruited.php" class="mt-3 text-end">
        <button><a href="home.php" class="btn btn-uhas mb-3">Back to home</button></a>
        <button type="submit" name="export_excel" class="btn btn-uhas">Export to Excel</button>
        <button type="submit" name="fpdf.php" class="btn btn-uhas">Export to PDF</button>
    </form>

</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
