<?php
require_once 'middleware/auth.php';
require_once 'config/database.php';
checkAuth();

if (isset($_GET['file'])) {
    $filename = $_GET['file'];
    
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM photos p 
                          JOIN users u ON p.user_id = u.id 
                          WHERE p.filename = ?");
    $stmt->execute([$filename]);
    $photo = $stmt->fetch();
}

if (!$photo) {
    header('Location: gallery.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Photo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .photo-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .photo-container img {
            max-width: 100%;
            height: auto;
        }
        .photo-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Photo App</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="gallery.php">Back to Gallery</a>
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="photo-container">
            <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" 
                 alt="Photo"
                 class="mb-3">
            
            <div class="photo-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5><i class="fas fa-user mr-2"></i><?php echo htmlspecialchars($photo['username']); ?></h5>
                        <p class="text-muted mb-0">
                            Uploaded: <?php echo date('Y-m-d H:i', strtotime($photo['upload_date'])); ?>
                        </p>
                    </div>
                    <a href="download.php?file=<?php echo urlencode($photo['filename']); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-download mr-1"></i> Download Photo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>