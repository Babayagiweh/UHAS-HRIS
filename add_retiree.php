
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
    $hometown = $_POST['hometown'];
    $designation = $_POST['designation'];
    $staff_category = $_POST['staff_category'];
    $highest_qualifications = $_POST['highest_qualifications'];
    $date_hired = $_POST['date_hired'];
    $years_in_uhas = $_POST['years_in_uhas'];
    $department = $_POST['department'];
    $positions_held = $_POST['positions_held'];
    $date_of_retired = $_POST['date_of_retired'];
    $grade_retired = $_POST['grade_retired'];
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

    // Insert into retiree table
    $sql = "INSERT INTO retiree (staff_id, fullname, DoB, hometown, designation, staff_category, 
            highest_qualifications, date_hired, years_in_uhas, department, positions_held, 
            date_of_retired, grade_retired, campus, email, phone, files) 
            VALUES ('$staff_id', '$full_name', '$dob', '$hometown', '$designation', '$staff_category', 
            '$highest_qualifications', '$date_hired', '$years_in_uhas', '$department', '$positions_held', 
            '$date_of_retired', '$grade_retired', '$campus', '$email', '$phone', '$files')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Retiree information added successfully!');</script>";
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
                    $hometown = $data[3];
                    $designation = $data[4];
                    $staff_category = $data[5];
                    $highest_qualifications = $data[6];
                    $date_hired = $data[7];
                    $years_in_uhas = $data[8];
                    $department = $data[9];
                    $positions_held = $data[10];
                    $date_of_retired = $data[11];
                    $grade_retired = $data[12];
                    $campus = $data[13];
                    $email = $data[14];
                    $phone = $data[15];
                    $files = $data[16]; // Assume file path or name from CSV

                    // Insert each row of data into the retiree table
                    $sql = "INSERT INTO retiree (staff_id, fullname, DoB, hometown, designation, staff_category, 
                            highest_qualifications, date_hired, years_in_uhas, department, positions_held, 
                            date_of_retired, grade_retired, campus, email, phone, files) 
                            VALUES ('$staff_id', '$full_name', '$dob', '$hometown', '$designation', '$staff_category', 
                            '$highest_qualifications', '$date_hired', '$years_in_uhas', '$department', '$positions_held', 
                            '$date_of_retired', '$grade_retired', '$campus', '$email', '$phone', '$files')";
                    $conn->query($sql);
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk retiree data uploaded successfully!');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid CSV file.');</script>";
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="retiree_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['staff_id', 'full_name', 'dob', 'hometown', 'designation', 'staff_category', 
        'highest_qualifications', 'date_hired', 'years_in_uhas', 'department', 'positions_held', 
        'date_of_retired', 'grade_retired', 'campus', 'email', 'phone', 'files']);
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
    <title>Add Retiree</title>
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
    <p>Add Retiree Information</p>
</header>

<div class="container">
    <a href="retired_mgt.php" class="btn btn-uhas mb-3">Back</a>
    <h2 class="mb-4 text-center">Retiree Form</h2>
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
                    <label for="hometown">Hometown</label>
                    <input type="text" class="form-control" id="hometown" name="hometown" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="designation">Designation</label>
            <input type="text" class="form-control" id="designation" name="designation" required>
        </div>

        <div class="form-group">
            <label for="staff_category">Staff Category</label>
            <input type="text" class="form-control" id="staff_category" name="staff_category" required>
        </div>

        <div class="form-group">
            <label for="highest_qualifications">Highest Qualifications</label>
            <input type="text" class="form-control" id="highest_qualifications" name="highest_qualifications" required>
        </div>

        <div class="form-group">
            <label for="date_hired">Date Hired</label>
            <input type="date" class="form-control" id="date_hired" name="date_hired" required>
        </div>

        <div class="form-group">
            <label for="years_in_uhas">Number of Years in UHAS</label>
            <input type="number" class="form-control" id="years_in_uhas" name="years_in_uhas" required>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>

        <div class="form-group">
            <label for="positions_held">Positions Held</label>
            <textarea class="form-control" id="positions_held" name="positions_held" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_of_retired">Date of Retirement</label>
                    <input type="date" class="form-control" id="date_of_retired" name="date_of_retired" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="grade_retired">Grade Retired</label>
                    <input type="text" class="form-control" id="grade_retired" name="grade_retired" required>
                </div>
            </div>
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
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="files">Supporting Documents</label>
            <input type="file" class="form-control" id="files" name="files">
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-uhas btn-lg">Submit</button>
        </div>
    </form>
    <div class="mt-4">
            <a href="?export_template=true" class="btn btn-uhas">Export Template</a>
        </div>

        <!-- Bulk upload and template export buttons -->
        <hr>
        <div class="bulk-upload">
            <h3>Bulk Upload Retiree Data</h3>
            <form action="add_retiree.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" accept=".csv, .xlsx" required>
                <button type="submit" name="upload_bulk" class="btn btn-uhas">Upload File</button>
            </form>
        </div>
        <hr>
    </div>

</div>



<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
