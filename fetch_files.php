<?php
// Ensure folder is specified
if (isset($_GET['folder'])) {
    $folder = $_GET['folder'];
    $files = [];

    // Check if folder exists
    if (is_dir($folder)) {
        // Get all files in the folder
        $fileList = glob($folder . '/*');
        
        foreach ($fileList as $file) {
            if (is_file($file)) {
                $files[] = [
                    'name' => basename($file),
                    'path' => $file
                ];
            }
        }
    }

    // Return JSON response
    echo json_encode($files);
}
?>
