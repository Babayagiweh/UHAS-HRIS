<?php
// Database connection
require_once 'db.connect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM staff WHERE staff_category = 'junior staff'";
$result = $conn->query($sql);
?>
 <header class="text-center mb-4">
            <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
            <h1>University of Health and Allied Sciences</h1>
             <p>HUMAN RESOURCE DIRECTORATE</p>
            <p>PMB 31, Ho, Volta Region, Ghana | +233 (0) 362 196122 | +233 (0) 245 125359</p>
        </header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Staff List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .uhas-header {
            background-color: green;
            color: white;
            padding: 10px;
            text-align: center;
        }
        table.dataTable thead {
            background-color: green;
            color: white;
        }
        .back-button {
            margin: 10px;
            padding: 10px 15px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #003366;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

<div class="uhas-header">
    <h1>Junior Staff List</h1>
</div>

<a href="reports.php" class="back-button">Back</a>

<div class="table-container">
    <table id="staffTable" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>S/NO</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Campus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $count++;
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['staff_id']}</td>
                            <td>{$row['full_name']}</td>
                            <td>{$row['department']}</td>
                            <td>{$row['campus']}</td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<p>Total Number of Junior Staff: <strong><?php echo $count; ?></strong></p>

<footer>
    <p>University of Health and Allied Sciences - ICT Directorate</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function () {
        $('#staffTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            responsive: true,
            paging: true,
            searching: true
        });
    });
</script>

</body>
</html>
