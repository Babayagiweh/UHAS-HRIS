<?php
// Start session to use session variables for messages
session_start();

// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the staff ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch the staff profile by ID using a prepared statement
    $sql = "SELECT * FROM staff WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);  // Bind the ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if staff is found
    if ($result->num_rows == 1) {
        $staff = $result->fetch_assoc();
    } else {
        die("Staff not found.");
    }
} else {
    die("Invalid ID.");
}

// Handle the form submission to update the staff information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $staff_id = $_POST['staff_id'];
    $controller_no = $_POST['controller_no'];
    $ghanacard_no = $_POST['ghanacard_no'];
    $duty_status = $_POST['duty_status'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $title = $_POST['title'];
    $full_name = $_POST['full_name'];
    $date_hired = $_POST['date_hired'];
    $assumption_of_duty_date = $_POST['assumption_of_duty_date'];
    $present_appointment = $_POST['present_appointment'];
    $date_on_present_grade = $_POST['date_on_present_grade'];

    $employee_status = $_POST['employee_status'];
    $staff_category = $_POST['staff_category'];
    $designation = $_POST['designation'];
   
    $phone = $_POST['phone'];
    $email_official = $_POST['email_official'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $qualifications = $_POST['qualifications'];
    $highest_qualification = $_POST['highest_qualification'];
    $department = $_POST['department'];
    $campus = $_POST['campus'];
    $birthday = $_POST['birthday'];


    // SQL to update the staff information
    $update_sql = "UPDATE staff SET 
                    staff_id = ?,
                    controller_no = ?,
                    ghanacard_no = ?,
                    duty_status = ?,
                    first_name = ?, 
                    middle_name = ?, 
                    last_name = ?, 
                    title = ?,
                    full_name = ?,
                    date_hired = ?,
                    assumption_of_duty_date = ?,
                    present_appointment = ?,
                    date_on_present_grade = ?,
                    employee_status = ?,
                    staff_category = ?,
                    designation = ?, 
                   
                    phone = ?, 
                    email_official = ?, 
                    gender = ?, 
                    dob = ?, 
                    marital_status = ?, 
                    qualifications = ?,
                    highest_qualification = ?,
                    department = ?,
                    campus = ?,
                    birthday =?
                    WHERE id = ?";

    // Prepare statement and bind parameters
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssssssssssssssssssssssi", $staff_id, $controller_no, $ghanacard_no, $duty_status, $first_name, $middle_name, $last_name, $title, $full_name, $date_hired, $assumption_of_duty_date, $present_appointment, $date_on_present_grade, $employee_status, $staff_category, $designation, $phone, $email_official, $gender, $dob, $marital_status, $qualifications, $highest_qualification, $department, $campus, $birthday, $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $_SESSION['message'] = "Staff updated successfully";  // Set session message
        header("Location: view_profile.php?id=" . $id);  // Redirect to the staff profile page
        exit();
    } else {
        $_SESSION['error'] = "Error updating staff information: " . $conn->error;
        header("Location: edit_staff.php?id=" . $id);  // Redirect back to the edit page on error
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Information</title>
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

<header class="uhas-header">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>University of Health and Allied Sciences</h1>
    <p>Edit Staff Information</p>
</header>

<div class="container mt-4">
    <a href="staff_details.php" class="btn btn-uhas mb-3">Back to Staff List</a>

    <!-- Display success or error message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h3 class="text-center">Edit Staff Profile: <?= htmlspecialchars($staff['full_name']) ?></h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="staff_id" class="form-label">Staff ID</label>
                    <input type="text" class="form-control" id="staff_id" name="staff_id" value="<?= htmlspecialchars($staff['staff_id']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="controller_no" class="form-label">Controller No</label>
                    <input type="text" class="form-control" id="controller_no" name="controller_no" value="<?= htmlspecialchars($staff['controller_no']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ghanacard_no" class="form-label">Ghana Card</label>
                    <input type="text" class="form-control" id="ghanacard_no" name="ghanacard_no" value="<?= htmlspecialchars($staff['ghanacard_no']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="duty_status" class="form-label">Duty Status</label>
                    <input type="text" class="form-control" id="duty_status" name="duty_status" value="<?= htmlspecialchars($staff['duty_status']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($staff['first_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= htmlspecialchars($staff['middle_name']) ?>">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($staff['last_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($staff['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($staff['full_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="date_hired" class="form-label">Date Hired</label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" value="<?= htmlspecialchars($staff['date_hired']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="assumption_of_duty_date" class="form-label">Assumption of Duty Date</label>
                    <input type="date" class="form-control" id="assumption_of_duty_date" name="assumption_of_duty_date" value="<?= htmlspecialchars($staff['assumption_of_duty_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="present_appointment" class="form-label">Present Appointment</label>
                    <input type="text" class="form-control" id="present_appointment" name="present_appointment" value="<?= htmlspecialchars($staff['present_appointment']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="date_on_present_grade" class="form-label">Date of Present Appointment| Grade</label>
                    <input type="date" class="form-control" id="date_on_present_grade" name="date_on_present_grade" value="<?= htmlspecialchars($staff['date_on_present_grade']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="employee_status" class="form-label">Employee Status</label>
                    <input type="text" class="form-control" id="employee_status" name="employee_status" value="<?= htmlspecialchars($staff['employee_status']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="staff_category" class="form-label">Staff Category</label>
                    <input type="text" class="form-control" id="staff_category" name="staff_category" value="<?= htmlspecialchars($staff['staff_category']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" value="<?= htmlspecialchars($staff['designation']) ?>" required>
                </div>

               <!-- <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department" value="<?= htmlspecialchars($staff['department']) ?>" required>
                </div> -->

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($staff['phone']) ?>">
                </div>
                <div class="mb-3">
                    <label for="email_official" class="form-label">Official Email</label>
                    <input type="email" class="form-control" id="email_official" name="email_official" value="<?= htmlspecialchars($staff['email_official']) ?>">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="Male" <?= $staff['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $staff['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $staff['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
              <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($staff['dob']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="marital_status" class="form-label">Marital Status</label>
                    <input type="text" class="form-control" id="marital_status" name="marital_status" value="<?= htmlspecialchars($staff['marital_status']) ?>">
                </div>
                <div class="mb-3">
                    <label for="qualifications" class="form-label">Qualifications</label>
                    <textarea class="form-control" id="qualifications" name="qualifications"><?= htmlspecialchars($staff['qualifications']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="highest_qualification" class="form-label">Highest Qualifications</label>
                    <textarea class="form-control" id="highest_qualification" name="highest_qualification"><?= htmlspecialchars($staff['highest_qualification']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Dir|Sch|Off|Dept|Unit</label>
                    <textarea class="form-control" id="department" name="department"><?= htmlspecialchars($staff['department']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="campus" class="form-label">Campus</label>
                    <textarea class="form-control" id="campus" name="campus"><?= htmlspecialchars($staff['campus']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Birth Date</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlspecialchars($staff['birthday']) ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
