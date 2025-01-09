<?php
include('connect.php');

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    $stmt = $con->prepare("SELECT * FROM staff WHERE staff_id = :staff_id");
    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->execute();
    $staff = $stmt->fetch();

    if ($staff) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Staff Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 100px;
        }
        .details {
            margin-top: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .footer img {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="uhas_logo.png" alt="UHAS Logo">
        <h1>Staff Information</h1>
    </div>
    <div class="details">
        <table>
            <tr><th>Staff ID:</th><td><?php echo $staff['staff_id']; ?></td></tr>
            <tr><th>Full Name:</th><td><?php echo $staff['last_name'] . ", " . $staff['first_name'] . " " . $staff['middle_name']; ?></td></tr>
            <tr><th>Gender:</th><td><?php echo $staff['gender']; ?></td></tr>
            <tr><th>Position:</th><td><?php echo $staff['position']; ?></td></tr>
            <tr><th>Department:</th><td><?php echo $staff['department']; ?></td></tr>
            <tr><th>Campus:</th><td><?php echo $staff['campus']; ?></td></tr>
            <tr><th>Date of Birth:</th><td><?php echo $staff['date_of_birth']; ?></td></tr>
        </table>
    </div>
    <div class="footer">
        <p>Certified by:</p>
        <img src="hr_admin_signature.png" alt="HR Admin Signature">
        <p>HR Admin</p>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
<?php
    } else {
        echo "<p>Staff not found.</p>";
    }
} else {
    echo "<p>Invalid staff ID.</p>";
}
?>
