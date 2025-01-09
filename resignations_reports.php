<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize filters
$filter_date = $filter_year = $filter_department = $filter_designation = $filter_effective_date = $filter_academic_rank = "";
$search_query = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Filters
    $filter_date = $_GET['filter_date'] ?? "";
    $filter_year = $_GET['filter_year'] ?? "";
    $filter_department = $_GET['filter_department'] ?? "";
    $filter_designation = $_GET['filter_designation'] ?? "";
    $filter_effective_date = $_GET['filter_effective_date'] ?? "";
    $filter_academic_rank = $_GET['filter_academic_rank'] ?? "";
    $search_query = $_GET['search_query'] ?? "";
}

// Base SQL query
$sql = "SELECT * FROM resignation WHERE 1=1";

// Apply filters
if (!empty($filter_date)) {
    $sql .= " AND date_hired = '$filter_date'";
}
if (!empty($filter_year)) {
    $sql .= " AND YEAR(date_hired) = '$filter_year'";
}
if (!empty($filter_department)) {
    $sql .= " AND department LIKE '%$filter_department%'";
}
if (!empty($filter_designation)) {
    $sql .= " AND designation LIKE '%$filter_designation%'";
}
if (!empty($filter_effective_date)) {
    $sql .= " AND effective_date = '$filter_effective_date'";
}
if (!empty($filter_academic_rank)) {
    $sql .= " AND academic_rank LIKE '%$filter_academic_rank%'";
}
if (!empty($search_query)) {
    $sql .= " AND (full_name LIKE '%$search_query%' OR staff_id LIKE '%$search_query%')";
}

// Execute query
$result = $conn->query($sql);

