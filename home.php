<?php   
// Start session and check login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';


// Fetch gender distribution from the database
$stmt_gender = $pdo->query("SELECT gender, COUNT(*) AS count FROM staff GROUP BY gender");
$gender_data = $stmt_gender->fetchAll(PDO::FETCH_ASSOC);

// Fetch statistics from the database
$stmt_stats = $pdo->query("SELECT COUNT(*) AS count, staff_category FROM staff GROUP BY staff_category");
$staff_categories = $stmt_stats->fetchAll(PDO::FETCH_ASSOC);

// Fetch campus data for the pie chart
$campus_stmt = $pdo->query("SELECT campus, COUNT(*) AS count FROM staff GROUP BY campus");
$campus_data = $campus_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch academic qualification stats for the bar chart
$stmt_qualification = $pdo->query("SELECT highest_qualification, COUNT(*) AS count FROM staff GROUP BY highest_qualification");
$qualification_data = $stmt_qualification->fetchAll(PDO::FETCH_ASSOC);

// Fetch birthday data for the birthday list
$stmt_birthday = $pdo->query("SELECT full_name, staff_category, campus, department, highest_qualification, phone, email_official, birthday FROM staff WHERE MONTH(birthday) = MONTH(CURRENT_DATE()) AND DAY(birthday) = DAY(CURRENT_DATE())");
$birthday_data = $stmt_birthday->fetchAll(PDO::FETCH_ASSOC);

// Additional statistics
$total_staff_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff");
$total_staff = $total_staff_stmt->fetch(PDO::FETCH_ASSOC)['count'];

$active_staff_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE status = 'active'");
$active_staff = $active_staff_stmt->fetch(PDO::FETCH_ASSOC)['count'];

$inactive_staff_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE status = 'inactive'");
$inactive_staff = $inactive_staff_stmt->fetch(PDO::FETCH_ASSOC)['count'];

$new_staff_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE DATE(date_hired) >= CURDATE() - INTERVAL 150 DAY");
$new_staff = $new_staff_stmt->fetch(PDO::FETCH_ASSOC)['count'];

$contract_expiry_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE end_of_contract_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 6 MONTH");
$contract_expiry = $contract_expiry_stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Fetch staff category data
$staff_category_stmt = $pdo->query("SELECT staff_category, COUNT(*) AS count FROM staff GROUP BY staff_category");
$staff_category_data = $staff_category_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch campus data
$campus_stmt = $pdo->query("SELECT campus, COUNT(*) AS count FROM staff GROUP BY campus");
$campus_data = $campus_stmt->fetchAll(PDO::FETCH_ASSOC);



