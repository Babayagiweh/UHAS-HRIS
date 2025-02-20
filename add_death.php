<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for individual deceased
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_individual'])) {
    // Get and sanitize form data
    $staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $hometown = mysqli_real_escape_string($conn, $_POST['hometown']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $staff_category = mysqli_real_escape_string($conn, $_POST['staff_category']);
    $highest_qualifications = mysqli_real_escape_string($conn, $_POST['highest_qualifications']);
    $date_hired = mysqli_real_escape_string($conn, $_POST['date_hired']);
    $years_in_uhas = mysqli_real_escape_string($conn, $_POST['years_in_uhas']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $positions_held = mysqli_real_escape_string($conn, $_POST['positions_held']);
    $date_of_death = mysqli_real_escape_string($conn, $_POST['date_of_death']);
    $grade_retired = mysqli_real_escape_string($conn, $_POST['grade_retired']);
    $campus = mysqli_real_escape_string($conn, $_POST['campus']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Handle file upload
    $files = "";
    if (!empty($_FILES['files']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["files"]["name"]);
        $files = $target_dir . $file_name;
        
        // Validate file type and size
        $file_type = strtolower(pathinfo($files, PATHINFO_EXTENSION));
        $max_file_size = 5 * 1024 * 1024; // 5 MB max file size
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_type, $allowed_types) && $_FILES["files"]["size"] <= $max_file_size) {
            if (!move_uploaded_file($_FILES["files"]["tmp_name"], $files)) {
                $files = "";
                echo "<script>alert('File upload failed.');</script>";
            }
        } else {
            $files = "";
            echo "<script>alert('Invalid file type or file size too large.');</script>";
        }
    }

    // Prepared statement for individual insert
    $stmt = $conn->prepare("INSERT INTO deceased (staff_id, full_name, DoB, hometown, designation, staff_category, 
            highest_qualifications, date_hired, years_in_uhas, department, positions_held, 
            date_of_death, grade_retired, campus, email, phone, file_upload) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssssssissssss", $staff_id, $full_name, $dob, $hometown, $designation, $staff_category, 
        $highest_qualifications, $date_hired, $years_in_uhas, $department, $positions_held, 
        $date_of_death, $grade_retired, $campus, $email, $phone, $files);

    if ($stmt->execute()) {
        echo "<script>alert('Deceased information added successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle bulk file upload (CSV) for deceased
if (isset($_POST['upload_bulk']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file']['tmp_name'];
    $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if ($file_ext == 'csv') {
        if (($handle = fopen($file, "r")) !== FALSE) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row++ > 0) { // Skip the header row
                    // Extract CSV columns and sanitize them
                    $staff_id = mysqli_real_escape_string($conn, $data[0]);
                    $full_name = mysqli_real_escape_string($conn, $data[1]);
                    $dob = mysqli_real_escape_string($conn, $data[2]);
                    $hometown = mysqli_real_escape_string($conn, $data[3]);
                    $designation = mysqli_real_escape_string($conn, $data[4]);
                    $staff_category = mysqli_real_escape_string($conn, $data[5]);
                    $highest_qualifications = mysqli_real_escape_string($conn, $data[6]);
                    $date_hired = mysqli_real_escape_string($conn, $data[7]);
                    $years_in_uhas = mysqli_real_escape_string($conn, $data[8]);
                    $department = mysqli_real_escape_string($conn, $data[9]);
                    $positions_held = mysqli_real_escape_string($conn, $data[10]);
                    $date_of_death = mysqli_real_escape_string($conn, $data[11]);
                    $grade_retired = mysqli_real_escape_string($conn, $data[12]);
                    $campus = mysqli_real_escape_string($conn, $data[13]);
                    $email = mysqli_real_escape_string($conn, $data[14]);
                    $phone = mysqli_real_escape_string($conn, $data[15]);

                    // Insert each row of data into the deceased table using prepared statements
                    $stmt = $conn->prepare("INSERT INTO deceased (staff_id, full_name, DoB, hometown, designation, staff_category, 
                            highest_qualifications, date_hired, years_in_uhas, department, positions_held, 
                            date_of_death, grade_retired, campus, email, phone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $stmt->bind_param("issssssssissssss", $staff_id, $full_name, $dob, $hometown, $designation, $staff_category, 
                        $highest_qualifications, $date_hired, $years_in_uhas, $department, $positions_held, 
                        $date_of_death, $grade_retired, $campus, $email, $phone);

                    $stmt->execute();
                    $stmt->close();
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk deceased data uploaded successfully!');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid CSV file.');</script>";
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="deceased_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['staff_id', 'full_name', 'dob', 'hometown', 'designation', 'staff_category', 
        'highest_qualifications', 'date_hired', 'years_in_uhas', 'department', 'positions_held', 
        'date_of_death', 'grade_retired', 'campus', 'email', 'phone']);
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
    <title>Add Deceased Information</title>
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
    <p>Add Deceased Information</p>
</header>

<div class="container">
    <a href="death_mgt.php" class="btn btn-uhas mb-3">Back</a>
    <h2 class="mb-4 text-center">Deceased Information Form</h2>
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
            <label for="years_in_uhas">Years in UHAS</label>
            <input type="number" class="form-control" id="years_in_uhas" name="years_in_uhas" required>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>

        <div class="form-group">
            <label for="positions_held">Positions Held</label>
            <input type="text" class="form-control" id="positions_held" name="positions_held" required>
        </div>

        <div class="form-group">
            <label for="date_of_death">Date of Death</label>
            <input type="date" class="form-control" id="date_of_death" name="date_of_death" required>
        </div>

        <div class="form-group">
            <label for="grade_retired">Grade at Retirement</label>
            <input type="text" class="form-control" id="grade_retired" name="grade_retired" required>
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
            <label for="phone">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="files">Upload File</label>
            <input type="file" class="form-control" id="files" name="files">
        </div>

        <button type="submit" class="btn btn-uhas mt-3" name="submit_individual">Submit Deceased</button>
    </form>

    <hr>

    <h3>Bulk Upload CSV File</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Upload CSV File</label>
            <input type="file" class="form-control" name="file" id="file" required>
        </div>
        <button type="submit" class="btn btn-uhas mt-3" name="upload_bulk">Upload CSV</button>
    </form>

    <hr>

    <h3>Download CSV Template</h3>
    <a href="?export_template=true" class="btn btn-uhas mt-3">Download Template</a>

</div>

<footer>
    <p>University of Health and Allied Sciences (UHAS) | All rights reserved</p>
</footer>

</body>
</html>
