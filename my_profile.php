<?php
session_start();
include 'connection/database.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Get user details
$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $picture_name = $user['picture']; // Default to current picture

    // Handle profile picture update
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "uploads/student_validation/";
        $new_picture_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $new_picture_name;

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $picture_name = $new_picture_name;
        }
    }

    // Update user info
    $stmt = $conn->prepare("UPDATE tbl_users SET first_name = ?, last_name = ?, email = ?, picture = ? WHERE id = ?");
    $stmt->execute([$first_name, $last_name, $email, $picture_name, $user_id]);

    // Redirect to refresh data
    header("Location: my_profile.php?updated=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Tutoring System</title>
    <link rel="stylesheet" href="assets/css/my_profile.css">
</head>

<body>
    <div class="header">
        <h1>My Profile</h1>
        <div>
            <span>Welcome, <?= htmlspecialchars($user['username']) ?></span>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <ul class="nav-menu">
                    <li><a href="student_dashboard.php">Dashboard</a></li>
                    <li><a href="find_tutor.php">Find a Tutor</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="my_profile.php" class="active" style="color: white;">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">My Profile</h2>

                <?php if (isset($_GET['updated'])): ?>
                    <div class="success">Profile updated successfully.</div>
                <?php endif; ?>

                <form action="my_profile.php" method="post" enctype="multipart/form-data">
                    <div class="profile-container">
                        <div>
                            <img src="uploads/student_validation/<?= htmlspecialchars($user['picture']) ?>" alt="Profile Picture" class="profile-pic">

                            <div class="form-group">
                                <label>Change Profile Picture</label>
                                <div class="file-input-container">
                                    <label for="profile_pic" class="file-input-label">
                                        Choose Image
                                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="file-input">
                                    </label>
                                </div>
                                <div id="file-name" style="margin-top: 5px; font-size: 0.9em;"></div>
                            </div>
                        </div>

                        <div class="profile-info">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" value="student" readonly>
                            </div>

                            <button type="submit" class="btn">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile_pic').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = 'Selected: ' + fileName;
        });
    </script>
</body>

</html>