<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// SQL query to fetch data with search and pagination
$sql = "SELECT * FROM nss WHERE full_name LIKE '%$search%' OR nss_number LIKE '%$search%' LIMIT $start, $limit";
$result = $conn->query($sql);

// Get total number of rows for pagination
$total_sql = "SELECT COUNT(*) FROM nss WHERE full_name LIKE '%$search%' OR nss_number LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

// Export functionality (Export to CSV)
if (isset($_GET['export'])) {
    $filename = "nss_staff_" . date("Y-m-d") . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['S/N', 'NSS Number', 'Full Name', 'DOB', 'Institution Attended', 'Program Studied', 'Qualification', 'NSS Start Date', 'Department Posted', 'NSS End Date', 'Email', 'Phone', 'Campus']);
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSS Staff List</title>
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
        .container {
            margin-top: 30px;
        }
        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header class="uhas-header">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>University of Health and Allied Sciences</h1>
    <p>NSS Staff Management</p>
</header>

<div class="container">
    <a href="nss_staff_mgt.php" class="btn btn-uhas mb-3">Back to NSS Staff Management</a>

    <!-- Search Form -->
    <div class="search-box">
        <form method="GET" class="form-inline">
            <input type="text" class="form-control" name="search" placeholder="Search by Name or NSS Number" value="<?php echo $search; ?>" required>
            <button type="submit" class="btn btn-uhas ml-2">Search</button>
            <a href="?export=true" class="btn btn-uhas ml-2">Export to CSV</a>
        </form>
    </div>

    <!-- NSS Staff Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>S/N</th>
                <th>NSS Number</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Institution Attended</th>
                <th>Program Studied</th>
                <th>Qualification</th>
                <th>NSS Start Date</th>
                <th>Department Posted</th>
                <th>NSS End Date</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Campus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = $start + 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $sn++ . "</td>";
                echo "<td>" . $row['nss_number'] . "</td>";
                echo "<td>" . $row['full_name'] . "</td>";
                echo "<td>" . $row['dob'] . "</td>";
                echo "<td>" . $row['institution_attended'] . "</td>";
                echo "<td>" . $row['program_studied'] . "</td>";
                echo "<td>" . $row['qualification'] . "</td>";
                echo "<td>" . $row['nss_start_date'] . "</td>";
                echo "<td>" . $row['department_posted'] . "</td>";
                echo "<td>" . $row['nss_end_date'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['campus'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($page - 1); ?>&search=<?php echo $search; ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($page + 1); ?>&search=<?php echo $search; ?>">Next</a>
            </li>
        </ul>
    </nav>

</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> University of Health and Allied Sciences. All rights reserved.</p>
</footer>

</body>
</html>
