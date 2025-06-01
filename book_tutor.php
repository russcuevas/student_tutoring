<?php
session_start();
include 'connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // adjust if different session key
    $tutor_id = $_POST['tutor_id'];
    $subject_id = $_POST['subject_id'];
    $availability_id = $_POST['availability_id'];

    // Fetch availability details
    $stmt = $conn->prepare("SELECT available_date, start_time, end_time FROM tbl_tutor_availability_subjects WHERE id = ?");
    $stmt->execute([$availability_id]);
    $availability = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($availability) {
        $date = $availability['available_date'];
        $start_time = $availability['start_time'];
        $end_time = $availability['end_time'];

        // Insert into tbl_booking
        $insert = $conn->prepare("INSERT INTO tbl_booking (user_id, tutor_id, subject_id, date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $insert->execute([$user_id, $tutor_id, $subject_id, $date, $start_time, $end_time]);

        header("Location: my_bookings.php?success=1");
        exit();
    } else {
        echo "Error: Availability not found.";
    }
}
