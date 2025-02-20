<?php
// Include database connection
include('config.php');

// Fetch distinct departments from the staff table
$query = "SELECT DISTINCT department FROM staff";
$departments_stmt = $pdo->prepare($query);
$departments_stmt->execute();
$departments = $departments_stmt->fetchAll();

// Get the selected department from the URL if any
$selected_department = isset($_GET['department']) ? $_GET['department'] : null;
$staff_details = [];

if ($selected_department) {
    // Fetch staff details based on the selected department
    $query = "SELECT * FROM staff WHERE department = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$selected_department]);
    $staff_details = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments - UHAS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsPDF/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg.jpg');
        }
        .navbar {
            background-color: green;
        }
        .navbar-brand {
            color: #FFFFFF;
        }
        footer {
            background-color: green;
        }
        .card {
            border: 1px solid green;
        }
        .btn {
            border-radius: 20px;
            color: ;
        }
        #staffTable {
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            text-align: center;
        }
        #staffTable_length {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-green">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">UHAS-HR</a>
    </div>
</nav>

<?php if ($selected_department): ?>
    <!-- Staff Table -->
    <div class="container my-5">
        <h2 class="text-center mb-4"><?= htmlspecialchars($selected_department); ?> Staff</h2>
        
        <button id="backButton" class="btn btn-secondary mb-4">Back to Department Section</button>
        
        <table id="staffTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S/No</th>
                    <th>Staff ID</th>
                    <th>Title</th>
                    <th>Fullname</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Qualification</th>
                    <th>Appointment</th>
                    <th>Speciality</th>
                    <th>Category</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff_details as $index => $staff): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($staff['staff_id']); ?></td>
                        <td><?= htmlspecialchars($staff['title']); ?></td>
                        <td><?= htmlspecialchars($staff['full_name']); ?></td>
                        <td><?= htmlspecialchars($staff['dob']); ?></td>
                        <td><?= htmlspecialchars($staff['employee_status']); ?></td>
                        <td><?= htmlspecialchars($staff['campus']); ?></td>
                        <td><?= htmlspecialchars($staff['highest_qualification']); ?></td>
                        <td><?= htmlspecialchars($staff['present_appointment']); ?></td>
                        <td><?= htmlspecialchars($staff['speciality']); ?></td>
                        <td><?= htmlspecialchars($staff['staff_category']); ?></td>
                        <td><?= htmlspecialchars($staff['email_official']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Options -->
        <div class="d-flex justify-content-between">
            <button id="printButton" class="btn btn-success">Print</button>
            <button id="exportExcel" class="btn btn-warning">Export to Excel</button>
            <button id="exportPdf" class="btn btn-danger">Export to PDF</button>
        </div>
    </div>

<?php else: ?>
    <!-- Department List -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Schhols |Directorate |Departments |Institutes | Offices | Units | Centers | Sections</h2>
        
        <div class="row">
            <?php foreach ($departments as $department): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($department['department']); ?></h5>
                            <a href="departments.php?department=<?= urlencode($department['department']); ?>" class="btn btn-success">View Staff</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Footer -->
<footer class="bg-yellow text-white text-center py-3">
    <p>&copy;  <?= date("Y"); ?>  University of Health and Allied Sciences | <a href="https://www.uhas.edu.gh" target="_blank" class="text-white">Visit UHAS</a></p>
</footer>

<script>
    $(document).ready(function() {
        // Back to home button
        $('#backButton').click(function() {
            window.location.href = 'departments.php';
        });

        // Print button
        $('#printButton').click(function() {
            window.print();
        });

        // Export to Excel
        $('#exportExcel').click(function() {
            var table = document.getElementById('staffTable');
            var wb = XLSX.utils.table_to_book(table, {sheet: "Staff Data"});
            XLSX.writeFile(wb, 'staff_data.xlsx');
        });

        // Export to PDF
        $('#exportPdf').click(function() {
            const { jsPDF } = window.jspdf;
            var doc = new jsPDF();
            doc.autoTable({ html: '#staffTable' });
            doc.save('staff_data.pdf');
        });

        // DataTable (Pagination and Search)
        $('#staffTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10
        });
    });
</script>

</body>
</html>
