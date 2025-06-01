<?php
session_start();
include 'connection/database.php';

$user_id = $_SESSION['user_id'];
$booking_id = $_POST['booking_id'];
$message = trim($_POST['message']);

if ($message === '') {
    die("Message is required.");
}

$stmt = $conn->prepare("
    SELECT * FROM tbl_booking 
    WHERE book_id = ? AND status = 'approved' AND (user_id = ? OR tutor_id = ?)
");
$stmt->execute([$booking_id, $user_id, $user_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Unauthorized access or booking not approved.");
}

$insert = $conn->prepare("INSERT INTO tbl_chats (booking_id, sender_id, message) VALUES (?, ?, ?)");
$insert->execute([$booking_id, $user_id, $message]);

header("Location: chats.php?booking_id=$booking_id");
exit;
