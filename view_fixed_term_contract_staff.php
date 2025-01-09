<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$limit = 10; // Rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search and filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_department = isset($_GET['department']) ? $_GET['department'] : '';
$filter_designation = isset($_GET['designation']) ? $_GET['designation'] : '';

$filter_query = "WHERE 1=1";
if ($search) {
    $filter_query .= " AND (full_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($filter_department) {
    $filter_query .= " AND department = '$filter_department'";
}
if ($filter_designation) {
    $filter_query .= " AND designation = '$filter_designation'";
}

// Fetch filtered data with pagination from fixed_term_contract_staff table
$sql = "SELECT * FROM fixed_term_contract $filter_query LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total rows for pagination
$total_sql = "SELECT COUNT(*) AS total FROM fixed_term_contract $filter_query";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch distinct departments and designations for filters
$departments = $conn->query("SELECT DISTINCT department FROM fixed_term_contract");
$designations = $conn->query("SELECT DISTINCT designation FROM fixed_term_contract");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Term Contract Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .uhas-header, footer { background-color: green; color: white; }
        .btn-uhas { background-color: green; color: white; }
        .btn-uhas:hover { background-color: #00332c; }
        .pagination .page-item.active .page-link { background-color: yellow; border-color: green; }
        footer { padding: 10px; text-align: center; margin-top: 20px; }
        .table th { background-color: green; color: white; }
    </style>
</head>
<body>

<header class="uhas-header text-center p-3">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>Fixed Term Contract Staff</h1>
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
                <select class="form-control" name="department" onchange="this.form.submit()">
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

    <table class="table table-striped">
        <thead>
            <tr>
                <th>S/no</th>
                <th>ID</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Designation</th>
                <th>Present Appointment</th>
                <th>Department</th>
                <th>Highest Qualification</th>
                <th>Service Date</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Campus</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serial = $offset + 1; // Start serial number for each page
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $serial++; ?></td>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['staff_id']; ?></td>
                    <td><?= $row['full_name']; ?></td>
                    <td><?= $row['dob']; ?></td>
                    <td><?= $row['designation']; ?></td>
                    <td><?= $row['present_appointment']; ?></td>
                    <td><?= $row['department']; ?></td>
                    <td><?= $row['highest_qualifications']; ?></td>
                    <td><?= $row['service_date']; ?></td>
                    <td><?= $row['contract_start_date']; ?></td>
                    <td><?= $row['contract_end_date']; ?></td>
                    <td><?= $row['campus']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['phone']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <form method="GET" action="export_fixed_term_contract.php" class="mt-3">
        <button type="submit" name="export_excel" class="btn btn-uhas">Export to Excel</button>
        <button type="submit" name="export_pdf" class="btn btn-uhas">Export to PDF</button>
        <button><a href="fixed_term_contracts_mgt.php" class="btn btn-uhas mb-3">Back</a></button> 
    </form>

</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
