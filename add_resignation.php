<?php 
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle standard form submission (single entry)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['upload_bulk'])) {
    // Form fields
    $staff_id = $_POST['staff_id'];
    $title = $_POST['title'];
    $full_name = $_POST['full_name'];
    $designation = $_POST['designation'];
    $present_appointment = $_POST['present_appointment'];
    $date_hired = $_POST['date_hired'];
    $department = $_POST['department'];
    $date_on_present_grade = $_POST['date_on_present_grade'];
    $academic_rank = $_POST['academic_rank'];
    $dob = $_POST['dob'];
    $reason_of_resignation = $_POST['reason_of_resignation'];
    $effective_date = $_POST['effective_date'];
    $email_official = $_POST['email_official'];
    $email_private = $_POST['email_private'];
    $files = $_POST['files']; // This could be a file upload or a path to a file
    $campus = $_POST['campus'];

    // Insert into resignation table
    $sql = "INSERT INTO resignation (staff_id, title, full_name, designation, present_appointment, date_hired, department, 
            date_on_present_grade, academic_rank, dob, reason_of_resignation, email_official, email_private, files, campus) 
            VALUES ('$staff_id', '$title', '$full_name', '$designation', '$present_appointment', '$date_hired', '$department', 
            '$date_on_present_grade', '$academic_rank', '$dob', '$reason_of_resignation', '$effective_date', $email_official', '$email_private', 
            '$files', '$campus')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Resignation information added successfully!');</script>";
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
                    $title = $data[1];
                    $full_name = $data[2];
                    $designation = $data[3];
                    $present_appointment = $data[4];
                    $date_hired = $data[5];
                    $department = $data[6];
                    $date_on_present_grade = $data[7];
                    $academic_rank = $data[8];
                    $dob = $data[9];
                    $reason_of_resignation = $data[10];
                    $effective_date = $data[11];
                    $email_official = $data[12];
                    $email_private = $data[13];
                    $files = $data[14]; // Assume file path or name from CSV
                    $campus = $data[15];

                    // Insert each row of data into the resignation table
                    $sql = "INSERT INTO resignation (staff_id, title, full_name, designation, present_appointment, date_hired, department, 
                            date_on_present_grade, academic_rank, dob, reason_of_resignation, email_official, email_private, files, campus) 
                            VALUES ('$staff_id', '$title', '$full_name', '$designation', '$present_appointment', '$date_hired', '$department', 
                            '$date_on_present_grade', '$academic_rank', '$dob', '$reason_of_resignation', '$effective_date' '$email_official', '$email_private', 
                            '$files', '$campus')";
                    $conn->query($sql);
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk resignation data uploaded successfully!');</script>";
        }
    } else {
        echo "Please upload a valid CSV file.";
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="resignation_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['staff_id', 'title', 'full_name', 'designation', 'present_appointment', 'date_hired', 'department', 'date_on_present_grade', 'academic_rank', 'dob', 'reason_of_resignation', 'effective_date', 'email_official', 'email_private', 'files', 'campus']);
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
    <title>Staff Resignation Form</title>
    
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
        <p>Staff Resignation Form</p>
    </header>

    <div class="container">
        <a href="resignation_mgt.php" class="btn btn-uhas mb-3">Back</a>
        <h2 class="mb-4 text-center">Add Resignation Details</h2>

        <form method="POST" enctype="multipart/form-data">
            <!-- Form Fields for Resignation -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="staff_id">Staff ID</label>
                        <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>

            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
            </div>

            <div class="form-group">
                <label for="present_appointment">Present Appointment</label>
                <input type="text" class="form-control" id="present_appointment" name="present_appointment" required>
            </div>

            <div class="form-group">
                <label for="date_hired">Date Hired</label>
                <input type="date" class="form-control" id="date_hired" name="date_hired" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>

            <div class="form-group">
                <label for="date_on_present_grade">Date on Present Grade</label>
                <input type="date" class="form-control" id="date_on_present_grade" name="date_on_present_grade" required>
            </div>

            <div class="form-group">
                <label for="academic_rank">Academic Rank</label>
                <input type="text" class="form-control" id="academic_rank" name="academic_rank" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="reason_of_resignation">Reason of Resignation</label>
                <textarea class="form-control" id="reason_of_resignation" name="reason_of_resignation" required></textarea>
            </div>
            <div class="form-group">
                <label for="effective_date">Effective Date</label>
                <input type="date" class="form-control" id="effective_date" name="effective_date" required>
            </div>

            <div class="form-group">
                <label for="email_official">Official Email</label>
                <input type="email" class="form-control" id="email_official" name="email_official" required>
            </div>

            <div class="form-group">
                <label for="email_private">Private Email</label>
                <input type="email" class="form-control" id="email_private" name="email_private" required>
            </div>

            <div class="form-group">
                <label for="files">Supporting Documents</label>
                <input type="file" class="form-control" id="files" name="files">
            </div>

            <div class="form-group">
                <label for="campus">Campus</label>
                <input type="text" class="form-control" id="campus" name="campus" required>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-uhas btn-lg">Submit Resignation</button>
            </div>
        </form>
 <div class="mt-4">
            <a href="?export_template=true" class="btn btn-uhas">Export Template</a>
        </div>

        <!-- Bulk upload and template export buttons -->
        <hr>
        <div class="bulk-upload">
            <h3>Bulk Upload Resignation Data</h3>
            <form action="add_resignation.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" accept=".csv, .xlsx" required>
                <button type="submit" name="upload_bulk" class="btn btn-uhas">Upload File</button>
            </form>
        </div>
        <hr>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
