<?php
include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['tutor_id'] ?? null;

    if ($userId) {
        if (isset($_POST['approve_tutor'])) {
            $updateStmt = $conn->prepare("UPDATE tbl_tutor SET is_verified = 1 WHERE id = ?");
            $updateStmt->execute([$userId]);
        } elseif (isset($_POST['reject_turo'])) {
            $deleteStmt = $conn->prepare("DELETE FROM tbl_tutor WHERE id = ?");
            $deleteStmt->execute([$userId]);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM tbl_tutor WHERE is_verified = 0");
$stmt->execute();
$tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="css/pending_tutors.css">
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
                    <li><a href="pending_students.php" data-tab="pending_students"><i class="fas fa-user-clock"></i> Pending Students ()</a></li>
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
                    <span>Welcome, Izziah Bayani</span>
                </div>
            </div>

            <div class="tab-container">
                <div class="tabs">
                    <div class="tab" data-tab="dashboard" onclick="window.location.href = 'dashboard.php'">Dashboard</div>
                    <div class="tab" data-tab="users" onclick="window.location.href = 'manage_students.php'">Users (<?= $approved_student_count ?>)</div>
                    <div class="tab" data-tab="tutors" onclick="window.location.href = 'manage_tutors.php'">
                        Approved Tutors (<?= $approved_tutor_count ?>)
                    </div>
                    <div class="tab active" data-tab="pending" onclick="window.location.href = 'pending_tutors.php'">Pending Tutors (<?= $pending_tutor_count ?>)</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Pending Tutors Applications</h3>
                </div>

                <div id="imageModal" class="custom-modal">
                    <span class="close-modal" onclick="closeModal()">&times;</span>
                    <img class="modal-content" id="modalImage" alt="Large preview">
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Applied</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tutors as $tutor): ?>
                            <tr>
                                <td><?= htmlspecialchars($tutor['id']) ?></td>
                                <td>
                                    <img src="../uploads/tutor_validation/<?= htmlspecialchars($tutor['picture']) ?>"
                                        width="50" height="50" style="border-radius: 50%; cursor: pointer;"
                                        onclick="openModal('<?= htmlspecialchars($tutor['picture']) ?>')">
                                </td>

                                <td><?= htmlspecialchars($tutor['username']) ?></td>
                                <td><?= htmlspecialchars($tutor['first_name']) ?> <?= htmlspecialchars($tutor['last_name']) ?></td>
                                <td><?= htmlspecialchars($tutor['email']) ?></td>
                                <td><?= date("F j, Y", strtotime($tutor['created_at'])) ?></td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="tutor_id" value="<?= $tutor['id'] ?>">
                                        <button type="submit" name="approve_tutor" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="tutor_id" value="<?= $tutor['id'] ?>">
                                        <button type="submit" name="reject_tutor" class="btn btn-danger">Reject</button>
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
                    modalImg.src = "../uploads/tutor_validation/" + imageFileName;
                    modal.style.display = "flex";
                }

                function closeModal() {
                    document.getElementById('imageModal').style.display = "none";
                }
            </script>

</body>

</html>