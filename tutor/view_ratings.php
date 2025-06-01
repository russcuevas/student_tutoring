<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

$tutor_id = $_SESSION['tutor_id'];

if (!isset($_GET['booking_id'])) {
    echo "No booking specified.";
    exit();
}

$booking_id = intval($_GET['booking_id']);

// Fetch booking info with feedback and rating
$stmt = $conn->prepare("
    SELECT 
        b.*, 
        CONCAT(u.first_name, ' ', u.last_name) AS student_name,
        s.subject_name
    FROM tbl_booking b
    JOIN tbl_users u ON b.user_id = u.id
    JOIN tbl_subject s ON b.subject_id = s.id
    WHERE b.book_id = ? AND b.tutor_id = ?
");
$stmt->execute([$booking_id, $tutor_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo "Booking not found or you don't have permission to view this.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Ratings - Tutor Panel</title>
    <link rel="stylesheet" href="css/view_ratings.css" />
</head>

<body>
    <div class="container">
        <h2>Feedback & Rating for Booking #<?= htmlspecialchars($booking['book_id']) ?></h2>

        <p><strong>Student:</strong> <?= htmlspecialchars($booking['student_name']) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($booking['subject_name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($booking['date']) ?></p>
        <p><strong>Time:</strong> <?= date('h:i A', strtotime($booking['start_time'])) ?> - <?= date('h:i A', strtotime($booking['end_time'])) ?></p>
        <p><strong>Status:</strong> <?= ucfirst($booking['status']) ?></p>

        <hr>

        <h3>Rating:</h3>
        <?php if (!is_null($booking['rating'])): ?>
            <p class="rating"><?= str_repeat('⭐', $booking['rating']) ?> (<?= $booking['rating'] ?>/5)</p>
        <?php else: ?>
            <p>No rating yet.</p>
        <?php endif; ?>

        <h3>Feedback:</h3>
        <?php if (!empty($booking['feedback'])): ?>
            <div class="feedback-box"><?= nl2br(htmlspecialchars($booking['feedback'])) ?></div>
        <?php else: ?>
            <p>No feedback provided yet.</p>
        <?php endif; ?>

        <a href="my_student.php" class="back-link">&larr; Back to My Students</a>
    </div>
</body>

</html>