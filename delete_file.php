<?php
// delete_file.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the file path from the request body
    $data = json_decode(file_get_contents('php://input'), true);
    $filePath = $data['filePath'];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Delete the file from the server
        if (unlink($filePath)) {
            // Optionally, remove the record from the database
            require_once 'db.connect.php';  // Ensure the database connection is included
            $fileName = basename($filePath);  // Extract file name to match DB entry
            $stmt = $conn->prepare("DELETE FROM personnel_file WHERE file_name = ?");
            $stmt->bind_param("s", $fileName);  // Remove the record from DB
            $stmt->execute();
            
            // Return success response
            echo json_encode(['success' => true]);
        } else {
            // File delete failed
            echo json_encode(['success' => false, 'message' => 'Failed to delete file from server.']);
        }
    } else {
        // File doesn't exist
        echo json_encode(['success' => false, 'message' => 'File not found.']);
    }
}
?>
