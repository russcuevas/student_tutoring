<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

$tutor_id = $_SESSION['tutor_id'];
$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die("Booking ID is required.");
}

$stmt = $conn->prepare("
    SELECT * FROM tbl_booking 
    WHERE book_id = ? AND status = 'approved' AND tutor_id = ?
");
$stmt->execute([$booking_id, $tutor_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Unauthorized or booking not approved.");
}

$student_stmt = $conn->prepare("SELECT id, first_name, last_name FROM tbl_users WHERE id = ?");
$student_stmt->execute([$booking['user_id']]);
$student = $student_stmt->fetch();

$msg_stmt = $conn->prepare("
    SELECT c.*, 
           COALESCE(u.first_name, t.first_name) AS first_name,
           COALESCE(u.last_name, t.last_name) AS last_name
    FROM tbl_chats c
    LEFT JOIN tbl_users u ON c.sender_id = u.id
    LEFT JOIN tbl_tutor t ON c.sender_id = t.id
    WHERE c.booking_id = ?
    ORDER BY c.timestamp ASC
");
$msg_stmt->execute([$booking_id]);
$messages = $msg_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chat with <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .chat-container {
            border: 1px solid #ccc;
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <body>
        <h3>Chat with <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h3>
        <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:auto;">
            <?php foreach ($messages as $msg):
                $isMine = ((int)$msg['sender_id'] === (int)$tutor_id);
                $senderName = $isMine ? "You" : htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']);
                $messageClass = $isMine ? "my-message" : "other-message";
            ?>
                <div class="message <?= $messageClass ?>">
                    <div class="sender"><?= $senderName ?>:</div>
                    <div class="text"><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
                    <div class="timestamp"><?= $msg['timestamp'] ?></div><br>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="send_message.php">
            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking_id) ?>">
            <textarea name="message" required placeholder="Type your message here..." style="width:100%; height:50px;"></textarea>
            <button type="submit">Send</button>
            <a href="my_student.php">Go back</a>

        </form>
    </body>
</body>

</html>