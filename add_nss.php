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
    $nss_number = $_POST['nss_number'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $institution_attended = $_POST['institution_attended'];
    $program_studied = $_POST['program_studied'];
    $qualification = $_POST['qualification'];
    $nss_start_date = $_POST['nss_start_date'];
    $department_posted = $_POST['department_posted'];
    $nss_end_date = $_POST['nss_end_date'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $campus = $_POST['campus'];

    // Insert into nss table
    $sql = "INSERT INTO nss (nss_number, full_name, dob, institution_attended, program_studied, 
            qualification, nss_start_date, department_posted, nss_end_date, email, phone, campus) 
            VALUES ('$nss_number', '$full_name', '$dob', '$institution_attended', '$program_studied', 
            '$qualification', '$nss_start_date', '$department_posted', '$nss_end_date', '$email', '$phone', '$campus')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('NSS information added successfully!');</script>";
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
                    $nss_number = $data[0];
                    $full_name = $data[1];
                    $dob = $data[2];
                    $institution_attended = $data[3];
                    $program_studied = $data[4];
                    $qualification = $data[5];
                    $nss_start_date = $data[6];
                    $department_posted = $data[7];
                    $nss_end_date = $data[8];
                    $email = $data[9];
                    $phone = $data[10];
                    $campus = $data[11];

                    // Insert each row of data into the nss table
                    $sql = "INSERT INTO nss (nss_number, full_name, dob, institution_attended, program_studied, 
                            qualification, nss_start_date, department_posted, nss_end_date, email, phone, campus) 
                            VALUES ('$nss_number', '$full_name', '$dob', '$institution_attended', '$program_studied', 
                            '$qualification', '$nss_start_date', '$department_posted', '$nss_end_date', '$email', '$phone', '$campus')";
                    $conn->query($sql);
                }
            }
            fclose($handle);
            echo "<script>alert('Bulk NSS data uploaded successfully!');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid CSV file.');</script>";
    }
}

// Export Template (Download CSV)
if (isset($_GET['export_template'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="nss_template.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['nss_number', 'full_name', 'dob', 'institution_attended', 'program_studied', 
        'qualification', 'nss_start_date', 'department_posted', 'nss_end_date', 'email', 'phone', 'campus']);
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
    <title>Add NSS Personnel</title>
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
    <p>Add NSS Personnel</p>
</header>

<div class="container">
    <a href="nss_staff_mgt.php" class="btn btn-uhas mb-3">Back</a>
    <h2 class="mb-4 text-center">NSS Personnel Form</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nss_number">NSS Number</label>
                    <input type="text" class="form-control" id="nss_number" name="nss_number" required>
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
                    <label for="institution_attended">Institution Attended</label>
                    <input type="text" class="form-control" id="institution_attended" name="institution_attended" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="program_studied">Program Studied</label>
            <input type="text" class="form-control" id="program_studied" name="program_studied" required>
        </div>

        <div class="form-group">
            <label for="qualification">Qualification</label>
            <input type="text" class="form-control" id="qualification" name="qualification" required>
        </div>

        <div class="form-group">
            <label for="nss_start_date">NSS Start Date</label>
            <input type="date" class="form-control" id="nss_start_date" name="nss_start_date" required>
        </div>

        <div class="form-group">
            <label for="department_posted">Department Posted</label>
            <input type="text" class="form-control" id="department_posted" name="department_posted" required>
        </div>

        <div class="form-group">
            <label for="nss_end_date">NSS End Date</label>
            <input type="date" class="form-control" id="nss_end_date" name="nss_end_date" required>
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
            <label for="campus">Campus</label>
            <input type="text" class="form-control" id="campus" name="campus" required>
        </div>

        <button type="submit" class="btn btn-uhas mt-3" name="submit_individual">Add NSS Personnel</button>
    </form>

    <div class="mt-5">
        <h3>Bulk Upload NSS Data</h3>
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
