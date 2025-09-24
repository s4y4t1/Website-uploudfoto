<?php
require_once 'middleware/auth.php';
require_once 'config/database.php';
checkAuth();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Photo App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --light-blue: #f0f6ff;
        }
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: var(--primary-blue) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            background: white;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }
        .welcome-section {
            background: var(--light-blue);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 10px;
        }
        .stats-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="#">
                <i class="fas fa-camera-retro mr-2"></i>Photo App
            </a>
            <div class="navbar-nav ml-auto">
                <span class="navbar-text mr-4">
                    <i class="fas fa-user mr-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a class="nav-item nav-link" href="upload.php"><i class="fas fa-upload mr-1"></i> Upload</a>
                <a class="nav-item nav-link" href="gallery.php"><i class="fas fa-images mr-1"></i> Gallery</a>
                <a class="nav-item nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="welcome-section">
            <div class="container">
                <h2><i class="fas fa-smile mr-2"></i>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p class="text-muted">Manage your photos and memories in one place.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="dashboard-card card h-100">
                    <div class="card-body text-center">
                        <div class="card-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h5 class="card-title">Upload Photos</h5>
                        <p class="card-text">Add new photos to your collection</p>
                        <a href="upload.php" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Upload Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="dashboard-card card h-100">
                    <div class="card-body text-center">
                        <div class="card-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h5 class="card-title">My Gallery</h5>
                        <p class="card-text">View and manage your photo collection</p>
                        <a href="gallery.php" class="btn btn-primary">
                            <i class="fas fa-eye mr-1"></i> View Gallery
                        </a>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>