<?php
require_once 'middleware/auth.php';
require_once 'config/database.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (in_array($file['type'], $allowedTypes)) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $filename = uniqid() . '_' . $file['name'];
            $destination = $uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $stmt = $pdo->prepare("INSERT INTO photos (user_id, filename) VALUES (?, ?)");
                $stmt->execute([$_SESSION['user_id'], $filename]);
                $success = "Photo uploaded successfully!";
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type. Please upload JPG, PNG, or GIF.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Photo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Photo App</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-item nav-link" href="gallery.php">My Photos</a>
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Upload Photo</div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Select Photo</label>
                                <input type="file" name="photo" class="form-control-file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>