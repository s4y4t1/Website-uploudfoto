<?php
require_once 'middleware/auth.php';
require_once 'config/database.php';
checkAuth();

if (isset($_GET['file'])) {
    $filename = $_GET['file'];
    
    // Verify that the file exists in the database
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM photos p 
                          JOIN users u ON p.user_id = u.id 
                          WHERE p.filename = ?");
    $stmt->execute([$filename]);
    $photo = $stmt->fetch();
    
    if ($photo) {
        $filepath = 'uploads/' . $filename;
        if (file_exists($filepath)) {
            // Set headers for download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            // Output file content
            readfile($filepath);
            exit();
        }
    }
}

// If file not found or invalid, redirect back to gallery
header('Location: gallery.php');
exit();
?>