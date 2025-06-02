<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// count approved students
$stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_users WHERE is_verified = 1");
$stmt->execute();
$approved_student_count = $stmt->fetchColumn();

// count approved tutor
$stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_tutor WHERE is_verified = 1");
$stmt->execute();
$approved_tutor_count = $stmt->fetchColumn();

// count pending tutor
$stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_tutor WHERE is_verified = 0");
$stmt->execute();
$pending_tutor_count = $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
                <p>admin</p>
            </div>

            <div class="sidebar-menu">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="#" class="active" data-tab="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="manage_students.php" data-tab="users"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="manage_tutors.php" data-tab="tutors"><i class="fas fa-chalkboard-teacher"></i> Tutors</a></li>
                    <li><a href="pending_students.php" data-tab="pending_students"><i class="fas fa-user-clock"></i> Pending Students</a></li>
                </ul>

                <h4>Account</h4>
                <ul>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h2>Admin Dashboard</h2>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                </div>
            </div>

            <div class="tab-container">
                <div class="tabs">
                    <div class="tab active" data-tab="dashboard" onclick="window.location.href = 'dashboard.php'">Dashboard</div>
                    <div class="tab" data-tab="users" onclick="window.location.href = 'manage_students.php'">Users (<?= $approved_student_count ?>)</div>
                    <div class="tab" data-tab="tutors" onclick="window.location.href = 'manage_tutors.php'">
                        Approved Tutors (<?= $approved_tutor_count ?>)
                    </div>
                    <div class="tab" data-tab="pending" onclick="window.location.href = 'pending_tutors.php'">Pending Tutors (<?= $pending_tutor_count ?>)</div>
                </div>
            </div>

            <!-- Dashboard Tab -->
            <div class="tab-content active" id="dashboard">
                <div class="card">
                    <h3>System Overview</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                        <div class="card" style="text-align: center;">
                            <h4>Approved Students</h4>
                            <p style="font-size: 24px; font-weight: bold;"><?= $approved_student_count ?></p>
                        </div>
                        <div class="card" style="text-align: center;">
                            <h4>Approved Tutors</h4>
                            <p style="font-size: 24px; font-weight: bold;"><?= $approved_tutor_count ?></p>
                        </div>
                        <div class="card" style="text-align: center;">
                            <h4>Pending Tutors</h4>
                            <p style="font-size: 24px; font-weight: bold;"><?= $pending_tutor_count ?></p>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>