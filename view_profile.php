<?php
// Database connection
require_once 'db.connect.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the staff ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Query to fetch the staff profile by ID
    $sql = "SELECT * FROM staff WHERE id = $staff_id";
    $result = $conn->query($sql);

    // Check if staff is found
    if ($result->num_rows == 1) {
        $staff = $result->fetch_assoc();
    } else {
        die("Staff not found.");
    }
} else {
    die("Invalid ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile Details</title>
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
        /* Print-specific styles */
        @media print {
            body {
                background-color: white;
            }
            .btn-uhas, footer, .uhas-header {
                display: none;
            }
            .container {
                width: 100%;
                padding: 0;
            }
            table {
                width: 100%;
                margin-bottom: 20px;
            }
            th, td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            th {
                background-color: #f4f4f4;
            }
            .hr-heading {
                font-size: 18px;
                text-align: center;
                margin-top: 20px;
                font-weight: bold;
            }
            .logo-print {
                display: block;
                margin: 0 auto;
                max-width: 100px;
            }
        }
/* Print-specific styles */
@media print {
    body {
        background-color: white;
    }
    .btn-uhas, 
    .btn-primary, 
    .btn-success, 
    .btn-secondary,

    footer, 
    .uhas-header {
        display: none;
    }
    .container {
        width: 100%;
        padding: 0;
    }
    table {
        width: 100%;
        margin-bottom: 20px;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f4f4f4;
    }
    .hr-heading {
        font-size: 18px;
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }
    .logo-print {
        display: block;
        margin: 0 auto;
        max-width: 100px;
    }
}
.card-title {
    text-align: center;
}


    </style>
</head>
<body>

<header class="uhas-header">
    <img src="uhas_logo.png" alt="UHAS Logo" style="max-width: 150px;">
    <h1>University of Health and Allied Sciences</h1>
    <p>Staff Profile Details</p>
</header>

<div class="container mt-4">
    <a href="staff_details.php" class="btn btn-uhas mb-3">Back to Staff List</a>
    <button onclick="openPopupDialog()" class="btn btn-success mb-3">Certified Retrieval Details</button>
    <button onclick="window.print()" class="btn btn-success mb-3">Print Profile</button>
    <button onclick="exportToExcel()" class="btn btn-success mb-3">Export to Excel</button>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h3 class="text-center">STAFF PROFILE: <?= htmlspecialchars($staff['full_name']) ?></h3>
        </div>
        <div class="card-body">
            <div class="hr-heading">
                <p>DIRECTORATE OF HUMAN RESOURCE <br> <?= date('F Y') ?></p>
            </div>
            <div class="text-center">
                <img src="uhas_logo.png" alt="UHAS Logo" class="logo-print">
            </div>
            <h5 class="card-title">STAFF DETAILS</h5>
            <table class="table table-striped">
                <tr>
                    <th>Staff ID:</th>
                    <td><?= htmlspecialchars($staff['staff_id']) ?></td>
                </tr>
                <tr>
                    <th>Controller ID:</th>
                    <td><?= htmlspecialchars($staff['controller_no']) ?></td>
                </tr>
                 <tr>
                    <th>Ghana Card No:</th>
                    <td><?= htmlspecialchars($staff['ghanacard_no']) ?></td>
                </tr>

                <tr>
                    <th>Full Name:</th>
                    <td><?= htmlspecialchars($staff['full_name']) ?></td>
                </tr>
                <tr>
                    <th>Designation:</th>
                    <td><?= htmlspecialchars($staff['designation']) ?></td>
                </tr>
                <tr>
                    <th>Employee Status:</th>
                    <td><?= htmlspecialchars($staff['employee_status']) ?></td>
                </tr>
                <tr>
                    <th>Department:</th>
                    <td><?= htmlspecialchars($staff['department']) ?></td>
                </tr>
                <tr>
                    <th>Present Appointment:</th>
                    <td><?= htmlspecialchars($staff['present_appointment']) ?></td>
                </tr>
                <tr>
                    <th>Staff Category:</th>
                    <td><?= htmlspecialchars($staff['staff_category']) ?></td>
                </tr>

                <tr>
                    <th>Staff Duty Status:</th>
                    <td><?= htmlspecialchars($staff['duty_status']) ?></td>
                </tr>



                <tr>
                    <th>Campus:</th>
                    <td><?= htmlspecialchars($staff['campus']) ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?= htmlspecialchars($staff['email_official']) ?></td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td><?= htmlspecialchars($staff['phone']) ?></td>
                </tr>
                <tr>
                    <th>Date of Birth:</th>
                    <td><?= htmlspecialchars($staff['dob']) ?></td>
                </tr>
                 <tr>
                    <th>Hometown:</th>
                    <td><?= htmlspecialchars($staff['hometown']) ?></td>
                </tr>
                <tr>
                    <th>Gender:</th>
                    <td><?= htmlspecialchars($staff['gender']) ?></td>
                </tr>
                <tr>
                    <th>Marital Status:</th>
                    <td><?= htmlspecialchars($staff['marital_status']) ?></td>
                </tr>
                 <tr>
                    <th>Other Appointments:</th>
                    <td><?= htmlspecialchars($staff['other_appointment']) ?></td>
                </tr>
                <tr>
                    <th>Qualifications:</th>
                    <td><?= htmlspecialchars($staff['qualifications']) ?></td>
                </tr>
                <tr>
                    <th>Highest Qualifications:</th>
                    <td><?= htmlspecialchars($staff['highest_qualification']) ?></td>
                </tr>
                <tr>
                    <th>Speciality:</th>
                    <td><?= htmlspecialchars($staff['speciality']) ?></td>
                </tr>
                <tr>
                    <th>Date Hired:</th>
                    <td><?= htmlspecialchars($staff['date_hired']) ?></td>
                </tr>
                <tr>
                    <th>Years with UHAS:</th>
                    <td><?= htmlspecialchars($staff['years_with_uhas']) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<footer>
    <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Export to Excel script -->
<script>
    function exportToExcel() {
        let table = document.querySelector('table');
        let html = table.outerHTML;
        let uri = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        let link = document.createElement('a');
        link.href = uri;
        link.download = 'staff_profile_<?= $staff['staff_id']; ?>.xls';
        link.click();
    }
</script>


</body>
<script>
    function openPopupDialog() {
        const name = prompt("Enter the name of the person retrieving the data:");

        if (name) {
            const table = document.querySelector('table');

            // Add a new row at the bottom of the table
            const row = table.insertRow(-1);

            // Add cells for 'Retrieved By' and details
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);

            // Merge remaining columns into the second cell
            cell2.colSpan = table.rows[0].cells.length - 1;

            // Fill cells with content
            cell1.textContent = 'Data Retrieved By:';
            cell2.innerHTML = `
                ${name}<br>
                SIGN: __________________<br>
                ${new Date().toLocaleString()}
            `;

            // Style the row to match the rest of the table
            row.style.backgroundColor = '#f9f9f9';
            row.style.fontWeight = 'bold';
            cell1.style.verticalAlign = 'top'; // Align the label properly
        } else {
            alert("No name entered. Operation cancelled.");
        }
    }
</script>


</html>
