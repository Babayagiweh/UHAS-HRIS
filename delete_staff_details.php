<?php
// Start session to use session variables for messages
session_start();

// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the staff ID is provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a statement to delete the staff record by ID
    $sql = "DELETE FROM staff WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $_SESSION['message'] = "Staff record deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting staff record: " . $conn->error;
    }

    // Redirect back to the staff list page
    header("Location: staff_details.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid staff ID.";
    header("Location: staff_details.php");
    exit();
}
?>
