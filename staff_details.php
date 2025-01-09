<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// Base query
$sql_base = "SELECT * FROM staff";
$sql_conditions = "";

// Apply search filter
if (!empty($search_query)) {
    $sql_conditions = " WHERE full_name LIKE '%$search_query%' 
                        OR staff_id LIKE '%$search_query%' 
                        OR designation LIKE '%$search_query%' 
                        OR department LIKE '%$search_query%'";
}

// Get total records for pagination
$sql_count = $sql_base . $sql_conditions;
$total_records = $conn->query($sql_count)->num_rows;

// Fetch paginated records
$sql = $sql_base . $sql_conditions . " LIMIT $offset, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
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
        table th, table td {
            text-align: left;
        }
    </style>
</head>
<body>

<header class="uhas-header">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>University of Health and Allied Sciences</h1>
    <p>Staff Profile Details</p>
</header>

<div class="container mt-4">
    <a href="home.php" class="btn btn-uhas mb-3">Back to Home</a>
    <form method="GET" class="d-flex mb-4">
        <input type="text" class="form-control me-2" name="search" placeholder="Search staff..." value="<?= htmlspecialchars($search_query) ?>">
        <button type="submit" class="btn btn-uhas">Search</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>S/No</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Campus</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Action</th>
                 <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $serial_no = $offset + 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $serial_no++ ?></td>
                        <td><?= htmlspecialchars($row['staff_id']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['designation']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['campus']) ?></td>
                        <td><?= htmlspecialchars($row['email_official']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['dob']) ?></td>
                        <td>
                            <a href="view_profile.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">View</a> 
                        </td>
                         <td>
                            <a href="update_staff_details.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a> 
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">No staff found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php
    $total_pages = ceil($total_records / $limit);
    if ($total_pages > 1):
    ?>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search_query) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- Export buttons -->
    <div class="mt-4">
        <a href="export_excel.php" class="btn btn-uhas">Export to Excel</a>
        <a href="export_pdf.php" class="btn btn-uhas">Export to PDF</a>
    </div>
</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
