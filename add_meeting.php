<?php
// Include the necessary database connection
include('config.php');

// Initialize variables
$meeting_title = '';
$meeting_date = '';
$meeting_time = '';
$venue = '';
$department = '';
$remarks = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $meeting_title = $_POST['meeting_title'];
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    $venue = $_POST['venue'];
    $department = $_POST['department'];
    $remarks = $_POST['remarks'];

    // Validate required fields
    if (empty($meeting_title) || empty($meeting_date) || empty($meeting_time) || empty($venue)) {
        $error_message = "All fields are required!";
    } else {
        // Insert the meeting data into the database
        try {
            $query = "INSERT INTO meetings (meeting_title, meeting_date, meeting_time, venue, department, remarks) 
                      VALUES (:meeting_title, :meeting_date, :meeting_time, :venue, :department, :remarks)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':meeting_title', $meeting_title);
            $stmt->bindParam(':meeting_date', $meeting_date);
            $stmt->bindParam(':meeting_time', $meeting_time);
            $stmt->bindParam(':venue', $venue);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->execute();

            $success_message = "Meeting added successfully!";
            // Clear form data
            $meeting_title = '';
            $meeting_date = '';
            $meeting_time = '';
            $venue = '';
            $department = '';
            $remarks = '';
        } catch (Exception $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meeting | UHAS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #28a745;">
        <a class="navbar-brand" href="home.php">UHAS</a>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Add New Meeting</h2>

        <!-- Display Success or Error Message -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="add_meeting.php" method="POST" class="bg-light p-4 rounded">
            <div class="mb-3">
                <label for="meeting_title" class="form-label">Meeting Title</label>
                <input type="text" class="form-control" id="meeting_title" name="meeting_title" value="<?php echo $meeting_title; ?>" required>
            </div>

            <div class="mb-3">
                <label for="meeting_date" class="form-label">Meeting Date</label>
                <input type="date" class="form-control" id="meeting_date" name="meeting_date" value="<?php echo $meeting_date; ?>" required>
            </div>

            <div class="mb-3">
                <label for="meeting_time" class="form-label">Meeting Time</label>
                <input type="time" class="form-control" id="meeting_time" name="meeting_time" value="<?php echo $meeting_time; ?>" required>
            </div>

            <div class="mb-3">
                <label for="venue" class="form-label">Venue</label>
                <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $venue; ?>" required>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="Directorate of ICT" <?php echo ($department == 'Directorate of ICT') ? 'selected' : ''; ?>>Directorate of ICT</option>
                     <option value="Directorate of HR" <?php echo ($department == 'Directorate of HR') ? 'selected' : ''; ?>>Directorate of HR</option>
                      <option value="Directorate of PROCUREMENT" <?php echo ($department == 'Directorate of PROCUREMENT') ? 'selected' : ''; ?>>Directorate of PROCUREMENT</option>
                       <option value="Directorate of WORKS & PHYSICAL DEVT" <?php echo ($department == 'Directorate of WORKS & PHYSICAL DEVT ') ? 'selected' : ''; ?>>Directorate of WORKS & PHYSICAL DEV'T</option>
                    <option value="Directorate of Academic Affairs" <?php echo ($department == 'Directorate of Academic Affairs') ? 'selected' : ''; ?>>Directorate of Academic Affairs</option>
                    <option value="Directorate of Finance" <?php echo ($department == 'Directorate of Finance') ? 'selected' : ''; ?>>Directorate of Finance</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (Optional)</label>
                <textarea class="form-control" id="remarks" name="remarks"><?php echo $remarks; ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Add Meeting</button>
                <a href="meetings.php" class="btn btn-secondary">Back to Meetings</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer text-center mt-5" style="background-color: #28a745; color: white; padding: 10px;">
        <p>&copy; 2024 UHAS - University of Health and Allied Sciences. All Rights Reserved.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
