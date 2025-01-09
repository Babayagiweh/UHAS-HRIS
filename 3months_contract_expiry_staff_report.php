<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate the range for contracts ending within the next 3 months
$current_date = date('Y-m-d');
$three_months_later = date('Y-m-d', strtotime('+3 months'));

// Query to fetch staff with contracts ending within the next 3 months
$sql = "SELECT *, 
        MONTHNAME(contract_end_date) AS contract_end_month 
        FROM post_retirement_contract 
        WHERE contract_end_date BETWEEN '$current_date' AND '$three_months_later' 
        ORDER BY contract_end_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contracts Due Within 3 Months</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .uhas-header, footer { background-color: green; color: white; }
        .btn-uhas { background-color: green; color: white; }
        .btn-uhas:hover { background-color: #00332c; }
        .table th { background-color: green; color: white; }
        footer { padding: 10px; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

<header class="uhas-header text-center p-3">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>Contracts Due Within 3 Months</h1>
</header>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <a href="contracts.php" class="btn btn-uhas">Back</a>
        <div>
            <button class="btn btn-uhas" id="exportExcel">Export to Excel</button>
            <button class="btn btn-uhas" id="exportPdf">Export to PDF</button>
            <button class="btn btn-uhas" onclick="window.print()">Print</button>
            
        </div>
    </div>

    <table id="contractsTable" class="table table-striped">
        <thead>
            <tr>
                <th>S/No</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Contract End Date</th>
                <th>Contract End Month</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $serial = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $serial++; ?></td>
                        <td><?= $row['staff_id']; ?></td>
                        <td><?= $row['full_name']; ?></td>
                        <td><?= $row['department']; ?></td>
                        <td><?= $row['designation']; ?></td>
                        <td><?= date('Y-m-d', strtotime($row['contract_end_date'])); ?></td>
                        <td><?= $row['contract_end_month']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No contracts ending within the next 3 months.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        $('#contractsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Contracts Due Within 3 Months'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Contracts Due Within 3 Months'
                },
                {
                    extend: 'print',
                    title: 'Contracts Due Within 3 Months'
                }
            ]
        });
    });

    // Export to Excel
    document.getElementById('exportExcel').addEventListener('click', function () {
        $('.buttons-excel').click();
    });

    // Export to PDF
    document.getElementById('exportPdf').addEventListener('click', function () {
        $('.buttons-pdf').click();
    });
</script>
</body>
</html>

