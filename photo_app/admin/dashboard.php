<?php
require_once '../middleware/admin_auth.php';
require_once '../config/database.php';
checkAdmin();

// Get user statistics
$stmt = $pdo->query("SELECT 
    COUNT(DISTINCT u.id) as total_users,
    COUNT(p.id) as total_photos
    FROM users u
    LEFT JOIN photos p ON u.id = p.user_id
    WHERE u.is_admin = FALSE");
$stats = $stmt->fetch();

// Get recent uploads
$stmt = $pdo->query("SELECT 
    u.username,
    p.filename,
    p.upload_date
    FROM photos p
    JOIN users u ON p.user_id = u.id
    WHERE u.is_admin = FALSE
    ORDER BY p.upload_date DESC
    LIMIT 10");
$recent_uploads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --admin-primary: #2c3e50;
            --admin-secondary: #34495e;
        }
        .navbar {
            background-color: var(--admin-primary) !important;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stats-icon {
            font-size: 2rem;
            color: var(--admin-primary);
        }
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt mr-2"></i>Admin Panel
            </a>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon mr-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="mb-0"><?php echo $stats['total_users']; ?></h3>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon mr-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon mr-3">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <h3 class="mb-0"><?php echo $stats['total_photos']; ?></h3>
                            <p class="text-muted mb-0">Total Photos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h4 class="mb-4">Recent Uploads</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>File Name</th>
                        <th>Upload Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_uploads as $upload): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($upload['username']); ?></td>
                        <td><?php echo htmlspecialchars($upload['filename']); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($upload['upload_date'])); ?></td>
                        <td>
                            <a href="../uploads/<?php echo urlencode($upload['filename']); ?>" 
                               class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>