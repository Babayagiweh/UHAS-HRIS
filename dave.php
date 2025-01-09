<?php 
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all staff where campus is 'Dave Campus'
$sql = "SELECT staff_id, full_name, department, campus, date_on_present_grade, highest_qualification, dob, gender 
        FROM staff 
        WHERE campus = 'Dave'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List - Dave Campus</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /* UHAS Colors */
        body {
            background-color: #f8f9fa;
        }
        .uhas-header {
            background-color: green;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        .btn-uhas {
            background-color: green;
            color: #fff;
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
    </style>
</head>
<body>
    <header class="text-center mb-4">
        <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
        <h1>University of Health and Allied Sciences</h1>
        <p>HUMAN RESOURCE DIRECTORATE</p>
        <p>PMB 31, Ho, Volta Region, Ghana | +233 (0) 362 196122 | +233 (0) 245 125359</p>
    </header>

    <div class="uhas-header">
        <h1>Staff List - Dave Campus</h1>
    </div>

    <div class="container my-4">
        <a href="campuses.php" class="btn btn-uhas mb-3">Back</a>
        <table id="staffTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S/NO</th>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>School|Dir|Inst|Office</th>
                    <th>Date on Present Grade</th>
                    <th>Age</th>
                    <th>Highest Qualification</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Calculate age if 'dob' column is present
                        $age = "N/A"; // Default value if dob is not set or invalid
                        if (!empty($row['dob'])) {
                            $birthDate = new DateTime($row['dob']);
                            $currentDate = new DateTime();
                            $age = $birthDate->diff($currentDate)->y; // Calculate age in years
                        }

                        echo "<tr>
                                <td>" . ++$count . "</td>
                                <td>" . htmlspecialchars($row['staff_id']) . "</td>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td>" . htmlspecialchars($row['department']) . "</td>
                                <td>" . htmlspecialchars($row['date_on_present_grade']) . "</td>
                                <td>" . $age . "</td>
                                <td>" . htmlspecialchars($row['highest_qualification']) . "</td>
                                <td>" . htmlspecialchars($row['gender']) . "</td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <p class="text-end"><strong>Total Staff:</strong> <?= $count; ?></p>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#staffTable').DataTable({
                dom: 'Bfrtip', // Add export buttons
                buttons: [
                    {
                        extend: 'print',
                        title: 'Staff List - Hohoe Campus'
                    }, 
                    {
                        extend: 'excel',
                        title: 'Staff_Hohoe_Campus'
                    },
                    {
                        extend: 'csv',
                        title: 'Staff_Hohoe_Campus'
                    },
                    {
                        extend: 'pdf',
                        title: 'Staff List - Hohoe Campus'
                    }
                ],
                paging: true,
                searching: true,
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
