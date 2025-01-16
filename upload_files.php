<?php
// Include the database connection file
require_once 'db.connect.php';

// Configuration
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_POST['staff_id'] ?? null;
    $stmt = $conn->prepare("SELECT full_name FROM staff WHERE staff_id = ?");
    $stmt->bind_param("s", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staff_name = $row['full_name'];
        $safeFolderName = preg_replace("/[^a-zA-Z0-9_]/", "_", $staff_name); // Sanitize folder name
        $targetDir = UPLOAD_DIR . $safeFolderName;

        // Create the directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Loop through uploaded files
        foreach ($_FILES['files']['name'] as $key => $fileName) {
            $fileTmp = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileType = mime_content_type($fileTmp);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $targetFile = $targetDir . "/" . basename($fileName);

            // Validate file size
            if ($fileSize > MAX_FILE_SIZE) {
                echo "<div class='alert alert-danger'>File size exceeds the 10MB limit: $fileName.</div>";
                continue;
            }

            // Validate file type
            if (!in_array($fileType, $allowedTypes)) {
                echo "<div class='alert alert-danger'>Invalid file type for $fileName. Allowed: JPG, PNG, PDF, DOCX.</div>";
                continue;
            }

            // Move the file and save record in the database
            if (move_uploaded_file($fileTmp, $targetFile)) {
                $stmt = $conn->prepare("INSERT INTO personnel_file (staff_id, full_name, file_name, uploaded_at) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $staff_id, $staff_name, $fileName);
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>File '$fileName' uploaded successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Database error: {$stmt->error}.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Failed to upload file: $fileName.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid staff ID.</div>";
    }
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Files Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f3f3;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #004d00;
            color: white;
        }
        .btn-uhas-green {
            background-color: #004d00;
            color: white;
            border: none;
        }
        .btn-uhas-green:hover {
            background-color: yellow;
        }
        .btn-uhas-yellow {
            background-color: #ffcc00;
            color: white;
            border: none;
        }
        .btn-uhas-yellow:hover {
            background-color: #e6b800;
        }
        .folder {
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: green;
            margin: 10px;
            text-align: center;
            padding: 10px;
            transition: box-shadow 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: white;


        }
        .folder:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .folder-icon {
            font-size: 50px;
            color: yellow;
        }
        .responsive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        footer {
             background-color: #004d00;
    color: white;
    text-align: center;
    padding: 10px;
    margin-top: auto; /* This pushes the footer to the bottom */
    width: normal;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Staff Files Management</h1>
    </div>
    <br>
<div> <a href="home.php" class="btn btn-uhas-green ">Back to Homepage</a></div>
    <div class="container mt-4">
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="staff" class="form-label">Select Staff</label>
                    <select name="staff_id" id="staff" class="form-select" required>
                        <option value="" disabled selected>-- Select Staff --</option>
                        <?php
                        // Fetch staff data from database
                        require_once 'db.connect.php';
                        $query = "SELECT staff_id, full_name FROM staff ORDER BY full_name ASC";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['staff_id']}'>{$row['full_name']} ({$row['staff_id']})</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
    <label for="files" class="form-label">Upload Files</label>
    <input type="file" name="files[]" id="files" class="form-control" multiple required>
</div>
<div class="col-md-2 align-self-end">
    <button type="submit" class="btn btn-uhas-green w-100">Upload </button>  
</div>

        </form>

        <div class="responsive-grid">
    <?php
    $folders = glob("uploads/*", GLOB_ONLYDIR);
    if (!empty($folders)) {
        foreach ($folders as $folder) {
            $staffName = basename($folder);
            $fileCount = count(glob("$folder/*"));
            $lastModified = date("d M Y, h:i A", filemtime($folder));

            echo "<div class='folder'>
                    <i class='fa-solid fa-folder folder-icon'></i>
                    <h5 class='mt-2'>$staffName</h5>
                    <p><strong>$fileCount Files</strong></p>
                    <p>Last Modified: $lastModified</p>
                    <button class='btn btn-uhas-yellow btn-sm view-files' data-folder='$folder'>View Files</button>
                    
                    <!-- Add Files Form -->
                    <form method='POST' enctype='multipart/form-data' class='mt-2'>
                        <input type='hidden' name='folder_name' value='$folder'>
                        <input type='file' name='files[]' multiple class='form-control form-control-sm'>
                        
                    </form>
                </div>";
        }
    } else {
        echo "<p>No staff folders available yet.</p>";
    }
    ?>
</div>

    </div>

    <footer>
        <p>&copy; <?= date("Y"); ?> University of Health and Allied Sciences. All rights reserved.</p>
    </footer>

    <!-- Modal for Viewing Files -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">Files in Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="fileList" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.view-files').forEach(button => {
    button.addEventListener('click', () => {
        const folder = button.getAttribute('data-folder');
        fetch(`fetch_files.php?folder=${encodeURIComponent(folder)}`)
            .then(response => response.json())
            .then(files => {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = ''; // Clear previous list items

                if (files.length) {
                    files.forEach(file => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item d-flex justify-content-between align-items-center';
                        li.innerHTML = `<span>${file.name}</span>
                                        <div>
                                            <a href="${file.path}" class="btn btn-success btn-sm" download>Download</a>
                                            <button class="btn btn-danger btn-sm delete-file" data-file="${file.path}">Delete</button>
                                        </div>`;
                        fileList.appendChild(li);
                    });
                } else {
                    fileList.innerHTML = '<p>No files in this folder.</p>';
                }

                // Show the modal
                new bootstrap.Modal(document.getElementById('fileModal')).show();
            })
            .catch(error => {
                console.error('Error fetching files:', error);
                alert('Failed to load files.');
            });
    });
});

    </script>

<script>
   document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-file')) {
        const filePath = event.target.getAttribute('data-file');

        // Ask for confirmation before deleting
        if (confirm("Are you sure you want to delete this file?")) {
            // Show a loading indicator
            const button = event.target;
            button.innerHTML = 'Deleting...';
            button.disabled = true;

            fetch('delete_file.php', {
                method: 'POST',
                body: JSON.stringify({ filePath }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('File deleted successfully!');
                    // Remove the file from the UI
                    button.closest('li').remove();  // Remove the list item containing the file
                } else {
                    alert('Error: ' + (data.message || 'Failed to delete file.'));
                }
            })
            .catch(() => {
                alert('An error occurred while deleting the file.');
            })
            .finally(() => {
                // Reset the button after the process is finished
                button.innerHTML = 'Delete';
                button.disabled = false;
            });
        }
    }
});


</script>

</body>
</html>
