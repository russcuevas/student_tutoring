<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

$tutor_id = $_SESSION['tutor_id'];



if (isset($_POST['approve_student'])) {
    $book_id = $_POST['book_id'];
    $stmt = $conn->prepare("UPDATE tbl_booking SET status = 'approved' WHERE book_id = ?");
    $stmt->execute([$book_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['reject_student'])) {
    $book_id = $_POST['book_id'];
    $stmt = $conn->prepare("DELETE FROM tbl_booking WHERE book_id = ?");
    $stmt->execute([$book_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$stmt = $conn->prepare("
    SELECT b.*, CONCAT(u.first_name, ' ', u.last_name) AS fullname, u.picture, s.subject_name 
    FROM tbl_booking b
    JOIN tbl_users u ON b.user_id = u.id
    JOIN tbl_subject s ON b.subject_id = s.id
    WHERE b.tutor_id = ?
");


$stmt->execute([$tutor_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['end_session'])) {
    $book_id = $_POST['book_id'];
    $stmt = $conn->prepare("UPDATE tbl_booking SET status = 'end session' WHERE book_id = ?");
    $stmt->execute([$book_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

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
    <link rel="stylesheet" href="css/my_student.css">
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
                    <li><a href="dashboard.php" data-tab="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="my_student.php" class="active" data-tab="users"><i class="fas fa-users"></i> My Student</a></li>

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

            <div class="card">
                <div class="card-header">
                    <h3>My Student</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Fullname</th>
                            <th>Subject</th>
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $booking['book_id'] ?></td>
                                <td>
                                    <img src="../uploads/student_validation/<?= $booking['picture'] ?>" width="50" height="50" style="border-radius: 50%;">
                                </td>
                                <td><?= htmlspecialchars($booking['fullname']) ?></td>
                                <td><?= htmlspecialchars($booking['subject_name']) ?></td>
                                <td><?= htmlspecialchars($booking['date']) ?></td>
                                <td><?= htmlspecialchars($booking['start_time']) ?></td>
                                <td><?= htmlspecialchars($booking['end_time']) ?></td>
                                <td><?= ucfirst($booking['status']) ?></td>
                                <td>
                                    <?php if ($booking['status'] === 'pending'): ?>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="book_id" value="<?= $booking['book_id'] ?>">
                                            <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                        </form>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="book_id" value="<?= $booking['book_id'] ?>">
                                            <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                        </form>
                                    <?php elseif ($booking['status'] === 'approved'): ?>
                                        <a href="chats.php?booking_id=<?= $booking['book_id'] ?>" class="btn btn-primary">Chat</a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="book_id" value="<?= $booking['book_id'] ?>">
                                            <button style="height: 39px;" type="submit" name="end_session" class="btn btn-danger">End tutor</button>
                                        </form>

                                    <?php else: ?>
                                        <a href="view_ratings.php?booking_id=<?= $booking['book_id'] ?>" class="btn btn-primary">View Ratings</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

</body>

</html>