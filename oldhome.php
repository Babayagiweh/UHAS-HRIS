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

$new_staff_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE DATE(assumption_of_duty_date) >= CURDATE() - INTERVAL 30 DAY");
$new_staff = $new_staff_stmt->fetch(PDO::FETCH_ASSOC)['count'];

$contract_expiry_stmt = $pdo->query("SELECT COUNT(*) AS count FROM staff WHERE end_of_contract_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 6 MONTH");
$contract_expiry = $contract_expiry_stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Define an array of colors for the statistical ovals
$colors = ['#FF5733', '#33FF57', '#33AFFF', '#8E44AD', '#FFBD33', '#75FF33', '#FF6F61', '#E74C3C'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - UHAS HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        h2, h3 {
            color: #333;
            font-weight: bold;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }
        .stat-oval {
            background-color: #ffffff;
            border-radius: 50%;
            width: 200px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            color: white;
            font-weight: bold;
        }
        .stat-oval:hover {
            transform: scale(1.1);
        }
        .stat-oval h4 {
            margin: 0;
            font-size: 18px;
            color: #fff;
            font-weight: bold;
        }
        .stat-oval p {
            margin: 5px 0;
            font-size: 24px;
            color: #fff;
        }
        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .stat-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat-box h4 {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .stat-box p {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .chart-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .chart-box {
            width: 45%;
            margin-bottom: 30px;
        }
        .calendar-container, .birthday-list-container {
            margin-top: 40px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .footer {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        @media screen and (max-width: 768px) {
            .chart-container {
                flex-direction: column;
            }
            .chart-box {
                width: 100%;
            }
            .stats-row {
                flex-direction: column;
                align-items: center;
            }
            .stat-box {
                margin-bottom: 15px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="main-content">
        <h2 class="text-center">STAFF STATISTICS</h2>

        <!-- Staff Stats - Horizontal Layout -->
        <div class="stats-row">
            <!-- Total Staff -->
            <div class="stat-box" style="background-color: #FF5733;">
                <h4>Total Staff</h4>
                <p><?php echo $total_staff; ?></p>
            </div>

            <!-- Active Staff -->
            <div class="stat-box" style="background-color: #33FF57;">
                <h4>Active Staff</h4>
                <p><?php echo $active_staff; ?></p>
            </div>

            <!-- Inactive Staff -->
            <div class="stat-box" style="background-color: #33AFFF;">
                <h4>Inactive Staff</h4>
                <p><?php echo $inactive_staff; ?></p>
            </div>

            <!-- New Staff (Last 30 Days) -->
            <div class="stat-box" style="background-color: #8E44AD;">
                <h4>New Staff (Last 30 Days)</h4>
                <p><?php echo $new_staff; ?></p>
            </div>

            <!-- Contract Expiry (Next 6 Months) -->
            <div class="stat-box" style="background-color: #FFBD33;">
                <h4>Contract Expiry (Next 6 Months)</h4>
                <p><?php echo $contract_expiry; ?></p>
            </div>
        </div>

        <!-- Staff Categories - Ovals Layout -->
        <div class="stats-container">
            <?php foreach ($staff_categories as $category) : ?>
                <div class="stat-oval" style="background-color: <?php echo $colors[array_rand($colors)]; ?>">
                    <h4><?php echo htmlspecialchars($category['staff_category']); ?></h4>
                    <p><?php echo $category['count']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Qualification Bar Chart -->
        <div class="chart-container">
            <div class="chart-box">
                <h3>Highest Qualification</h3>
                <canvas id="qualificationChart" width="200" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>University of Health and Allied Sciences | Staff Management System</p>
</div>

<script>
    // Qualification Bar Chart
    const qualificationCtx = document.getElementById('qualificationChart').getContext('2d');
    const qualificationData = {
        labels: <?php echo json_encode(array_column($qualification_data, 'highest_qualification')); ?>,
        datasets: [{
            label: 'Number of Staff',
            data: <?php echo json_encode(array_column($qualification_data, 'count')); ?>,
            backgroundColor: '#4CAF50',
            borderColor: '#388E3C',
            borderWidth: 1
        }]
    };
    const qualificationChart = new Chart(qualificationCtx, {
        type: 'bar',
        data: qualificationData
    });
</script>

</body>
</html>
