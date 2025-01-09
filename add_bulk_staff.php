<?php
// Database connection
require_once 'db.connect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Export CSV template
if (isset($_GET['export_template'])) {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=staff_template.csv");
    $columns = [
        "staff_id", "controller_no", "ghanacard_no", "duty_status", "status", "from_date", "to_date", 
        "first_name", "middle_name", "last_name", "title", "full_name", "designation",
        "employee_status", "date_on_present_grade", "present_appointment", "dob", "marital_status", 
        "gender", "hometown", "qualifications", "details_of_highest_qualification", 
        "highest_qualification", "speciality", "first_appointment", "date_hired", 
        "assumption_of_duty_date", "other_appointment", "from_appointment", "to_appointment", 
        "staff_category", "department", "directory", "gog_unit", "campus", 
        "end_of_contract_date", "years_with_uhas", "phone", "email_official", 
        "email_private", "birthday", "files"
    ];
    echo implode(",", $columns) . "\n";
    exit;
}

// Handle file upload
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $extension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION);

    if ($extension != 'csv') {
        $message = "Only CSV files are allowed.";
    } else {
        $handle = fopen($file, "r");
        $header = fgetcsv($handle);
        $columns = [
            "staff_id", "controller_no", "ghanacard_no", "duty_status", "status", "from_date", "to_date", 
            "first_name", "middle_name", "last_name", "title", "full_name", "designation",
            "employee_status", "date_on_present_grade", "present_appointment", "dob", "marital_status", 
            "gender", "hometown", "qualifications", "details_of_highest_qualification", 
            "highest_qualification", "speciality", "first_appointment", "date_hired", 
            "assumption_of_duty_date", "other_appointment", "from_appointment", "to_appointment", 
            "staff_category", "department", "directory", "gog_unit", "campus", 
            "end_of_contract_date", "years_with_uhas", "phone", "email_official", 
            "email_private", "birthday", "files"
        ];

        if ($header !== $columns) {
            $message = "The CSV file structure does not match the required template.";
        } else {
            while ($row = fgetcsv($handle)) {
                $row = array_map('trim', $row);
                $placeholders = rtrim(str_repeat("?,", count($row)), ",");
                $sql = "INSERT INTO staff (" . implode(",", $columns) . ") VALUES ($placeholders)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(str_repeat("s", count($row)), ...$row);
                $stmt->execute();
            }
            $message = "Staff data uploaded successfully!";
        }
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Staff Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .uhas-header {
            background-color: green;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .btn-uhas {
            background-color: green;
            color: white;
        }
        .btn-uhas:hover {
            background-color: yellow;
        }
        footer {
    background-color: green;
    color: white;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header class="uhas-header">
        <img src="uhas_logo.png" alt="UHAS Logo" width="80">
        <h1>University of Health and Allied Sciences</h1>
        <p>Bulk Staff Upload</p>
    </header>

    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="text-center mb-4">
            <a href="?export_template=true" class="btn btn-uhas btn-lg">Export Template</a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="text-center">
            <div class="mb-3">
                <label for="csv_file" class="form-label">Upload CSV File</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-uhas btn-lg">Upload Staff Data</button>
        </form>
        <a href="home.php" class="btn btn-uhas btn-lg">Back to Homepage</a> <a href="all_staff.php" class="btn btn-uhas btn-lg">Proceed to ALL Staff Personnel page</a>
    </div>

    <footer>
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>
</body>
</html>
