<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_individual'])) {
    // Get form data
    $staff_id = $_POST['staff_id'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $designation = $_POST['designation'];
    $present_appointment = $_POST['present_appointment'];
    $department = $_POST['department'];
    $highest_qualifications = $_POST['highest_qualifications'];
    $service_end_date = $_POST['service_end_date'];
    $contract_start_date = $_POST['contract_start_date'];
    $contract_end_date = $_POST['contract_end_date'];
    $campus = $_POST['campus'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Handle file upload
    $files = "";
    if (!empty($_FILES['files']['name'])) {
        $target_dir = "uploads/";
        $files = $target_dir . basename($_FILES["files"]["name"]);
        if (!move_uploaded_file($_FILES["files"]["tmp_name"], $files)) {
            $files = "";
        }
    }

    // Insert into casual_staff table
    $sql = "INSERT INTO casual_staff (staff_id, full_name, dob, designation, present_appointment, 
            department, highest_qualifications, service_end_date, contract_start_date, contract_end_date, 
            campus, email, phone, files) 
            VALUES ('$staff_id', '$full_name', '$dob', '$designation', '$present_appointment', 
            '$department', '$highest_qualifications', '$service_end_date', '$contract_start_date', 
            '$contract_end_date', '$campus', '$email', '$phone', '$files')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Casual staff information added successfully!');</script>";
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
                    // Extract CSV columns
                    $staff_id = $data[0];
                    $full_name = $data[1];
                    $dob = $data[2];
                    $designation = $data[3];
                    $present_appointment = $data[4];
                    $department = $data[5];
                    $highest_qualifications = $data[6];
                    $service_end_date = $data[7];
                    $contract_start_date = $data[8];
                    $contract_end_date = $data[9];
                    $campus = $data[10];
                    $email = $data[11];
                    $phone = $data[12];
                    $files = $data[13]; // Assume file path or name from CSV

                    // Insert each row of data into the casual_staff table
                    $sql = "INSERT INTO casual_staff (staff_id, full_name, dob, designation, present_appointment, 
                            department, highest_qualifications, service_end_date, contract_start_date, contract_end_date, 
                            campus, email, phone, files) 
                            VALUES ('$staff_id', '$full_name', '$dob', '$designation', '$present_appointment', 
                            '$department', '$highest_qualifications', '$service_end_date', '$contract_start_date', 
                            '$contract_end_date', '$campus', '$email', '$phone', '$files')";
                    $conn->query($sql);
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk casual staff data uploaded successfully!');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid CSV file.');</script>";
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="casual_staff_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['staff_id', 'full_name', 'dob', 'designation', 'present_appointment', 
        'department', 'highest_qualifications', 'service_end_date', 'contract_start_date', 'contract_end_date', 
        'campus', 'email', 'phone', 'files']);
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
    <title>Add Casual Staff</title>
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
    </style>
</head>
<body>

<header class="uhas-header">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>University of Health and Allied Sciences</h1>
    <p>Add Casual Staff Information</p>
</header>

<div class="container">
    <a href="casual_mgt.php" class="btn btn-uhas mb-3">Back</a>
    <h2 class="mb-4 text-center">Casual Staff Form</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="staff_id">Staff ID</label>
                    <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="present_appointment">Present Appointment</label>
            <input type="date" class="form-control" id="present_appointment" name="present_appointment" required>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>

        <div class="form-group">
            <label for="highest_qualifications">Highest Qualifications</label>
            <input type="text" class="form-control" id="highest_qualifications" name="highest_qualifications" required>
        </div>

        <div class="form-group">
            <label for="service_end_date">Service End Date</label>
            <input type="date" class="form-control" id="service_end_date" name="service_end_date" required>
        </div>

        <div class="form-group">
            <label for="contract_start_date">Contract Start Date</label>
            <input type="date" class="form-control" id="contract_start_date" name="contract_start_date" required>
        </div>

        <div class="form-group">
            <label for="contract_end_date">Contract End Date</label>
            <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" required>
        </div>

        <div class="form-group">
            <label for="campus">Campus</label>
            <input type="text" class="form-control" id="campus" name="campus" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="files">Upload Supporting Documents (Optional)</label>
            <input type="file" class="form-control" id="files" name="files">
        </div>

        <button type="submit" class="btn btn-uhas mt-3" name="submit_individual">Add Casual Staff</button>
    </form>

    <div class="mt-5">
        <h3>Bulk Upload Casual Staff Data</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Upload CSV File</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-uhas mt-3" name="upload_bulk">Upload CSV</button>
        </form>
    </div>

    <div class="mt-3">
        <a href="?export_template=true" class="btn btn-uhas">Export Template</a>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> University of Health and Allied Sciences. All rights reserved.</p>
</footer>

</body>
</html>
