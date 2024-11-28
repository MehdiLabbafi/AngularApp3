<?php
// Enable error reporting for all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set CORS headers for Angular communication
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Check for file upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'File upload error: ' . $file['error']]);
            exit;
        }

        // Set the upload directory
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // File name
        $coverImagePath = basename($file['name']);
        
        // Move the uploaded file to the upload directory
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $coverImagePath)) {
            echo json_encode(['success' => true, 'filePath' => $coverImagePath]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to upload the file']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>