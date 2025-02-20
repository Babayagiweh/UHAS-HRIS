<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search and filter
$search_query = '';
$filter_query = '';

if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
    $filter_query = "WHERE fullname LIKE '%$search_query%' OR staff_id LIKE '%$search_query%'";
}

// Fetch all staff from the deceased table
$sql = "SELECT * FROM deceased $filter_query LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch total records for pagination
$total_sql = "SELECT COUNT(*) FROM deceased $filter_query";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

// Delete staff member
if (isset($_GET['delete'])) {
    $staff_id = $_GET['delete'];
    $delete_sql = "DELETE FROM deceased WHERE staff_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("s", $staff_id);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Staff member deleted successfully.'); window.location.href = 'deceased_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Export as CSV
if (isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="deceased_staff_list.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['S/N', 'staff_id', 'full_name', 'dob', 'hometown', 'designation', 'staff_category', 
        'years_in_uhas', 'department', 'date_of_death', 'email', 'phone']);
    
    // Fetch records to export
    $export_sql = "SELECT * FROM deceased $filter_query";
    $export_result = $conn->query($export_sql);
    $sn = 1;
    while ($row = $export_result->fetch_assoc()) {
        fputcsv($output, [$sn++, $row['staff_id'], $row['fullname'], $row['dob'], $row['hometown'], $row['designation'], 
            $row['staff_category'], $row['years_in_uhas'], $row['department'], $row['date_of_death'], 
            $row['email'], $row['phone'], $row['files']]);
    }
    fclose($output);
    exit;
}

// Send email (assuming sending to the email field of each deceased staff)
if (isset($_GET['send_email'])) {
    $staff_id = $_GET['send_email'];
    $email_sql = "SELECT email FROM deceased WHERE staff_id = ?";
    $email_stmt = $conn->prepare($email_sql);
    $email_stmt->bind_param("s", $staff_id);
    $email_stmt->execute();
    $email_result = $email_stmt->get_result();
    $email_row = $email_result->fetch_assoc();
    $email_to = $email_row['email'];

    if (filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
        $subject = "Deceased Notification";
        $message = "Dear family, \n\nThis is a notification regarding the deceased status of the staff member.";
        $headers = "From: no-reply@uhas.edu.gh";

        if (mail($email_to, $subject, $message, $headers)) {
            echo "<script>alert('Email sent successfully.'); window.location.href = 'deceased_list.php';</script>";
        } else {
            echo "Error sending email.";
        }
    } else {
        echo "Invalid email format.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deceased Staff List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #006400; /* UHAS Green */
            color: white;
            padding: 20px;
            text-align: center;
        }
        footer {
            background-color: #006400;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #FFD700; /* UHAS Yellow */
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            background-color: #006400;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: red;
        }
        .pagination {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .pagination li {
            margin: 5px;
        }
        .pagination a {
            text-decoration: none;
            color: #006400;
            padding: 8px 16px;
            border: 1px solid #006400;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <img src="uhas_logo.png" alt="UHAS Logo" style="height: 50px;">
    <h1>Deceased Staff List</h1>
</header>

<div class="container">
    <form method="POST">
        <input type="text" name="search_query" placeholder="Search by name or staff ID" value="<?= htmlspecialchars($search_query) ?>" style="padding: 10px;">
        <button type="submit" name="search" class="btn">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Hometown</th>
                <th>Designation</th>
                <th>Staff Category</th>
                <th>Years in UHAS</th>
                <th>Department</th>
                <th>Date of Death</th>
             
                <th>Email</th>
                <th>Phone</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = $offset + 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$sn}</td>
                    <td>{$row['staff_id']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['hometown']}</td>
                    <td>{$row['designation']}</td>
                    <td>{$row['staff_category']}</td>
                    <td>{$row['years_in_uhas']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['date_of_death']}</td>
                
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                   
                                    </tr>";
                $sn++;
            }
            ?>
        </tbody>
    </table>

   <hr>

    <div>
        <a href="death_reports.php?export=true" class="btn">Export CSV</a>
        <a href="death_mgt.php" class="btn">Back to Deceased Mgt Page</a>
    </div>
</div>

<footer>
    <p>&copy; <?= date('Y') ?> University of Health and Allied Sciences. All rights reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
