<?php
require_once 'middleware/auth.php';
require_once 'config/database.php';
checkAuth();

// Get photos based on filter (my photos or all photos)
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
if ($filter === 'my') {
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM photos p 
                          JOIN users u ON p.user_id = u.id 
                          WHERE p.user_id = ? 
                          ORDER BY p.upload_date DESC");
    $stmt->execute([$_SESSION['user_id']]);
} else {
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM photos p 
                          JOIN users u ON p.user_id = u.id 
                          ORDER BY p.upload_date DESC");
    $stmt->execute();
}
$photos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .photo-card {
            transition: transform 0.2s;
        }
        .photo-card:hover {
            transform: translateY(-5px);
        }
        .user-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Photo App</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-item nav-link" href="upload.php">Upload</a>
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Photo Gallery</h2>
            <div class="btn-group">
                <a href="?filter=all" class="btn btn-<?php echo $filter === 'all' ? 'primary' : 'outline-primary'; ?>">
                    All Photos
                </a>
                <a href="?filter=my" class="btn btn-<?php echo $filter === 'my' ? 'primary' : 'outline-primary'; ?>">
                    My Photos
                </a>
            </div>
        </div>

        <div class="row">
            <?php if (empty($photos)): ?>
                <div class="col-12">
                    <div class="alert alert-info">No photos found.</div>
                </div>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card photo-card">
                            <div class="position-relative">
                                <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" 
                                     class="card-img-top" 
                                     alt="Photo"
                                     style="height: 200px; object-fit: cover;">
                                <span class="user-badge">
                                    <i class="fas fa-user mr-1"></i>
                                    <?php echo htmlspecialchars($photo['username']); ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <small class="text-muted">
                                        Uploaded: <?php echo date('Y-m-d H:i', strtotime($photo['upload_date'])); ?>
                                    </small>
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="view.php?file=<?php echo urlencode($photo['filename']); ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye mr-1"></i> View Photo
                                    </a>
                                    <?php if ($photo['user_id'] == $_SESSION['user_id']): ?>
                                        <span class="badge badge-success align-self-center">My Photo</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>