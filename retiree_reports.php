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
    $search_query = $_POST['search_query'];
    $filter_query = "WHERE fullname LIKE '%$search_query%' OR staff_id LIKE '%$search_query%'";
}

// Fetch all staff from the retiree table
$sql = "SELECT * FROM retiree $filter_query LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Fetch total records for pagination
$total_sql = "SELECT COUNT(*) FROM retiree $filter_query";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

// Delete staff member
if (isset($_GET['delete'])) {
    $staff_id = $_GET['delete'];
    $delete_sql = "DELETE FROM retiree WHERE staff_id = '$staff_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Staff member deleted successfully.'); window.location.href = 'staff_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Export as CSV
if (isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="retiree_staff_list.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, ['S/N', 'staff_id', 'fullname', 'DoB', 'hometown', 'designation', 'staff_category', 
        'highest_qualifications', 'date_hired', 'years_in_uhas', 'department', 'positions_held', 
        'date_of_retired', 'grade_retired', 'campus', 'email', 'phone', 'files']);
    
    // Fetch records to export
    $export_sql = "SELECT * FROM retiree $filter_query";
    $export_result = $conn->query($export_sql);
    $sn = 1;
    while ($row = $export_result->fetch_assoc()) {
        fputcsv($output, [$sn++, $row['staff_id'], $row['fullname'], $row['DoB'], $row['hometown'], $row['designation'], 
            $row['staff_category'], $row['highest_qualifications'], $row['date_hired'], $row['number_of_years_in_uhas'], 
            $row['department'], $row['positions_held'], $row['date_of_retired'], $row['grade_retired'], $row['campus'], 
            $row['email'], $row['phone'], $row['files']]);
    }
    fclose($output);
    exit;
}

// Send email (assuming sending to the email field of each retiree)
if (isset($_GET['send_email'])) {
    $staff_id = $_GET['send_email'];
    $email_sql = "SELECT email FROM retiree WHERE staff_id = '$staff_id'";
    $email_result = $conn->query($email_sql);
    $email_row = $email_result->fetch_assoc();
    $email_to = $email_row['email'];

    $subject = "Retiree Notification";
    $message = "Dear retiree, \n\nThis is a notification regarding your retirement status.";
    $headers = "From: no-reply@uhas.edu.gh";

    if (mail($email_to, $subject, $message, $headers)) {
        echo "<script>alert('Email sent successfully.'); window.location.href = 'staff_list.php';</script>";
    } else {
        echo "Error sending email.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List - Retired</title>
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
    <h1>Staff List - Retired</h1>
</header>

<div class="container">
    <form method="POST">
        <input type="text" name="search_query" placeholder="Search by name or staff ID" value="<?= $search_query ?>" style="padding: 10px;">
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
                <th>Highest Qualifications</th>
                <th>Date Hired</th>
                <th>Years in UHAS</th>
                <th>Department</th>
                <th>Positions Held</th>
                <th>Date of Retired</th>
                <th>Grade Retired</th>
                <th>Campus</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Files</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = $offset + 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$sn}</td>
                    <td>{$row['staff_id']}</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['DoB']}</td>
                    <td>{$row['hometown']}</td>
                    <td>{$row['designation']}</td>
                    <td>{$row['staff_category']}</td>
                    <td>{$row['highest_qualifications']}</td>
                    <td>{$row['date_hired']}</td>
                    <td>{$row['number_of_years_in_uhas']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['positions_held']}</td>
                    <td>{$row['date_of_retired']}</td>
                    <td>{$row['grade_retired']}</td>
                    <td>{$row['campus']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['files']}</td>
                    <td>
                        <a href='staff_list.php?delete={$row['staff_id']}' class='btn btn-danger'>Delete</a>
                        <a href='staff_list.php?send_email={$row['staff_id']}' class='btn'>Send Email</a>
                    </td>
                </tr>";
                $sn++;
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li><a href="staff_list.php?page=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
    </ul>

    <div>
        <a href="retiree_reports.php?export=true" class="btn">Export CSV</a>
        <a href="retired_mgt.php" class="btn">Back to Retired</a>
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
