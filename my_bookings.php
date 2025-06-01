<?php
session_start();
include 'connection/database.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT 
        b.*,
        s.subject_name,
        CONCAT(t.first_name, ' ', t.last_name) AS tutor_name
    FROM tbl_booking b
    JOIN tbl_subject s ON b.subject_id = s.id
    JOIN tbl_tutor t ON b.tutor_id = t.id
    WHERE b.user_id = ?
    ORDER BY b.date DESC
");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Tutoring System</title>
    <link rel="stylesheet" href="assets/css/my_bookings.css">
</head>

<body>
    <div class="header">
        <h1>My Bookings</h1>
        <div>
            <span>Welcome, russelcvs</span>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <ul class="nav-menu">
                    <li><a href="student_dashboard.php">Dashboard</a></li>
                    <li><a href="find_tutor.php">Find a Tutor</a></li>
                    <li><a href="my_bookings.php" class="active">My Bookings</a></li>
                    <li><a href="my_profile.php">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">My Bookings</h2>

                <?php if (count($bookings) > 0): ?>
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Tutor</th>
                                <th style="text-align:left;">Subject</th>
                                <th style="text-align:left;">Start Date</th>
                                <th style="text-align:left;">Time</th>
                                <th style="text-align:left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= htmlspecialchars($booking['tutor_name']) ?></td>
                                    <td><?= htmlspecialchars($booking['subject_name']) ?></td>
                                    <td><?= htmlspecialchars($booking['date']) ?></td>
                                    <td><?= date('h:i A', strtotime($booking['start_time'])) ?> - <?= date('h:i A', strtotime($booking['end_time'])) ?></td>
                                    <td><strong><?= ucfirst($booking['status']) ?></strong></td>
                                    <td>
                                        <?php if ($booking['status'] === 'approved'): ?>
                                            <a href="chats.php?booking_id=<?= $booking['book_id'] ?>" class="btn btn-chat">Message tutor</a>
                                        <?php elseif ($booking['status'] === 'end session'): ?>
                                            <a href="rate_booking.php?booking_id=<?= $booking['book_id'] ?>" class="btn btn-rate">Add ratings/feedback</a>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have no bookings yet. <a href="find_tutor.php">Find a tutor now</a>.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>

</html>