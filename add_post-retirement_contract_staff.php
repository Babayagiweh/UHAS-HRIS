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
    $department = $_POST['department'];
    $highest_qualifications = $_POST['highest_qualifications'];
    $date_of_retired = $_POST['date_of_retired'];
    $contract_start_date = $_POST['contract_start_date'];
    $contract_end_date = $_POST['contract_end_date'];
    $campus = $_POST['campus'];
    $email = $_POST['email'];
    $school = $_POST['school'];

// Handle file upload
    $files = "";
    if (!empty($_FILES['files']['name'])) {
        $target_dir = "uploads/";
        $files = $target_dir . basename($_FILES["files"]["name"]);
        if (!move_uploaded_file($_FILES["files"]["tmp_name"], $files)) {
            $files = "";
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
                    $retired_date = $data[7];
                    $contract_start_date = $data[8];
                    $contract_end_date = $data[9];
                    $campus = $data[10];
                    $email = $data[11];
                    $school = $data[12];

                    // Insert each row of data into the post_retirement_contract table
                    $sql = "INSERT INTO post_retirement_contract (staff_id, full_name, dob, designation, 
                            present_appointment, department, highest_qualifications, retired_date, 
                            contract_start_date, contract_end_date, campus, email, school) 
                            VALUES ('$staff_id', '$full_name', '$dob', '$designation', '$present_appointment', 
                            '$department', '$highest_qualifications', '$retired_date', '$contract_start_date', 
                            '$contract_end_date', '$campus', '$email', '$school')";

                    if (!$conn->query($sql)) {
                        echo "Error uploading record for staff ID $staff_id: " . $conn->error . "<br>";
                    }
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk post-retirement data uploaded successfully!');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid CSV file.');</script>";
    }
}


    // Insert into post_retirement_contract table
    $sql = "INSERT INTO post_retirement_contract (staff_id, full_name, dob, designation, department, 
            highest_qualifications, retired_date, contract_start_date, contract_end_date, campus, email, school) 
            VALUES ('$staff_id', '$full_name', '$dob', '$designation', '$department', '$highest_qualifications', 
            '$date_of_retired', '$contract_start_date', '$contract_end_date', '$campus', '$email', '$school')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Staff added to post-retirement contract successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="post_retirement_contract_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['staff_id', 'full_name', 'dob', 'designation', 'department', 
        'highest_qualifications', 'retired_date', 'contract_start_date', 'contract_end_date', 
        'campus', 'email', 'school']);
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
    <title>Add Post-Retirement Contract</title>
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
    <p>Add Post-Retirement Contract</p>
</header>

<div class="container">
    <a href="contracts.php" class="btn btn-uhas mb-3">Back</a>
    <h2 class="mb-4 text-center">Post-Retirement Contract Form</h2>
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
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>

        <div class="form-group">
            <label for="highest_qualifications">Highest Qualifications</label>
            <input type="text" class="form-control" id="highest_qualifications" name="highest_qualifications" required>
        </div>

        <div class="form-group">
            <label for="date_of_retired">Date of Retirement</label>
            <input type="date" class="form-control" id="date_of_retired" name="date_of_retired" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contract_start_date">Contract Start Date</label>
                    <input type="date" class="form-control" id="contract_start_date" name="contract_start_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contract_end_date">Contract End Date</label>
                    <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" required>
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
            <label for="school">School</label>
            <input type="text" class="form-control" id="school" name="school" required>
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="submit_individual" class="btn btn-uhas btn-lg">Submit</button>
        </div>
    </form>

    <div class="mt-4">
        <a href="?export_template=true" class="btn btn-uhas">Export Template</a>
    </div>


 <hr>
<div class="bulk-upload">
    <h3>Bulk Upload Post-Retirement Contract Data</h3>
    <form action="add_post-retirement_contract_staff.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".csv" required>
        <button type="submit" name="upload_bulk" class="btn btn-uhas">Upload File</button>
    </form>
</div>
<hr>


</div>



<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
