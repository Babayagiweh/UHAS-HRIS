<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define query functions
function fetchCounts($conn, $column)
{
    $query = "SELECT `$column`, COUNT(*) as count FROM staff GROUP BY `$column`";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function calculateAgeSegments($conn)
{
    $query = "
        SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 0 AND 9 THEN '0-9'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 10 AND 19 THEN '10-19'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 20 AND 29 THEN '20-29'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 30 AND 39 THEN '30-39'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 40 AND 49 THEN '40-49'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 50 AND 59 THEN '50-59'
                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 60 AND 69 THEN '60-69'
                ELSE '70+'
            END AS age_segment, COUNT(*) as count
        FROM staff 
        GROUP BY age_segment";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Fetch all necessary data
$data = [
    "staff_category" => fetchCounts($conn, "staff_category"),
    "designation" => fetchCounts($conn, "designation"),
    "age_segment" => calculateAgeSegments($conn),
    "gender" => fetchCounts($conn, "gender"),
    "present_appointment" => fetchCounts($conn, "present_appointment"),
    "duty_status" => fetchCounts($conn, "duty_status"),
    "hometown" => fetchCounts($conn, "hometown"),
    "highest_qualification" => fetchCounts($conn, "highest_qualification"),
    "years_with_uhas" => fetchCounts($conn, "years_with_uhas"),
    "campus" => fetchCounts($conn, "campus"),
    "title" => fetchCounts($conn, "title"),
    "marital_status" => fetchCounts($conn, "marital_status"),
    "speciality" => fetchCounts($conn, "speciality"),
    "employee_status" => fetchCounts($conn, "employee_status"),
    "other_appointment" => fetchCounts($conn, "other_appointment"),
    "department" => fetchCounts($conn, "department"),
];

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <style>
        body {
            background-color: egg;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            background-color: green;
            color: white;
            margin-bottom: 25px;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-export, .btn-home {
            background-color: #1E7F36;
            color: #FFFFFF;
        }
        footer {
            background-color: #1E7F36;
            color: #FFFFFF;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <br>
    <div class="container mt-4">
        <h2 class="text-center text-primary mb-4">UHAS-HR STAFF COUNTS</h2>
         <a href="home.php" class="btn btn-home me-3">Back to Home</a><br>
        <br>
        <div class="row">
            <?php foreach ($data as $key => $values): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card p-3">
                        <h5 class="card-title text-center text-uppercase"><?php echo str_replace('_', ' ', $key); ?></h5>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($values as $value): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $value[$key] ?? 'Unknown'; ?>
                                    <span class="badge bg-success rounded-pill"><?php echo $value['count']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="home.php" class="btn btn-home me-3">Back to Home</a>
            <button class="btn btn-export">Export to PDF</button>

            <br>
            <button class="btn btn-home" onclick="window.print()">Print</button>
        </div>
    </div>
        
    <br>
    <hr>
    <br>
    <br>

    <footer>
        <p>© 2024 University of Health and Allied Sciences - HR Directorate</p>
    </footer>


<div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary btn-export">Export to PDF</button>
        </div>
    </div>
    <script>
        document.querySelector('.btn-export').addEventListener('click', async function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.text("UHAS-HR STAFF STATISTICS", 10, 10);

            let y = 20; // Y-position for text

            // Extract data from each card
            document.querySelectorAll('.card').forEach((card) => {
                const title = card.querySelector('.card-title').innerText;
                doc.setFontSize(12);
                doc.text(title, 10, y);
                y += 10;

                const items = card.querySelectorAll('.list-group-item');
                items.forEach((item) => {
                    const text = item.innerText;
                    doc.setFontSize(10);
                    doc.text(`- ${text}`, 20, y);
                    y += 8;
                });
                y += 5; // Add extra space after each card
            });

            // Save the generated PDF
            doc.save("uhas_hr_statistics.pdf");
        });
    </script>

</body>
</html>
