<?php
// Database connection
require_once 'db.connect.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch staff data for dropdown
$staffQuery = "SELECT staff_id, full_name FROM staff ORDER BY full_name ASC";
$staffResult = $conn->query($staffQuery);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
    $staff_id = $_POST['staff_id'];

    // Fetch staff name
    $staffNameQuery = $conn->prepare("SELECT full_name FROM staff WHERE staff_id = ?");
    $staffNameQuery->bind_param("s", $staff_id);
    $staffNameQuery->execute();
    $staffNameQuery->bind_result($full_name);
    $staffNameQuery->fetch();
    $staffNameQuery->close();

    // Create folder
    $staffFolder = "uploads/" . str_replace(" ", "_", $full_name) . "/";
    if (!is_dir($staffFolder)) {
        mkdir($staffFolder, 0755, true);
    }

    // Handle multiple file uploads
    $files = $_FILES['files'];
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip'];

    for ($i = 0; $i < count($files['name']); $i++) {
        $fileName = basename($files["name"][$i]);
        $targetFilePath = $staffFolder . time() . "_" . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (in_array(strtolower($fileType), $allowedTypes)) {
            move_uploaded_file($files["tmp_name"][$i], $targetFilePath);
        }
    }

    echo "<div class='alert alert-success text-center font-weight-bold' role='alert'>
            Files uploaded successfully!
          </div>";
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $filePath = $_GET['delete'];
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "<div class='alert alert-success text-center font-weight-bold' role='alert'>
                File deleted successfully!
              </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Manage Staff Files</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            background-image: url('bg.jp');
        }
        .container {
            max-width: 1200px;
        }
        h1, h2 {
            color: #004d00; /* UHAS green */
        }
        .btn-success {
            background-color: #ffcc00; /* UHAS yellow */
            border-color: #ffcc00;
        }
        .btn-success:hover {
            background-color: #e6b800;
            border-color: #e6b800;
        }
        
        footer {
    background-color: green;
    color: white;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}
        .folder h5 {
            margin-bottom: 15px;
            color: #004d00;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
            background-color: #f9f9f9;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .pagination {
            margin-top: 20px;
        }
        footer {
            background-color: #004d00; /* UHAS green */
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 50px;
        }
        .btn-back {
            background-color: #004d00;
            color: white;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background-color: #003d00;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Back to Homepage Button -->
        <a href="home.php" class="btn btn-back btn-sm">Back to Homepage</a>

        <h1 class="text-center">Upload and Manage Staff Files</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <!-- Staff Dropdown -->
            <div class="mb-3">
                <label for="staff_id" class="form-label">Select Staff</label>
                <select name="staff_id" id="staff_id" class="form-control" required>
                    <option value="" disabled selected>-- Select Staff --</option>
                    <?php
                    if ($staffResult->num_rows > 0) {
                        while ($row = $staffResult->fetch_assoc()) {
                            echo "<option value='{$row['staff_id']}'>{$row['full_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- File Upload -->
            <div class="mb-3">
                <label for="files" class="form-label">Upload Files</label>
                <input type="file" name="files[]" id="files" class="form-control" multiple required>
            </div>

            <button type="submit" class="btn btn-success">Upload Files</button>
        </form>

        <div class="folder-container">
            <h2 class="mt-5">Uploaded Staff Folders</h2>
            <input type="text" id="search" class="form-control search-bar" placeholder="Search folders or files...">

            <?php
            $staffFolders = glob("uploads/*", GLOB_ONLYDIR);
            foreach ($staffFolders as $folder) {
                $staffName = basename($folder);
                echo "<div class='folder'>
                    <h5>" . $staffName . "</h5>
                    <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#uploadFileModal' data-staffname='$staffName'>Add Files</button>";

                $files = glob("$folder/*");
                if (!empty($files)) {
                    echo "<div class='file-list'>";
                    foreach ($files as $file) {
                        echo "<div class='file-item'>
                            <span>" . basename($file) . "</span>
                            <div>
                                <a href='$file' class='btn btn-primary btn-sm' download>Download</a>
                                <a href='?delete=$file' class='btn btn-danger btn-sm'>Delete</a>
                            </div>
                        </div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No files uploaded yet.</p>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date("Y"); ?> University of Health and Allied Sciences. All rights reserved.</p>
    </footer>
    
    <!-- Bootstrap Modal for Upload Files -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Upload Additional Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" name="files[]" class="form-control" multiple required>
                        <input type="hidden" name="staff_id" id="modalStaffId">
                        <button type="submit" class="btn btn-success mt-3">Upload Files</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Handle modal opening and setting staff ID dynamically
        var addFileButtons = document.querySelectorAll('[data-bs-target="#uploadFileModal"]');
        addFileButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var staffName = button.getAttribute('data-staffname');
                var staffId = '<?php echo $staffResult->fetch_assoc()["staff_id"]; ?>'; // This is a placeholder, ideally this should be dynamic based on selected staff
                document.getElementById('modalStaffId').value = staffId;
            });
        });
    </script>
</body>
</html>
