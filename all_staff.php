<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch staff data
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Staff Members</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f9f9f9;
            background-image: url('bg.jpg'); /* Use the correct image file name */
            background-size: cover;
            background-position: center;
        }

        header {
            background-color: #006400;
            color: #FFD700;
            padding: 20px;
            border-radius: 8px;
        }

        table.dataTable thead {
            background-color: #006400;
            color: white;
        }

        .btn {
            margin: 5px;
        }

        .footer-custom {
            background-color: #006400;
            color: white;
            padding: 15px;
            font-size: 14px;
        }

        .footer-custom p {
            margin: 0;
        }

        /* Ensure that text on background image is readable */
        header p {
            color: white;
        }

        /* Make sure the page layout is responsive */
        @media (max-width: 767px) {
            header h1 {
                font-size: 24px;
            }

            table {
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
    
    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
    <div class="container-fluid my-5">
        <!-- Header -->
        <header class="text-center mb-4">
            <img src="uhas_logo.png" alt="UHAS Logo" class="img-fluid" style="max-width: 150px;">
            <h1>University of Health and Allied Sciences</h1>
            <p>DIRECTORATE OF HUMAN RESOURCE</p>
            <p>PMB 31, Ho, Volta Region, Ghana | +233 (0) 362 196122 | +233 (0) 245 125359</p>
        </header>

        <!-- Staff Table -->
        <div class="table-responsive">
            <table id="staffTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Designation | Rank</th>
                        <th>Present Appointment</th>
                        <th>Date on Present Appointment</th>
                        <th>School|Dir|Insti|Office</th>
                        <th>Staff Category</th>
                        <th>Academic Rank</th>
                        <th>Campus</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>DOB</th>
                        <th>Contract End</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$sno}</td>
                                <td>{$row['staff_id']}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['designation']}</td>
                                <td>{$row['present_appointment']}</td>
                                <td>{$row['date_on_present_grade']}</td>
                                <td>{$row['department']}</td>
                                <td>{$row['staff_category']}</td>
                                <td>{$row['highest_qualification']}</td>
                                <td>{$row['campus']}</td>
                                <td>{$row['email_official']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['dob']}</td>
                                <td>{$row['end_of_contract_date']}</td>
                            </tr>";
                            $sno++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Buttons for Exporting and Printing -->
        <div class="d-flex flex-wrap mt-4">
            <!-- Form for Printing -->
            <form id="printForm" action="print.php" method="POST" target="_blank">
                <input type="hidden" name="content" id="printContent">
                <button type="button" class="btn btn-primary" onclick="preparePrintContent()">Print</button>
            </form>
            <button class="btn btn-success" id="exportExcel">Export to Excel</button>
            <button class="btn btn-danger" id="exportPDF">Export to PDF</button>
            <a href="home.php" class="btn btn-secondary">Back to Homepage</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5 footer-custom">
        <p>&copy; <?php echo date("Y"); ?> UHAS HR Directorate. All rights reserved.</p>
    </footer>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#staffTable').DataTable({
                paging: true,
                searching: true,
                ordering: true
            });
        });

        // Export to Excel
        $('#exportExcel').click(function() {
            const wb = XLSX.utils.table_to_book(document.getElementById('staffTable'));
            XLSX.writeFile(wb, 'staff_directory.xlsx');
        });

        // Export to PDF
        $('#exportPDF').click(function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text("University of Health and Allied Sciences Staff Directory", 10, 10);
            const elem = document.getElementById('staffTable');
            doc.autoTable({ html: elem });
            doc.save("staff_directory.pdf");
        });

        // Prepare for printing
        function preparePrintContent() {
            const tableHTML = document.querySelector('#staffTable').outerHTML;
            document.getElementById('printContent').value = tableHTML;
            document.getElementById('printForm').submit();
        }
    </script>
</body>

</html>
