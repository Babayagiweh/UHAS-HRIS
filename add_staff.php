<?php
// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'uhashr');

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $staff_id = $mysqli->real_escape_string($_POST['staff_id'] ?? '');
    $controller_no = $mysqli->real_escape_string($_POST['controller_no'] ?? '');
    $ghanacard_no = $mysqli->real_escape_string($_POST['ghanacard_no'] ?? '');
    $first_name = $mysqli->real_escape_string($_POST['first_name'] ?? '');
    $middle_name = $mysqli->real_escape_string($_POST['middle_name'] ?? '');
    $last_name = $mysqli->real_escape_string($_POST['last_name'] ?? '');
    $title = $mysqli->real_escape_string($_POST['tittle'] ?? '');
    $full_name = $mysqli->real_escape_string($_POST['full_name'] ?? '');
    $dob = $mysqli->real_escape_string($_POST['dob'] ?? '');
    $gender = $mysqli->real_escape_string($_POST['gender'] ?? '');
    $marital_status = $mysqli->real_escape_string($_POST['marital_status'] ?? '');
    
    // Fetch corresponding names for dropdown selections
    $uhas_designation_id = $mysqli->real_escape_string($_POST['uhas_designation'] ?? '');
    $department_id = $mysqli->real_escape_string($_POST['department'] ?? '');
    $campus_id = $mysqli->real_escape_string($_POST['campus'] ?? '');
    $staff_category_id = $mysqli->real_escape_string($_POST['uhas_staff_category'] ?? '');
    
    $uhas_designation = '';
    $designation_result = $mysqli->query("SELECT designation_name FROM uhas_designation WHERE id = '$uhas_designation_id'");
    if ($designation_result && $designation_row = $designation_result->fetch_assoc()) {
        $uhas_designation = $designation_row['designation_name'];
    }

    $department = '';
    $department_result = $mysqli->query("SELECT department_name FROM departments WHERE dept_id = '$department_id'");
    if ($department_result && $department_row = $department_result->fetch_assoc()) {
        $department = $department_row['department_name'];
    }

    $campus = '';
    $campus_result = $mysqli->query("SELECT name FROM campus WHERE id = '$campus_id'");
    if ($campus_result && $campus_row = $campus_result->fetch_assoc()) {
        $campus = $campus_row['name'];
    }

    $staff_category = '';
    $staff_category_result = $mysqli->query("SELECT name FROM uhas_staff_category WHERE id = '$staff_category_id'");
    if ($staff_category_result && $staff_category_row = $staff_category_result->fetch_assoc()) {
        $staff_category = $staff_category_row['name'];
    }

    // Other fields
    $phone = $mysqli->real_escape_string($_POST['phone'] ?? '');
    $email_official = $mysqli->real_escape_string($_POST['email_official'] ?? '');
    $email_private = $mysqli->real_escape_string($_POST['email_private'] ?? '');
    $hometown = $mysqli->real_escape_string($_POST['hometown'] ?? '');
    $highest_qualification = $mysqli->real_escape_string($_POST['highest_qualification'] ?? '');
    $qualifications = $mysqli->real_escape_string($_POST['qualifications'] ?? '');
    $details_of_highest_qualification = $mysqli->real_escape_string($_POST['details_of_highest_qualification'] ?? '');
    $speciality = $mysqli->real_escape_string($_POST['speciality'] ?? '');
    $first_appointment = $mysqli->real_escape_string($_POST['first_appointment'] ?? '');
    $date_hired = $mysqli->real_escape_string($_POST['date_hired'] ?? '');
    $assumption_of_duty_date = $mysqli->real_escape_string($_POST['assumption_of_duty_date'] ?? '');
    $other_appointment = $mysqli->real_escape_string($_POST['other_appointment'] ?? '');
    $from_appointment = $mysqli->real_escape_string($_POST['from_appointment'] ?? '');
    $to_appointment = $mysqli->real_escape_string($_POST['to_appointment'] ?? '');
    $directory = $mysqli->real_escape_string($_POST['directory'] ?? '');
    $gog_unit = $mysqli->real_escape_string($_POST['gog_unit'] ?? '');
    $end_of_contract_date = $mysqli->real_escape_string($_POST['end_of_contract_date'] ?? '');
    $years_with_uhas = $mysqli->real_escape_string($_POST['years_with_uhas'] ?? '');
    $birthday = $mysqli->real_escape_string($_POST['birthday'] ?? '');

    // Handle file upload
    $files = '';
    if (isset($_FILES['files']) && $_FILES['files']['error'] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['files']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) {
            $files = $file_name;
        }
    }

    // SQL query to insert data
    $sql = "INSERT INTO staff (staff_id, controller_no, ghanacard_no, first_name, middle_name, last_name, title, full_name, dob, gender, marital_status, designation, department, phone, email_official, email_private, hometown, highest_qualification, qualifications, details_of_highest_qualification, speciality, first_appointment, date_hired, assumption_of_duty_date, other_appointment, from_appointment, to_appointment, staff_category, directory, gog_unit, campus, end_of_contract_date, years_with_uhas, birthday, files) 
            VALUES ('$staff_id', '$controller_no', '$ghanacard_no', '$first_name', '$middle_name', '$last_name', '$title', '$full_name', '$dob', '$gender', '$marital_status', '$uhas_designation', '$department', '$phone', '$email_official', '$email_private', '$hometown', '$highest_qualification', '$qualifications', '$details_of_highest_qualification', '$speciality', '$first_appointment', '$date_hired', '$assumption_of_duty_date', '$other_appointment', '$from_appointment', '$to_appointment', '$staff_category', '$directory', '$gog_unit', '$campus', '$end_of_contract_date', '$years_with_uhas', '$birthday', '$files')";

    // Execute the query
    if ($mysqli->query($sql) === TRUE) {
        echo "New staff added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

// Fetch data for dropdowns
$campuses = $mysqli->query("SELECT id, name FROM campus");
$departments = $mysqli->query("SELECT dept_id, department_name FROM departments");
$designations = $mysqli->query("SELECT id, designation_name FROM uhas_designation");
$qualificationsQuery = $mysqli->query("SELECT id_highest_qualification, highest_qualification_name FROM highest_qualification");
$staffCategoriesQuery = $mysqli->query("SELECT id, name FROM uhas_staff_category");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: light;
            background-image: url('bg.jp');
        }
        .form-section {
            margin-bottom: 30px;
            border-bottom: 2px solid #FFD700;
            padding-bottom: 20px;
        }
        .form-section h5 {
            margin-bottom: 20px;
            color: #006B3F;
            text-align: center;
            font-weight: bold;
        }
        .footer {
            background-color: #006B3F;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 30px;
        }
        .btn-primary {
            background-color: #006B3F;
            border: none;
            align-items: center;
        }
        .btn-primary:hover {
            background-color: #004C2B;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center" style="color: #006B3F;">ADD NEW STAFF</h2>
    <form action="add_staff.php" method="POST" enctype="multipart/form-data">
        <hr>
        <br>
        <!-- Basic Details -->
        <div class="form-section">
            <h5>Unique Basic Details</h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="staff_id" class="form-label">Staff ID *</label>
                    <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                </div>
                <div class="col-md-6">
                    <label for="controller_no" class="form-label">Controller ID *</label>
                    <input type="text" class="form-control" id="controller_no" name="controller_no" required>
                </div>
                 <div class="col-md-6">
                    <label for="ghanacard_no" class="form-label">Ghana Card No *</label>
                    <input type="text" class="form-control" id="ghanacard_no" name="ghanacard_no" required>
                </div>

                
            </div>
        </div>

        <!-- Personal Information -->
        <div class="form-section">
            <h5>Personal Information</h5>
            <div class="row">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name *</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="col-md-4">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name">
                </div>
                <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name *</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="col-md-4">
    <label for="tittle" class="form-label">Title |Suffix *</label>
    <input type="text" class="form-control" id="tittle" name="tittle" required>
</div>

                 <div class="col-md-4">
    <label for="full_name" class="form-label">Full Name *</label>
    <input type="text" class="form-control" id="full_name" name="full_name" required>
</div>


            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="dob" class="form-label">Date of Birth *</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender *</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="marital_status" class="form-label">Marital Status *</label>
                    <select class="form-select" id="marital_status" name="marital_status" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <div class="form-section">
            <h5>Employment Details</h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="uhas_designation" class="form-label">Designation *</label>
                    <select class="form-select" id="uhas_designation" name="uhas_designation" required>
                        <option value="" selected disabled>Choose...</option>
                        <?php while ($row = $designations->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['designation_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="department" class="form-label">Department |Directorate |Institute |School |Unit |Section *</label>
                    <select class="form-select" id="department" name="department" required>
                        <option value="" selected disabled>Choose...</option>
                        <?php while ($row = $departments->fetch_assoc()): ?>
                            <option value="<?= $row['dept_id'] ?>"><?= $row['department_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <h5>Contact Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number: *</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="col-md-6">
                    <label for="email_official" class="form-label">Official Email *</label>
                    <input type="email" class="form-control" id="email_official" name="email_official" required>
                </div>
            </div>
            <div class="row">
        <div class="col-md-6">
            <label for="email_private" class="form-label">Private Email</label>
            <input type="email" class="form-control" id="email_private" name="email_private">
        </div>
    </div>
        </div>

        <!-- Additional Details -->
        <div class="form-section">
            <h5>Additional Details</h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="hometown" class="form-label">Hometown *</label>
                    <input type="text" class="form-control" id="hometown" name="hometown" required>
                </div>
               <div class="col-md-6">
    <label for="highest_qualification" class="form-label">Highest Qualification *</label>
    <select class="form-select" id="highest_qualification" name="highest_qualification" required>
        <option value="" selected disabled>Choose...</option>
        <?php while ($row = $qualificationsQuery->fetch_assoc()): ?>
            <option value="<?= $row['id_highest_qualification'] ?>"><?= $row['highest_qualification_name'] ?></option>
        <?php endwhile; ?>
    </select>
</div>

                <div class="col-md-6">
                    <label for="qualifications" class="form-label">Qualifications *</label>
                    <input type="text" class="form-control" id="qualifications" name="qualifications" required>
                </div>
                <div class="col-md-6">
                    <label for="details_of_highest_qualification" class="form-label">Details of Highest Qualification</label>
                    <input type="text" class="form-control" id="details_of_highest_qualification" name="details_of_highest_qualification">
                </div>
                <div class="col-md-6">
                    <label for="speciality" class="form-label">Speciality | Area of Study</label>
                    <input type="text" class="form-control" id="speciality" name="speciality">
                </div>
                <div class="col-md-6">
                    <label for="first_appointment" class="form-label">Previuos First Appointment *</label>
                    <input type="text" class="form-control" id="first_appointment" name="first_appointment" required>
                </div>
                <div class="col-md-6">
                    <label for="date_hired" class="form-label">Date Hired *</label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" required>
                </div>
                <div class="col-md-6">
                    <label for="assumption_of_duty_date" class="form-label">Assumption of Duty Date *</label>
                    <input type="date" class="form-control" id="assumption_of_duty_date" name="assumption_of_duty_date" required>
                </div>
                <div class="col-md-6">
                    <label for="other_appointment" class="form-label">Other Appointment</label>
                    <input type="text" class="form-control" id="other_appointment" name="other_appointment">
                </div>
                <div class="col-md-6">
                    <label for="from_appointment" class="form-label">From Appointment</label>
                    <input type="date" class="form-control" id="from_appointment" name="from_appointment">
                </div>
                <div class="col-md-6">
                    <label for="to_appointment" class="form-label">To Appointment</label>
                    <input type="date" class="form-control" id="to_appointment" name="to_appointment">
                </div>
                <div class="col-md-6">
    <label for="staff_category" class="form-label">UHAS Staff Category *</label>
    <select class="form-select" id="uhas_staff_category" name="uhas_staff_category" required>
        <option value="" selected disabled>Choose...</option>
        <?php while ($row = $staffCategoriesQuery->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>
</div>

                <div class="col-md-6">
                    <label for="directory" class="form-label">Directory</label>
                    <input type="text" class="form-control" id="directory" name="directory">
                </div>
                <div class="col-md-6">
                    <label for="gog_unit" class="form-label">GOG Unit</label>
                    <input type="text" class="form-control" id="gog_unit" name="gog_unit">
                </div>
                <div class="col-md-6">
                    <label for="campus" class="form-label">Campus *</label>
                    <select class="form-select" id="campus" name="campus" required>
                        <option value="" selected disabled>Choose...</option>
                        <?php while ($row = $campuses->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="end_of_contract_date" class="form-label">End of Contract Date</label>
                    <input type="date" class="form-control" id="end_of_contract_date" name="end_of_contract_date">
                </div>
                <div class="col-md-6">
                    <label for="years_with_uhas" class="form-label">Years with UHAS</label>
                    <input type="number" class="form-control" id="years_with_uhas" name="years_with_uhas">
                </div>
                <div class="col-md-6">
                    <label for="birthday" class="form-label">Birthday *</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>
                <div class="col-md-6">
                    <label for="files" class="form-label">Files</label>
                    <input type="file" class="form-control" id="files" name="files">
                </div>
            </div>
        </div>

   <!-- Submit Button -->
<div class="text-center mt-4">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="home.php" class="btn btn-secondary">Back to Homepage</a>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; <?= date('Y'); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</div>
</body>
</html>
