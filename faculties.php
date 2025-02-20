<?php

// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$filter_qualification = "";

// Handle filter submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter'])) {
    $filter_qualification = $_POST['qualification'];
}

// Query to fetch staff based on qualification
$sql = "SELECT id, staff_id, full_name, highest_qualification, department, designation 
        FROM staff";
if (!empty($filter_qualification)) {
    $sql .= " WHERE highest_qualification LIKE '%" . $conn->real_escape_string($filter_qualification) . "%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter by Qualification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        body {
            background-color: #f4f7fc;
        }

        header {
            background-color: #006400;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }

        footer {
    background-color: green;
    color: white;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}


        .btn-uhas {
            background-color: #FFD700;
            color: #006400;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        @media (max-width: 767px) {
            header h1 {
                font-size: 24px;
            }

            table {
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<header class="text-center">
    <img src="uhas_logo.png" alt="UHAS Logo" class="img-fluid" style="max-width: 100px;">
    <h1>University of Health and Allied Sciences</h1>
    <h2>Staff Qualification Filter</h2>
</header>

<div class="container mt-4">
    <form method="POST" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="qualification" class="form-control" placeholder="Enter Qualification to Filter" value="<?= htmlspecialchars($filter_qualification); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" name="filter" class="btn btn-success w-100">Filter</button>
            </div>
        </div>
    </form>

    <div class="mb-3">
        <button class="btn btn-success" onclick="printTable()">Print</button>
        <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
        <a href="home.php" class="btn btn-uhas mb-10">Back to Home</a>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table id="staffTable" class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>S/No</th>
                    <th>Staff ID</th>
                    <th>Full Name</th>
                    <th>Highest Qualification</th>
                    <th>Department</th>
                    <th>Designation</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['staff_id']); ?></td>
                        <td><?= htmlspecialchars($row['full_name']); ?></td>
                        <td><?= htmlspecialchars($row['highest_qualification']); ?></td>
                        <td><?= htmlspecialchars($row['department']); ?></td>
                        <td><?= htmlspecialchars($row['designation']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No staff found with the specified qualification.</div>
    <?php endif; ?>
</div>

<hr>

<footer class="text-center">
    <p>&copy; <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
    // Print Functionality
    function printTable() {
        const printContents = document.getElementById("staffTable").outerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    // Export to Excel Functionality
    function exportToExcel() {
        const table = document.getElementById("staffTable");
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Staff Data" });
        XLSX.writeFile(workbook, "Staff_Data.xlsx");
    }
</script>

</body>
</html>
