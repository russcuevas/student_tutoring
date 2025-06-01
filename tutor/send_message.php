<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

$tutor_id = $_SESSION['tutor_id'];
$booking_id = $_POST['booking_id'] ?? null;
$message = trim($_POST['message'] ?? '');

if (!$booking_id || !$message) {
    die('Invalid input');
}

// Verify booking belongs to tutor
$stmt = $conn->prepare("SELECT * FROM tbl_booking WHERE book_id = ? AND tutor_id = ?");
$stmt->execute([$booking_id, $tutor_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die('Unauthorized');
}

// Insert chat message
$insert = $conn->prepare("INSERT INTO tbl_chats (booking_id, sender_id, message) VALUES (?, ?, ?)");
$insert->execute([$booking_id, $tutor_id, $message]);

// Redirect back to chat page
header("Location: chats.php?booking_id=$booking_id");
exit();
