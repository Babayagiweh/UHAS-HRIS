<?php
// Include the necessary database connection
include('config.php');

// Initialize variables
$seminar_title = '';
$seminar_date = '';
$seminar_time = '';
$venue = '';
$department = '';
$remarks = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $seminar_title = $_POST['seminar_title'];
    $seminar_date = $_POST['seminar_date'];
    $seminar_time = $_POST['seminar_time'];
    $venue = $_POST['venue'];
    $department = $_POST['department'];
    $remarks = $_POST['remarks'];

    // Validate required fields
    if (empty($seminar_title) || empty($seminar_date) || empty($seminar_time) || empty($venue)) {
        $error_message = "All fields are required!";
    } else {
        // Insert the seminar data into the database
        try {
            $query = "INSERT INTO seminars (seminar_title, seminar_date, seminar_time, venue, department, remarks) 
                      VALUES (:seminar_title, :seminar_date, :seminar_time, :venue, :department, :remarks)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':seminar_title', $seminar_title);
            $stmt->bindParam(':seminar_date', $seminar_date);
            $stmt->bindParam(':seminar_time', $seminar_time);
            $stmt->bindParam(':venue', $venue);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->execute();

            $success_message = "Seminar added successfully!";
            // Clear form data
            $seminar_title = '';
            $seminar_date = '';
            $seminar_time = '';
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
    <title>Add Seminar | UHAS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #28a745;">
        <a class="navbar-brand" href="home.php">UHAS</a>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Add New Seminar</h2>

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

        <form action="add_seminar.php" method="POST" class="bg-light p-4 rounded">
            <div class="mb-3">
                <label for="seminar_title" class="form-label">Seminar Title</label>
                <input type="text" class="form-control" id="seminar_title" name="seminar_title" value="<?php echo $seminar_title; ?>" required>
            </div>

            <div class="mb-3">
                <label for="seminar_date" class="form-label">Seminar Date</label>
                <input type="date" class="form-control" id="seminar_date" name="seminar_date" value="<?php echo $seminar_date; ?>" required>
            </div>

            <div class="mb-3">
                <label for="seminar_time" class="form-label">Seminar Time</label>
                <input type="time" class="form-control" id="seminar_time" name="seminar_time" value="<?php echo $seminar_time; ?>" required>
            </div>

            <div class="mb-3">
                <label for="venue" class="form-label">Venue</label>
                <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $venue; ?>" required>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="Directorate of ICT" <?php echo ($department == 'Directorate of ICT') ? 'selected' : ''; ?>>Directorate of ICT</option>
                    <option value="Directorate of Academic Affairs" <?php echo ($department == 'Directorate of Academic Affairs') ? 'selected' : ''; ?>>Directorate of Academic Affairs</option>
                    <option value="Directorate of Finance" <?php echo ($department == 'Directorate of Finance') ? 'selected' : ''; ?>>Directorate of Finance</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (Optional)</label>
                <textarea class="form-control" id="remarks" name="remarks"><?php echo $remarks; ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Add Seminar</button>
                <a href="serminars.php" class="btn btn-secondary">Back to Seminars</a>
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
