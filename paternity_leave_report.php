<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search functionality
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search_term'];
}

// Fetch data for "Paternity leave" only with optional search
$sql = "SELECT * FROM `leave` WHERE leave_type = 'Paternity leave' AND (full_name LIKE '%$search%' OR staff_id LIKE '%$search%') LIMIT $start, $limit";
$result = $conn->query($sql);

// Total number of records for pagination
$total_sql = "SELECT COUNT(*) AS total FROM `leave` WHERE leave_type = 'Paternity leave' AND (full_name LIKE '%$search%' OR staff_id LIKE '%$search%')";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch all records to generate pagination links
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    $rows = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paternity Leave Report</title>
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
        .form-group label {
            font-weight: bold;
        }
        .table th {
            background-color: #00332c;
            color: white;
        }
    </style>
</head>
<body>

    <header class="uhas-header">
        <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
        <h1>University of Health and Allied Sciences</h1>
        <p>Paternity Leave Report</p>
    </header>

    <div class="container">
        <h2 class="mb-4 text-center">Staff Paternity Leave Data</h2>

        <!-- Search Form -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search_term" value="<?= htmlspecialchars($search); ?>" placeholder="Search by name or staff ID">
                <button class="btn btn-uhas" type="submit" name="search">Search</button>
            </div>
        </form>

        <!-- Export and Print Buttons -->
        <div class="text-center mb-4">
            <button class="btn btn-uhas" onclick="window.print()">Print</button>
            <button class="btn btn-uhas" onclick="exportToExcel()">Export to Excel</button>
            <button class="btn btn-uhas" onclick="exportToPDF()">Export to PDF</button>
        </div>

        <!-- Table to Display Data -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Leave Type</th>
                    <th>Staff ID</th>
                    <th>Full Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Department</th>
                    <th>Campus</th>
                    <th>Appointment</th>
                    <th>Academic Rank</th>
                    <th>Designation</th>
                    <th>Handing Over Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($rows)) {
                    echo "<tr><td colspan='13' class='text-center'>No data found.</td></tr>";
                } else {
                    foreach ($rows as $index => $row) {
                        echo "<tr>";
                        echo "<td>" . (($page - 1) * $limit + $index + 1) . "</td>";
                        echo "<td>" . htmlspecialchars($row['leave_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staff_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['campus']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['present_appointment']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Academic_rank']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['designation']) . "</td>";
                        echo "<td>";
                        if (!empty($row['handing_over_notes'])) {
                            echo "<a href='uploads/" . htmlspecialchars($row['handing_over_notes']) . "' class='btn btn-sm btn-uhas' download>Download</a>";
                        } else {
                            echo "No file";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo "<li class='page-item $active'><a class='page-link' href='paternity_leave_reports.php?page=$i&search_term=$search'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>

        <!-- Back to Leave Reports Button -->
        <div class="text-center mt-4">
            <a href="leave_reports.php" class="btn btn-uhas">Back to Leave Reports</a>
        </div>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Export to Excel and PDF -->
    <script>
        function exportToExcel() {
            var table = document.querySelector("table");
            var wb = XLSX.utils.table_to_book(table, { sheet: "Paternity Leave Data" });
            XLSX.writeFile(wb, "Paternity_Leave_Report.xlsx");
        }

        function exportToPDF() {
            var doc = new jsPDF();
            doc.autoTable({ html: 'table' });
            doc.save('Paternity_Leave_Report.pdf');
        }
    </script>

    <!-- Include XLSX and jsPDF libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>
</html>
