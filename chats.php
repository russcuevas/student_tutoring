<?php
session_start();
include 'connection/database.php';

$user_id = $_SESSION['user_id']; // either student or tutor

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die("Booking ID is required.");
}

// Check if booking is approved and user is part of it
$stmt = $conn->prepare("
    SELECT * FROM tbl_booking 
    WHERE book_id = ? AND status = 'approved' AND (user_id = ? OR tutor_id = ?)
");
$stmt->execute([$booking_id, $user_id, $user_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Unauthorized or booking not approved.");
}

// Fetch chat messages
$msg_stmt = $conn->prepare("
    SELECT * FROM tbl_chats 
    WHERE booking_id = ? 
    ORDER BY timestamp ASC
");
$msg_stmt->execute([$booking_id]);
$messages = $msg_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Chat with Tutor</h3>
    <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:auto;">
        <?php foreach ($messages as $msg): ?>
            <div style="margin-bottom:10px;">
                <strong><?= $msg['sender_id'] == $user_id ? "You" : "Tutor" ?>:</strong>
                <?= htmlspecialchars($msg['message']) ?>
                <div style="font-size:10px; color:gray;"><?= $msg['timestamp'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST" action="send_message.php">
        <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
        <textarea name="message" required style="width:100%; height:50px;"></textarea>
        <button type="submit">Send</button>
    </form>

</body>

</html>