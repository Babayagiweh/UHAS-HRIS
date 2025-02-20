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
$page = $page > 0 ? $page : 1; // Ensure page is always at least 1
$offset = ($page - 1) * $limit;

// Search functionality
$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";

// Sorting functionality
$sortable_columns = ['staff_id', 'full_name', 'designation', 'department'];
$order_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sortable_columns) ? $_GET['sort_by'] : 'full_name';
$order_dir = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';

// Base query
$sql_base = "SELECT * FROM staff";
$sql_conditions = "";
$params = [];
$types = "";

// Apply search filter
if (!empty($search_query)) {
    $sql_conditions = " WHERE full_name LIKE ? OR staff_id LIKE ? OR designation LIKE ? OR department LIKE ?";
    $search_param = "%$search_query%";
    $params = [$search_param, $search_param, $search_param, $search_param];
    $types = "ssss";
}

// Get total records for pagination
$sql_count = $sql_base . $sql_conditions;
$stmt = $conn->prepare($sql_count);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total_records = $stmt->get_result()->num_rows;
$stmt->close();

// Fetch paginated records
$sql = $sql_base . $sql_conditions . " ORDER BY $order_by $order_dir LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
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
                <th><a href="?sort_by=staff_id&order=<?= $order_dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search_query) ?>">Staff ID</a></th>
                <th><a href="?sort_by=full_name&order=<?= $order_dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search_query) ?>">Full Name</a></th>
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
                        <td><a href="view_profile.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a></td>
                        <td>
                            <a href="update_staff_details.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_staff_details.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">No staff found.</td>
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
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search_query) ?>&sort_by=<?= $order_by ?>&order=<?= $order_dir ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search_query) ?>&sort_by=<?= $order_by ?>&order=<?= $order_dir ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search_query) ?>&sort_by=<?= $order_by ?>&order=<?= $order_dir ?>">Next</a>
            </li>
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
