<?php
session_start();
include 'connection/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$user_id = $_SESSION['user_id'];

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die("Booking ID is required.");
}

$stmt = $conn->prepare("
    SELECT * FROM tbl_booking 
    WHERE book_id = ? AND status = 'approved' AND (user_id = ? OR tutor_id = ?)
");
$stmt->execute([$booking_id, $user_id, $user_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Unauthorized or booking not approved.");
}

// Fetch tutor info for display
$tutor_stmt = $conn->prepare("SELECT first_name, last_name FROM tbl_tutor WHERE id = ?");
$tutor_stmt->execute([$booking['tutor_id']]);
$tutor = $tutor_stmt->fetch();

$tutor_fullname = htmlspecialchars($tutor['first_name'] . ' ' . $tutor['last_name']);

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chat with <?= $tutor_fullname ?></title>
</head>

<body>
    <h3>Chat with <?= $tutor_fullname ?></h3>
    <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:auto;">
        <?php foreach ($messages as $msg): ?>
            <div style="margin-bottom:10px;">
                <strong>
                    <?= $msg['sender_id'] == $user_id ? "You" : $tutor_fullname ?>:
                </strong>
                <?= htmlspecialchars($msg['message']) ?>
                <div style="font-size:10px; color:gray;"><?= $msg['timestamp'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST" action="send_message.php">
        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking_id) ?>">
        <textarea name="message" required style="width:100%; height:50px;" placeholder="Type your message..."></textarea>
        <button type="submit">Send</button>
        <a href="my_bookings.php">Go back</a>
    </form>
</body>

</html>