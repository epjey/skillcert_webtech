<?php
include("../../config/db_conn.php");

// Folder to store uploaded lesson images
$uploadDir = '../../uploads/lesson_files/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['file']['name'])) {
    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $targetFile = $uploadDir . $fileName;

    // Validate image types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($_FILES['file']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo "Invalid file type";
        exit;
    }

    // Move the uploaded image
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        // Return correct URL for Summernote
        $imageURL = '/skillcertsystem/uploads/lesson_files/' . $fileName;
        echo $imageURL;
    } else {
        http_response_code(500);
        echo "Upload failed";
    }
}
?>
