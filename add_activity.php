<?php
// Include database connection
include('config.php');

// Initialize variables to handle form submission
$title = $date = $time = $venue = $directorate = $remarks = '';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $venue = $_POST['venue'] ?? '';
    $directorate = $_POST['directorate'] ?? '';
    $remarks = $_POST['remarks'] ?? '';

    // Validate required fields
    if (empty($title) || empty($date) || empty($time) || empty($venue) || empty($directorate)) {
        $error = "All fields are required.";
    } else {
        // Insert the activity into the database
        $query = "INSERT INTO activities (activity_title, activity_date, activity_time, venue, directorate, remarks) 
                  VALUES (:title, :date, :time, :venue, :directorate, :remarks)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':directorate', $directorate);
        $stmt->bindParam(':remarks', $remarks);

        if ($stmt->execute()) {
            $success = "Activity added successfully!";
            // Clear form fields
            $title = $date = $time = $venue = $directorate = $remarks = '';
        } else {
            $error = "Failed to add the activity. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Activity | UHAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h3 class="text-center">Add New Activity</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="add_activity.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Activity Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time:</label>
                <input type="time" class="form-control" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>" required>
            </div>
            <div class="mb-3">
                <label for="venue" class="form-label">Venue:</label>
                <input type="text" class="form-control" id="venue" name="venue" value="<?php echo htmlspecialchars($venue); ?>" required>
            </div>
            <div class="mb-3">
                <label for="directorate" class="form-label">Directorate:</label>
                <select class="form-control" id="directorate" name="directorate" required>
                    <option value="">Select Directorate</option>
                    <option value="Directorate of ICT" <?php echo ($directorate == 'Directorate of ICT') ? 'selected' : ''; ?>>Directorate of ICT</option>
                     <option value="Directorate of HR" <?php echo ($directorate == 'Directorate of HR') ? 'selected' : ''; ?>>Directorate of HR</option>
                      <option value="Directorate of PROCUREMENT" <?php echo ($directorate == 'Directorate of PROCUREMENT') ? 'selected' : ''; ?>>Directorate of PROCUREMENT</option>
                    <option value="Directorate of Academic Affairs" <?php echo ($directorate == 'Directorate of Academic Affairs') ? 'selected' : ''; ?>>Directorate of Academic Affairs</option>
                    <option value="Directorate of Finance" <?php echo ($directorate == 'Directorate of Finance') ? 'selected' : ''; ?>>Directorate of Finance</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (Optional):</label>
                <textarea class="form-control" id="remarks" name="remarks"><?php echo htmlspecialchars($remarks); ?></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Add Activity</button>
            <a href="calendar_activities.php" class="btn btn-secondary">Back to Calendar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