// Export to Excel
if (isset($_GET['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=staff_resignation_list.xls");
    echo "ID\tStaff ID\tTitle\tFull Name\tDesignation\tPresent Appointment\tDate Hired\tDepartment\tDate on Present Grade\tAcademic Rank\tDOB\tReason of Resignation\tEffective Date\tOfficial Email\tPrivate Email\tFiles\tCampus\n";
    while ($row = $result->fetch_assoc()) {
        echo implode("\t", $row) . "\n";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Resignation List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .uhas-header {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .btn-uhas {
            background-color: green;
            color: white;
        }
        .btn-uhas:hover {
            background-color: #00332c;
        }
        footer {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="uhas-header">
        <img src="uhas_logo.png" alt="UHAS Logo" width="80">
        <h1>University of Health and Allied Sciences</h1>
        <p>Staff Resignation List</p>
    </header>

    <div class="container mt-4">
        <a href="resignation_mgt.php" class="btn btn-uhas mb-3">Back to Resignation Management</a>

        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="filter_date" class="form-label">Filter by Date Hired</label>
                <input type="date" id="filter_date" name="filter_date" class="form-control" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_year" class="form-label">Filter by Year</label>
                <input type="number" id="filter_year" name="filter_year" class="form-control" placeholder="e.g., 2023" value="<?= htmlspecialchars($filter_year) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_department" class="form-label">Filter by Department</label>
                <input type="text" id="filter_department" name="filter_department" class="form-control" value="<?= htmlspecialchars($filter_department) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_designation" class="form-label">Filter by Designation</label>
                <input type="text" id="filter_designation" name="filter_designation" class="form-control" value="<?= htmlspecialchars($filter_designation) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_effective_date" class="form-label">Filter by Effective Date</label>
                <input type="date" id="filter_effective_date" name="filter_effective_date" class="form-control" value="<?= htmlspecialchars($filter_effective_date) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_academic_rank" class="form-label">Filter by Academic Rank</label>
                <input type="text" id="filter_academic_rank" name="filter_academic_rank" class="form-control" value="<?= htmlspecialchars($filter_academic_rank) ?>">
            </div>
            <div class="col-md-6">
                <label for="search_query" class="form-label">Search Staff</label>
                <input type="text" id="search_query" name="search_query" class="form-control" placeholder="Search by name or staff ID" value="<?= htmlspecialchars($search_query) ?>">
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-uhas">Filter</button>
                <a href="?export_excel=true" class="btn btn-uhas">Export to Excel</a>
                <button class="btn btn-uhas" onclick="window.print()">Print</button>
            </div>
        </form>

        <div class="table-container mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Staff ID</th>
                        <th>Full Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Date Hired</th>
                        <th>Effective Date</th>
                        <th>Academic Rank</th>
                        <th>Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['staff_id'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['designation'] ?></td>
                            <td><?= $row['department'] ?></td>
                            <td><?= $row['date_hired'] ?></td>
                            <td><?= $row['effective_date'] ?></td>
                            <td><?= $row['academic_rank'] ?></td>
                            <td><?= $row['campus'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>
</body>
</html>
<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize filters
$filter_date = $filter_year = $filter_department = $filter_designation = $filter_effective_date = $filter_academic_rank = "";
$search_query = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Filters
    $filter_date = $_GET['filter_date'] ?? "";
    $filter_year = $_GET['filter_year'] ?? "";
    $filter_department = $_GET['filter_department'] ?? "";
    $filter_designation = $_GET['filter_designation'] ?? "";
    $filter_effective_date = $_GET['filter_effective_date'] ?? "";
    $filter_academic_rank = $_GET['filter_academic_rank'] ?? "";
    $search_query = $_GET['search_query'] ?? "";
}

// Base SQL query
$sql = "SELECT * FROM resignation WHERE 1=1";

// Apply filters
if (!empty($filter_date)) {
    $sql .= " AND date_hired = '$filter_date'";
}
if (!empty($filter_year)) {
    $sql .= " AND YEAR(date_hired) = '$filter_year'";
}
if (!empty($filter_department)) {
    $sql .= " AND department LIKE '%$filter_department%'";
}
if (!empty($filter_designation)) {
    $sql .= " AND designation LIKE '%$filter_designation%'";
}
if (!empty($filter_effective_date)) {
    $sql .= " AND effective_date = '$filter_effective_date'";
}
if (!empty($filter_academic_rank)) {
    $sql .= " AND academic_rank LIKE '%$filter_academic_rank%'";
}
if (!empty($search_query)) {
    $sql .= " AND (full_name LIKE '%$search_query%' OR staff_id LIKE '%$search_query%')";
}

// Execute query
$result = $conn->query($sql);

// Export to Excel
if (isset($_GET['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=staff_resignation_list.xls");
    echo "ID\tStaff ID\tTitle\tFull Name\tDesignation\tPresent Appointment\tDate Hired\tDepartment\tDate on Present Grade\tAcademic Rank\tDOB\tReason of Resignation\tEffective Date\tOfficial Email\tPrivate Email\tFiles\tCampus\n";
    while ($row = $result->fetch_assoc()) {
        echo implode("\t", $row) . "\n";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Resignation List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .uhas-header {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .btn-uhas {
            background-color: green;
            color: white;
        }
        .btn-uhas:hover {
            background-color: #00332c;
        }
        footer {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="uhas-header">
        <img src="uhas_logo.png" alt="UHAS Logo" width="80">
        <h1>University of Health and Allied Sciences</h1>
        <p>Staff Resignation List</p>
    </header>

    <div class="container mt-4">
        <a href="resignation_mgt.php" class="btn btn-uhas mb-3">Back to Resignation Management</a>

        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="filter_date" class="form-label">Filter by Date Hired</label>
                <input type="date" id="filter_date" name="filter_date" class="form-control" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_year" class="form-label">Filter by Year</label>
                <input type="number" id="filter_year" name="filter_year" class="form-control" placeholder="e.g., 2023" value="<?= htmlspecialchars($filter_year) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_department" class="form-label">Filter by Department</label>
                <input type="text" id="filter_department" name="filter_department" class="form-control" value="<?= htmlspecialchars($filter_department) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_designation" class="form-label">Filter by Designation</label>
                <input type="text" id="filter_designation" name="filter_designation" class="form-control" value="<?= htmlspecialchars($filter_designation) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_effective_date" class="form-label">Filter by Effective Date</label>
                <input type="date" id="filter_effective_date" name="filter_effective_date" class="form-control" value="<?= htmlspecialchars($filter_effective_date) ?>">
            </div>
            <div class="col-md-3">
                <label for="filter_academic_rank" class="form-label">Filter by Academic Rank</label>
                <input type="text" id="filter_academic_rank" name="filter_academic_rank" class="form-control" value="<?= htmlspecialchars($filter_academic_rank) ?>">
            </div>
            <div class="col-md-6">
                <label for="search_query" class="form-label">Search Staff</label>
                <input type="text" id="search_query" name="search_query" class="form-control" placeholder="Search by name or staff ID" value="<?= htmlspecialchars($search_query) ?>">
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-uhas">Filter</button>
                <a href="?export_excel=true" class="btn btn-uhas">Export to Excel</a>
                <button class="btn btn-uhas" onclick="window.print()">Print</button>
            </div>
        </form>

        <div class="table-container mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Staff ID</th>
                        <th>Full Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Date Hired</th>
                        <th>Effective Date</th>
                        <th>Academic Rank</th>
                        <th>Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['staff_id'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['designation'] ?></td>
                            <td><?= $row['department'] ?></td>
                            <td><?= $row['date_hired'] ?></td>
                            <td><?= $row['effective_date'] ?></td>
                            <td><?= $row['academic_rank'] ?></td>
                            <td><?= $row['campus'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>
</body>
</html>
