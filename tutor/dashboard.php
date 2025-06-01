<?php
session_start();
include '../connection/database.php';


if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

$tutor_id = $_SESSION['tutor_id'];

// Count pending students
$stmtPending = $conn->prepare("SELECT COUNT(*) FROM tbl_booking WHERE tutor_id = ? AND status = 'pending'");
$stmtPending->execute([$tutor_id]);
$pendingCount = $stmtPending->fetchColumn();

// Count approved students
$stmtApproved = $conn->prepare("SELECT COUNT(*) FROM tbl_booking WHERE tutor_id = ? AND status = 'approved'");
$stmtApproved->execute([$tutor_id]);
$approvedCount = $stmtApproved->fetchColumn();


$stmtName = $conn->prepare("SELECT first_name, last_name FROM tbl_tutor WHERE id = ?");
$stmtName->execute([$tutor_id]);
$tutor = $stmtName->fetch(PDO::FETCH_ASSOC);
$fullName = $tutor ? $tutor['first_name'] . ' ' . $tutor['last_name'] : 'Tutor';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Tutor Panel</h3>
                <p>tutor</p>
            </div>

            <div class="sidebar-menu">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="dashboard.php" class="active" data-tab="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="my_student.php" data-tab="users"><i class="fas fa-users"></i> My Student</a></li>

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
                <h2>Tutor Dashboard</h2>
                <div class="user-info">
                    <span>Welcome, <?= htmlspecialchars($fullName) ?></span>
                </div>
            </div>

            <!-- Dashboard Tab -->
            <div class="tab-content active" id="dashboard">
                <div class="card">
                    <h3>Overview</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                        <div class="card" style="text-align: center;">
                            <h4>My student</h4>
                            <p style="font-size: 24px; font-weight: bold;"><?= $approvedCount ?></p>
                        </div>
                        <div class="card" style="text-align: center;">
                            <h4>Pending student</h4>
                            <p style="font-size: 24px; font-weight: bold;"><?= $pendingCount ?></p>
                        </div>
                    </div>

                </div>
            </div>


</body>

</html>