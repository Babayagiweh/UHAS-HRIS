<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "uhashr");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle standard form submission (single entry)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['upload_bulk'])) {
    // Form fields
    $leave_type = $_POST['leave_type'];
    $staff_id = $_POST['staff_id'];
    $full_name = $_POST['full_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $department = $_POST['department'];
    $campus = $_POST['campus'];
    $present_appointment = $_POST['present_appointment'];
    $academic_rank = $_POST['academic_rank'];
    $designation = $_POST['designation'];
    

    // Insert into database
    $sql = "INSERT INTO `leave` (leave_type, staff_id, full_name, start_date, end_date, department, campus, present_appointment, Academic_rank, designation) 
            VALUES ('$leave_type', '$staff_id', '$full_name', '$start_date', '$end_date', '$department', '$campus', '$present_appointment', '$academic_rank', '$designation')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Leave information added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}






// Handle bulk file upload (CSV)
if (isset($_POST['upload_bulk']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file']['tmp_name'];
    $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if ($file_ext == 'csv') {
        if (($handle = fopen($file, "r")) !== FALSE) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row++ > 0) { // Skip the header row
                    $leave_type = $data[0];
                    $staff_id = $data[1];
                    $full_name = $data[2];
                    $start_date = $data[3];
                    $end_date = $data[4];
                    $department = $data[5];
                    $campus = $data[6];
                    $present_appointment = $data[7];
                    $academic_rank = $data[8];
                    $designation = $data[9];

                    // Insert each row of data into the database
                    $sql = "INSERT INTO `leave` (leave_type, staff_id, full_name, start_date, end_date, department, campus, present_appointment, Academic_rank, designation) 
                            VALUES ('$leave_type', '$staff_id', '$full_name', '$start_date', '$end_date', '$department', '$campus', '$present_appointment', '$academic_rank', '$designation')";
                    $conn->query($sql);
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk leave data uploaded successfully!');</script>";
        }
    } else {
        echo "Please upload a valid CSV file.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Leave Application Form</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- UHAS Custom Styles -->
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
       

    </style>
</head>
<body>

    <header class="uhas-header">
        <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
        <h1>University of Health and Allied Sciences</h1>
        <p>Leave Application Form</p>
    </header>

    <div class="container">
        <a href="leave_mgt.php" class="btn btn-uhas mb-3">Back</a>
        <h2 class="mb-4 text-center">Add Approved Staff Leave Details</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave_type">Leave Type</label>
                        <input type="text" class="form-control" id="leave_type" name="leave_type" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="staff_id">Staff ID</label>
                        <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>

            <div class="form-group">
                <label for="campus">Campus</label>
                <input type="text" class="form-control" id="campus" name="campus" required>
            </div>

            <div class="form-group">
                <label for="present_appointment">Present Appointment</label>
                <input type="text" class="form-control" id="present_appointment" name="present_appointment" required>
            </div>

            <div class="form-group">
                <label for="academic_rank">Academic Rank</label>
                <input type="text" class="form-control" id="academic_rank" name="academic_rank" required>
            </div>

            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
            </div>

            


            <div class="text-center mt-4">
                <button type="submit" class="btn btn-uhas btn-lg">Submit Leave Application</button>
            </div>
        </form>

        <div class="mt-4">
            <button class="btn btn-uhas" id="export-template-btn">Export Leave Form Template</button>
            <button class="btn btn-uhas" id="upload-bulk-btn">Upload Bulk Leave Data</button>
<hr>
            <div class="bulk-upload">
        <h3>Bulk Upload Leave Data</h3>
        <form action="add_leave.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept=".csv, .xlsx" required>
            <button type="submit" name="upload_bulk" class="btn btn-uhas">Upload File</button>
        </form>
    </div>
        <hr>
    </div>
        </div>
    </div>



    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Export Leave Form Template as CSV
        document.getElementById('export-template-btn').addEventListener('click', function() {
            const template = [
                ['Leave Type', 'Staff ID', 'Full Name', 'Start Date', 'End Date', 'Department', 'Campus', 'Present Appointment', 'Academic Rank', 'Designation']
            ];

            // Download CSV template
            let csvContent = "data:text/csv;charset=utf-8," 
                + template.map(e => e.join(",")).join("\n");
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "leave_template.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Handle bulk upload (e.g., via file input)
        document.getElementById('upload-bulk-btn').addEventListener('click', function() {
            alert("Please upload your bulk data using the CSV or Excel template.");
        });
    </script>
</body>
</html>