// Define an array of colors for the statistical ovals
$colors = ['#2E8B57', '#228B22', '#006400', '#32CD32', '#98FB98'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>Home - UHAS HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        h2, h3 {
            color: #2E8B57;
            font-weight: bold;
            text-align: center;
        }
        .stats-row {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            gap: 20px;
        }
        .stat-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
        }
        .stat-box h4 {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
        .stat-box p {
            font-size: 22px;
            font-weight: bold;
            color: white;
        }
        .chart-container {
            margin-top: 40px;
            padding: 20px;
            background: url('bg.jpg') no-repeat center center;
            background-size: cover;
        }
        .chart-box {
            margin: auto;
            max-width: 600px;
        }
        .footer {
            background-color: #006400;
            color: #fff;
            text-align: center;
            padding: 5px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }



.chart-container {
    display: flex;
    justify-content: space-between;  /* Ensures the charts are spread out */
    gap: 20px;  /* Adds space between the charts */
    margin-top: 40px;
}

.chart-box {
    flex: 1;  /* Allows the boxes to grow and take equal space */
    min-width: 45%;  /* Minimum width of 45% for each chart box */
    margin-bottom: 30px;
    background-color: #ffffff;  /* Optional: Adds a background color */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

@media screen and (max-width: 768px) {
    .chart-container {
        flex-direction: column;  /* Stacks the charts vertically on smaller screens */
        align-items: center;
    }
    .chart-box {
        width: 90%;  /* Makes the chart boxes take up more space on smaller screens */
    }
}
  .centered-blinking-text {
        text-align: center; /* Center the text */
        font-weight: bold; /* Make text bold */
        color: #FF4500; /* Reflective color (vivid orange) */
        text-shadow: 0 0 10px #FF4500, 0 0 20px #FFD700, 0 0 30px #FFFF00; /* Glow effect */
        animation: blink 1s infinite; /* Add blinking effect */
    }

    @keyframes blink {
        100% {
            opacity: 0;
        }
    }

    </style>
</head>
<body>

<?php include 'header.php'; ?>
<br>
<br>
<div class="container">
    <h2>STAFF STATISTICS</h2>

   <!-- Staff Stats -->
<div class="stats-row">
    <div class="stat-box" style="background-color: #2E8B57;">
        <h4>
            <a href="all_staff.php" style="color: white; text-decoration: none;">TOTAL STAFF</a>
        </h4>
        <p><?php echo $total_staff; ?></p>
    </div>
    <div class="stat-box" style="background-color: #228B22;">
        <h4>
            <a href="#" style="color: white; text-decoration: none;">STAFF AT POST</a>
        </h4>
        <p><?php echo $active_staff; ?></p>
    </div>
    <div class="stat-box" style="background-color: gray;">
        <h4>
            <a href="#" style="color: white; text-decoration: none;">STAFF NOT AT POST</a>
        </h4>
        <p><?php echo $inactive_staff; ?></p>
    </div>
    <div class="stat-box" style="background-color: yellowgreen;">
        <h4>
            <a href="newly_added_staff.php" style="color: white; text-decoration: none;">NEWLY ADDED STAFF</a>
        </h4>
        <p><?php echo $new_staff; ?></p>
    </div>
    <div class="stat-box" style="background-color: #006400;">
        <h4>
            <a href="contracts_expiry.php" style="color: white; text-decoration: none;">CONTRACTS EXPIRY</a>
        </h4>
        <p><?php echo $contract_expiry; ?></p>
    </div>
</div>

<hr>
    <!-- Qualification Chart -->
   <div>
    <div class="chart-container">
        <div class="chart-box">
             <h3 class="text-center">Academic & Staff Qualifications by Distribution</h3>
            <canvas id="qualificationChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-container">
    <div class="chart-box">
        <h3 class="text-center">Staff Category Distribution</h3>
        <canvas id="categoryChart"></canvas>
    </div>

    <div class="chart-box">
        <h3 class="text-center">Staff Count by Campus</h3>
        <canvas id="campusChart"></canvas>
    </div>
</div>



<p>
  <wbr>  
      <wbr>  
          <wbr>  </p>
            <hr>
   <!-- Birthday List -->
<div class="birthday-list-container">
    <h3>Today's Birthdays</h3>
    <?php if (empty($birthday_data)) : ?>
        <p class="centered-blinking-text">Today, no one is celebrating a birthday. Have a great <?php echo date('l');  ?> Admin!</p>
    <?php else : ?>
        <table class="table table-striped">
            <thead>
                <tr style="background-color: #2E8B57; color: #fff;">
                    <th>S/No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Campus</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1; ?>
                <?php foreach ($birthday_data as $bday) : ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo htmlspecialchars($bday['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($bday['staff_category']); ?></td>
                        <td><?php echo htmlspecialchars($bday['campus']); ?></td>
                        <td><?php echo htmlspecialchars($bday['email_official']); ?></td>
                        <td><?php echo htmlspecialchars($bday['phone']); ?></td>
                        <td>
                            <form method="post" action="send_birthday_email.php">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($bday['email_official']); ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($bday['full_name']); ?>">
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($bday['staff_category']); ?>">
                                <button type="submit" class="btn btn-success btn-sm">Send Message</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>


</div>
<hr>
<p>
  <wbr>  
      <wbr>  
          <wbr> 


<?php


// Fetch yearly staff count
$queryYearly = "SELECT YEAR(date_hired) as year, COUNT(*) as count FROM staff WHERE date_hired IS NOT NULL GROUP BY YEAR(date_hired) ORDER BY YEAR(date_hired) DESC";
$stmtYearly = $pdo->prepare($queryYearly);
$stmtYearly->execute();
$yearlyData = $stmtYearly->fetchAll(PDO::FETCH_ASSOC);

// Fetch gender counts
$queryGender = "SELECT gender, COUNT(*) as count FROM staff WHERE gender IS NOT NULL GROUP BY gender";
$stmtGender = $pdo->prepare($queryGender);
$stmtGender->execute();
$genderData = $stmtGender->fetchAll(PDO::FETCH_ASSOC);

// Define colors for cards and bar chart
$yearColors = ["#FF5733", "#33FF57", "#3357FF", "#F333FF", "#33FFF3", "#FFD700", "#FF69B4", "#87CEFA"];
$genderColors = [
    'Male' => '#4285F4', 
    'Female' => '#FBBC05', 
    'Other' => '#34A853', 
    'Default' => '#EA4335'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <style>
        .statistics-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            align-items: flex-start;
        }
        .yearly-stats, .gender-stats {
            flex: 1;
            min-width: 300px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .year-card {
            width: 150px;
            height: 150px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .bar-chart {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
    width: 100%; /* Ensures it scales within its container */
}

.bar {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%; /* Ensures bars fit within the container */
}

.bar-label {
    width: 70px;
    font-weight: bold;
}

.bar-fill {
    height: 20px;
    border-radius: 20px;
    max-width: 400px; /* Cap the maximum bar width */
    transition: width 0.3s; /* Smooth resizing animation */
    text-align: center;
}

    </style>
</head>
<body>
<div class="container mt-5">
  
    <div class="statistics-container">
        <!-- Yearly Stats -->
        <div class="yearly-stats">
            <h3 class="text-center mb-4">Yearly Staff Employment</h3>
            <div class="card-container">
                <?php 
                $colorIndex = 0;
                foreach ($yearlyData as $row): 
                    $color = $yearColors[$colorIndex % count($yearColors)];
                    $colorIndex++;
                ?>
                    <div class="year-card" style="background-color: <?php echo $color; ?>;">
                        <div style="font-size: 24px;"><?php echo htmlspecialchars($row['year']); ?></div>
                        <div style="font-size: 18px;"><?php echo htmlspecialchars($row['count']); ?> Staff</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Gender Stats -->
        <div class="gender-stats">
            <h3 class="text-center mb-4">Gender Distribution</h3>
            <div class="bar-chart">
                <?php foreach ($genderData as $row): 
                    $gender = htmlspecialchars($row['gender']);
                    $count = htmlspecialchars($row['count']);
                    $color = $genderColors[$gender] ?? $genderColors['Default'];
                ?>
                    <div class="bar">
                        <div class="bar-label"><?php echo $gender; ?></div>
                        <div class="bar-fill" style="width: <?php echo $count * 10; ?>px; background-color: <?php echo $color; ?>;">
                            <?php echo $count; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<!-- Footer -->
<div class="footer">
    <p>UHAS HRIS © <?= date("Y"); ?> | Powered by ICT DIRECTORATE</p>
</div>

<script>
    // Qualification Chart
    var ctx = document.getElementById('qualificationChart').getContext('2d');
    var qualificationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($qualification_data, 'highest_qualification')); ?>,
            datasets: [{
                label: 'Staff Count',
                data: <?php echo json_encode(array_column($qualification_data, 'count')); ?>,
                backgroundColor: '#228B22',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
<script>
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'bar', // Change to 'pie' for a pie chart
        data: {
            labels: <?php echo json_encode(array_column($staff_category_data, 'staff_category')); ?>,
            datasets: [{
                label: 'Staff Count',
                data: <?php echo json_encode(array_column($staff_category_data, 'count')); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#33AFFF', '#8E44AD', '#FFBD33'], // Colors
                borderColor: '#000',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
        }
    });
</script>


<script>
    var campusCtx = document.getElementById('campusChart').getContext('2d');
    var campusChart = new Chart(campusCtx, {
        type: 'pie', // Change to 'bar' for a bar chart
        data: {
            labels: <?php echo json_encode(array_column($campus_data, 'campus')); ?>,
            datasets: [{
                label: 'Staff Count',
                data: <?php echo json_encode(array_column($campus_data, 'count')); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#33AFFF', '#8E44AD', '#FFBD33', '#FF6F61'], // Colors
                borderColor: '#000',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' },
            },
        }
    });
</script>


<script>
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'pie',  // or 'bar'
        data: {
            labels: <?php echo json_encode(array_column($category_data, 'staff_category')); ?>,
            datasets: [{
                label: 'Staff Count by Category',
                data: <?php echo json_encode(array_column($category_data, 'count')); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#33AFFF', '#8E44AD', '#FFBD33'],
                borderColor: '#000',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });

    var campusCtx = document.getElementById('campusChart').getContext('2d');
    var campusChart = new Chart(campusCtx, {
        type: 'pie',  // or 'bar'
        data: {
            labels: <?php echo json_encode(array_column($campus_data, 'campus')); ?>,
            datasets: [{
                label: 'Staff Count by Campus',
                data: <?php echo json_encode(array_column($campus_data, 'count')); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#33AFFF', '#8E44AD', '#FFBD33'],
                borderColor: '#000',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });
</script>



</body>
</html>
