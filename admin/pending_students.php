<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;

    if ($userId) {
        if (isset($_POST['approve_student'])) {
            $updateStmt = $conn->prepare("UPDATE tbl_users SET is_verified = 1 WHERE id = ?");
            $updateStmt->execute([$userId]);
        } elseif (isset($_POST['reject_student'])) {
            $deleteStmt = $conn->prepare("DELETE FROM tbl_users WHERE id = ?");
            $deleteStmt->execute([$userId]);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE is_verified = 0");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="css/pending_students.css">
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
                    <li><a href="dashboard.php" data-tab="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="manage_students.php" data-tab="users"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="manage_tutors.php" data-tab="tutors"><i class="fas fa-chalkboard-teacher"></i> Tutors</a></li>
                    <li><a href="pending_students.php" class="active" data-tab="pending_students"><i class="fas fa-user-clock"></i> Pending Students</a></li>
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
                    <div class="tab" data-tab="dashboard" onclick="window.location.href = 'dashboard.php'">Dashboard</div>
                    <div class="tab" data-tab="users" onclick="window.location.href = 'manage_students.php'">Users (<?= $approved_student_count ?>)</div>
                    <div class="tab" data-tab="tutors" onclick="window.location.href = 'manage_tutors.php'">
                        Approved Tutors (<?= $approved_tutor_count ?>)
                    </div>
                    <div class="tab" data-tab="pending" onclick="window.location.href = 'pending_tutors.php'">Pending Tutors (<?= $pending_tutor_count ?>)</div>
                </div>
            </div>

            <div id="imageModal" class="custom-modal">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <img class="modal-content" id="modalImage" alt="Large preview">
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Pending Student Applications</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo / Valid ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Applied</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['id']) ?></td>
                                <td>
                                    <img src="../uploads/student_validation/<?= htmlspecialchars($student['picture']) ?>"
                                        width="50" height="50" style="border-radius: 50%; cursor: pointer;"
                                        onclick="openModal('<?= htmlspecialchars($student['picture']) ?>')">
                                </td>

                                <td><?= htmlspecialchars($student['username']) ?></td>
                                <td><?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= date("F j, Y", strtotime($student['created_at'])) ?></td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                                        <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                                        <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <script>
                function openModal(imageFileName) {
                    const modal = document.getElementById('imageModal');
                    const modalImg = document.getElementById('modalImage');
                    modalImg.src = "../uploads/student_validation/" + imageFileName;
                    modal.style.display = "flex";
                }

                function closeModal() {
                    document.getElementById('imageModal').style.display = "none";
                }
            </script>


</body>

</html>