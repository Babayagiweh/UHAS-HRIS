<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Session security check
if (!isset($_SESSION['user_id'])) {
    die("Session expired. Please log in again.<br>");
}

// Database connection
include('config.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Record login activity and return the inserted log ID.
 */
function recordLoginActivity($conn, $userId, $username, $firstName, $lastName, $email) {
    $loginTime = date("Y-m-d H:i:s");
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

    $stmt = $conn->prepare("INSERT INTO login_logs (user_id, username, first_name, last_name, email, login_time, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }
    $stmt->bind_param("isssssss", $userId, $username, $firstName, $lastName, $email, $loginTime, $ipAddress, $userAgent);

    if (!$stmt->execute()) {
        error_log("Error recording login activity: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $logId = $conn->insert_id;
    $stmt->close();
    return $logId;
}

/**
 * Record an action for the current login log.
 */
function recordAction($conn, $loginLogId, $action) {
    $logQuery = "UPDATE login_logs SET actions = CONCAT(IFNULL(actions, ''), ?) WHERE id = ?";
    $stmt = $conn->prepare($logQuery);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return;
    }
    $formattedAction = date("Y-m-d H:i:s") . " - " . $action . "\n";
    $stmt->bind_param("si", $formattedAction, $loginLogId);

    if (!$stmt->execute()) {
        error_log("Error recording action: " . $stmt->error);
    }
    $stmt->close();
}

// AJAX: Capture action sent via POST
if (isset($_POST['action'])) {
    if (isset($_SESSION['login_log_id'])) {
        recordAction($conn, $_SESSION['login_log_id'], $_POST['action']);
    } else {
        // Fallback: update the latest login log for the user
        $userId = $_SESSION['user_id'];
        $logQuery = "UPDATE login_logs SET actions = CONCAT(IFNULL(actions, ''), ?) WHERE user_id = ? ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($logQuery);
        $formattedAction = date("Y-m-d H:i:s") . " - " . $_POST['action'] . "\n";
        $stmt->bind_param("si", $formattedAction, $userId);
        if (!$stmt->execute()) {
            error_log("Error recording action: " . $stmt->error);
        }
        $stmt->close();
    }
    header('Content-Type: application/json');
    echo json_encode(["status" => "success", "message" => "Action recorded"]);
    exit();
}

// Pagination settings
$limit = 10;  // Number of logs per page
$page = isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) 
    ? (int)$_GET['page'] 
    : 1;
$offset = ($page - 1) * $limit;

$adminId = $_SESSION['user_id'];

// Fetch admin details
$stmt = $conn->prepare("SELECT username, first_name, last_name, email FROM admin WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
$adminData = $result->fetch_assoc();
$stmt->close();

if ($adminData) {
    // Record login for the admin user and store the log ID in session
    $loginLogId = recordLoginActivity($conn, $adminId, $adminData['username'], $adminData['first_name'], $adminData['last_name'], $adminData['email']);
    if ($loginLogId) {
        $_SESSION['login_log_id'] = $loginLogId;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Logs</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            header {
                background-color: #006400;
                color: #fff;
                padding: 20px;
                width: 100%;
                text-align: center;
            }
            header img {
                width: 50px;
                vertical-align: middle;
            }
            .container {
                max-width: 1200px;
                width: 100%;
                margin-top: 20px;
                padding: 0 15px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #006400;
                color: #fff;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            footer {
                background-color: #006400;
                color: #fff;
                padding: 10px;
                width: 100%;
                text-align: center;
                position: fixed;
                bottom: 0;
                left: 0;
            }
            .yellow {
                color: #FFD700;
            }
            .button {
                background-color: #006400;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                margin: 20px 5px;
                display: inline-block;
            }
            .button:hover {
                background-color: #004d00;
            }
            .pagination {
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <header>
            <img src="uhas_logo.png" alt="UHAS Logo" />
            <h1>Welcome to UHAS Admin Dashboard</h1>
        </header>
        <div class="container">
            <h2>Login Activity for User: <?php echo htmlspecialchars($adminData['username'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Login Time</th>
                        <th>Actions</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch paginated login logs from the database
                    $logQuery = "SELECT * FROM login_logs ORDER BY login_time DESC LIMIT ? OFFSET ?";
                    $stmt = $conn->prepare($logQuery);
                    if ($stmt) {
                        $stmt->bind_param("ii", $limit, $offset);
                        $stmt->execute();
                        $logResult = $stmt->get_result();
                        $sn = $offset + 1;
                        while ($logRow = $logResult->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($logRow['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($logRow['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($logRow['first_name'] . " " . $logRow['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($logRow['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($logRow['login_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($logRow['actions'] ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                                <td><?php echo htmlspecialchars($logRow['ip_address'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <?php
                        }
                        $stmt->close();
                    } else {
                        echo "<tr><td colspan='8'>Error fetching logs: " . htmlspecialchars($conn->error) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                // Pagination Links
                $totalQuery = "SELECT COUNT(*) AS total FROM login_logs";
                $result = $conn->query($totalQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    $totalLogs = $row['total'];
                    $totalPages = ceil($totalLogs / $limit);

                    // Previous button
                    if ($page > 1) {
                        echo "<a href='?page=" . ($page - 1) . "' class='button'>Previous</a>";
                    }

                    // Next button
                    if ($page < $totalPages) {
                        echo "<a href='?page=" . ($page + 1) . "' class='button'>Next</a>";
                    }
                }
                ?>
            </div>
            <a href="home.php" class="button">Back to Home</a>
        </div>
        <footer>
            <p>&copy; 2024 University of Health and Allied Sciences. All rights reserved. <span class="yellow">Go Green!</span></p>
        </footer>
        <script>
            // Function to record actions via AJAX
            function recordAction(action) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);  // Posting to the same file
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log('Action recorded: ' + action);
                    }
                };
                xhr.send('action=' + encodeURIComponent(action));
            }

            // Example: Record page load action
            window.addEventListener('load', function() {
                recordAction('Page Loaded');
            });

            // Example: Record a button click if the button exists
            var someButton = document.getElementById('someButton');
            if (someButton) {
                someButton.addEventListener('click', function() {
                    recordAction("Clicked 'Some Button'");
                });
            }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "No admin data found for admin_id: " . htmlspecialchars($adminId, ENT_QUOTES, 'UTF-8') . "<br>";
}

$conn->close();
?>
